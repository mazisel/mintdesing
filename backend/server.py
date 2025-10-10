from fastapi import FastAPI, APIRouter, HTTPException, Depends
from fastapi.security import HTTPBearer, HTTPAuthorizationCredentials
from dotenv import load_dotenv
from starlette.middleware.cors import CORSMiddleware
from motor.motor_asyncio import AsyncIOMotorClient
import os
import logging
from pathlib import Path
from pydantic import BaseModel, Field
from typing import List, Optional, Tuple
import uuid
from datetime import datetime, timezone
import bcrypt
import jwt
from enum import Enum
import io
import base64
from fastapi.responses import Response
from io import BytesIO, StringIO
from qrbill import QRBill
import socket
from urllib.parse import urlparse, urlunparse

ROOT_DIR = Path(__file__).parent
load_dotenv(ROOT_DIR / '.env')

def _ensure_resolvable_mongo_url(url: str) -> str:
    """If configured host cannot be resolved (common when running outside Docker),
    fall back to an override host or alternate URL when explicitly provided."""
    try:
        parsed = urlparse(url)
    except Exception:
        logging.warning("Invalid Mongo URL provided, fallback to default localhost URL")
        return "mongodb://admin:password123@127.0.0.1:27017/mintdegisn?authSource=admin"

    host = parsed.hostname
    if not host:
        return url

    try:
        socket.gethostbyname(host)
        return url
    except socket.gaierror:
        fallback_url = os.environ.get('MONGO_URL_FALLBACK', '').strip()
        if fallback_url:
            logging.warning(
                "Mongo host '%s' could not be resolved. Falling back to explicit MONGO_URL_FALLBACK.",
                host
            )
            return fallback_url

        fallback_host = os.environ.get('MONGO_HOST_FALLBACK', '').strip()
        if not fallback_host:
            fallback_host = '127.0.0.1'
            logging.warning(
                "Mongo host '%s' could not be resolved. Falling back to default host '%s'. "
                "Set MONGO_HOST_FALLBACK or MONGO_URL_FALLBACK to override this behaviour.",
                host,
                fallback_host
            )
        else:
            logging.warning(
                "Mongo host '%s' could not be resolved. Falling back to host override '%s'.",
                host,
                fallback_host
            )

        if fallback_host:
            userinfo = ''
            if parsed.username:
                userinfo = parsed.username
                if parsed.password:
                    userinfo += f":{parsed.password}"
                userinfo += '@'
            port = f":{parsed.port}" if parsed.port else ''
            netloc = f"{userinfo}{fallback_host}{port}"
            fallback_url = urlunparse((
                parsed.scheme,
                netloc,
                parsed.path,
                parsed.params,
                parsed.query,
                parsed.fragment
            ))
            return fallback_url

        logging.error(
            "Mongo host '%s' could not be resolved and no fallback configured. "
            "Set MONGO_HOST_FALLBACK or MONGO_URL_FALLBACK to override, or use "
            "a resolvable hostname/IP in MONGO_URL.",
            host
        )
        return url

def _parse_origin_list(raw: str) -> List[str]:
    """Split comma separated origins and strip whitespace."""
    if not raw:
        return []
    return [origin.strip().rstrip('/') for origin in raw.split(',') if origin.strip()]

def _determine_cors_policy() -> Tuple[List[str], bool, Optional[str]]:
    """
    Returns a tuple of (origins, allow_credentials, origin_regex).
    Supports the following env vars:
      - CORS_ORIGINS: comma separated list
      - CORS_EXTRA_ORIGINS: optional comma separated list appended
      - CORS_ALLOW_ALL / CORS_ALLOW_ORIGIN_REGEX: wildcard fallback options
      - CORS_ALLOW_CREDENTIALS: force credentials (default true unless wildcard)
      - PUBLIC_BASE_URL / PUBLIC_FRONTEND_HOST / PUBLIC_FRONTEND_PORT: convenience extras
    """
    allow_all_flag = os.environ.get('CORS_ALLOW_ALL', '').lower() in ('1', 'true', 'yes')
    raw_regex = os.environ.get('CORS_ALLOW_ORIGIN_REGEX', '').strip()
    if raw_regex.lower() == 'none':
        raw_regex = ''
    regex = raw_regex or None

    origins = _parse_origin_list(os.environ.get('CORS_ORIGINS', ''))
    origins += _parse_origin_list(os.environ.get('CORS_EXTRA_ORIGINS', ''))

    public_base = os.environ.get('PUBLIC_BASE_URL', '').strip()
    if public_base:
        origins.append(public_base.rstrip('/'))

    frontend_host = os.environ.get('PUBLIC_FRONTEND_HOST', '').strip()
    frontend_port = os.environ.get('PUBLIC_FRONTEND_PORT', '').strip()
    if frontend_host:
        scheme_list = ['http://', 'https://'] if not frontend_host.startswith(('http://', 'https://')) else ['']
        for scheme in scheme_list:
            origin = f"{scheme}{frontend_host}"
            if frontend_port and ':' not in frontend_host:
                origin = f"{origin}:{frontend_port}"
            origins.append(origin.rstrip('/'))

    origins = [o for o in origins if o]
    # Deduplicate while preserving order
    seen = set()
    deduped = []
    for origin in origins:
        if origin not in seen:
            deduped.append(origin)
            seen.add(origin)
    origins = deduped

    if allow_all_flag or '*' in origins or regex == '*':
        logging.warning("CORS wildcard enabled; allowing all origins without credentials.")
        return ['*'], False, None

    allow_credentials_env = os.environ.get('CORS_ALLOW_CREDENTIALS', 'true').lower()
    allow_credentials = allow_credentials_env in ('1', 'true', 'yes')

    if not regex:
        default_ip_regex = os.environ.get('CORS_DEFAULT_IP_REGEX', '').strip()
        if default_ip_regex.lower() == 'none':
            default_ip_regex = ''
        if not default_ip_regex:
            default_ip_regex = r"^https?://(?:[0-9]{1,3}\.){3}[0-9]{1,3}(?::\d+)?$"
        regex = default_ip_regex
        logging.info("CORS origin regex set to %s", regex)

    if not origins:
        # Sensible defaults for development plus IPv4-based hosts
        origins = ['http://localhost:3000', 'http://localhost:3005']
        logging.info(
            "CORS_ORIGINS not set; using default local origins %s and IP regex %s",
            origins,
            regex
        )

    return origins, allow_credentials, regex

# MongoDB connection
mongo_url = os.environ.get(
    'MONGO_URL',
    'mongodb://admin:password123@mongodb:27017/mintdegisn?authSource=admin'
)
mongo_url = _ensure_resolvable_mongo_url(mongo_url)
client = AsyncIOMotorClient(mongo_url)
db_name = os.environ.get('DB_NAME', 'mintdegisn')
db = client[db_name]

# Create the main app without a prefix
app = FastAPI()

# Create a router with the /api prefix
api_router = APIRouter(prefix="/api")

# Security
security = HTTPBearer()
JWT_SECRET = os.environ.get('JWT_SECRET', 'your-secret-key-change-in-production')

# Enums
class UserRole(str, Enum):
    ADMIN = "admin"
    MEMBER = "member"

# Models
class User(BaseModel):
    id: str = Field(default_factory=lambda: str(uuid.uuid4()))
    email: str
    name: str
    role: UserRole = UserRole.MEMBER
    created_at: datetime = Field(default_factory=lambda: datetime.now(timezone.utc))

class UserCreate(BaseModel):
    email: str
    name: str
    password: str
    role: UserRole = UserRole.MEMBER

class UserLogin(BaseModel):
    email: str
    password: str

class Company(BaseModel):
    id: str = Field(default_factory=lambda: str(uuid.uuid4()))
    name: str
    address: str
    phone: str
    email: str
    website: str
    logo_url: Optional[str] = None
    iban: Optional[str] = "CH93 0076 2011 6238 5295 7"
    bank_name: Optional[str] = "UBS Switzerland AG"
    swift_bic: Optional[str] = "UBSWCHZH80A"

class CompanyUpdate(BaseModel):
    name: str
    address: str
    phone: str
    email: str
    website: str
    logo_url: Optional[str] = None
    iban: Optional[str] = None
    bank_name: Optional[str] = None
    swift_bic: Optional[str] = None

class SystemSettings(BaseModel):
    id: str = Field(default_factory=lambda: str(uuid.uuid4()))
    title: str = "Transport Offerte System"
    updated_at: datetime = Field(default_factory=lambda: datetime.now(timezone.utc))

class SystemSettingsUpdate(BaseModel):
    title: str

class TransportDetail(BaseModel):
    pickup_date: str
    pickup_time: str
    pickup_location: str
    delivery_date: str
    delivery_time: str
    delivery_location: str
    shipment_type: str
    total_weight: str
    service_type: str
    transport_type: str

class PriceItem(BaseModel):
    description: str
    quantity: str
    unit_price: float
    total_net: float
    vat_rate: float
    total_incl_vat: float

class Customer(BaseModel):
    company_name: str
    address: str
    postal_code: str

class Quote(BaseModel):
    id: str = Field(default_factory=lambda: str(uuid.uuid4()))
    quote_number: str
    date: str
    customer: Customer
    transport_details: TransportDetail
    price_items: List[PriceItem]
    subtotal: float
    vat_total: float
    grand_total: float
    created_by: str
    created_at: datetime = Field(default_factory=lambda: datetime.now(timezone.utc))

class QuoteCreate(BaseModel):
    customer: Customer
    transport_details: TransportDetail
    price_items: List[PriceItem]
    subtotal: float
    vat_total: float
    grand_total: float

# Helper functions
def hash_password(password: str) -> str:
    return bcrypt.hashpw(password.encode('utf-8'), bcrypt.gensalt()).decode('utf-8')

def verify_password(password: str, hashed: str) -> bool:
    return bcrypt.checkpw(password.encode('utf-8'), hashed.encode('utf-8'))

def create_jwt_token(user_id: str, email: str, role: str) -> str:
    payload = {
        'user_id': user_id,
        'email': email,
        'role': role,
        'exp': datetime.now(timezone.utc).timestamp() + 24 * 3600  # 24 hours
    }
    return jwt.encode(payload, JWT_SECRET, algorithm='HS256')

async def get_current_user(credentials: HTTPAuthorizationCredentials = Depends(security)):
    try:
        payload = jwt.decode(credentials.credentials, JWT_SECRET, algorithms=['HS256'])
        user_id = payload.get('user_id')
        if not user_id:
            raise HTTPException(status_code=401, detail="Invalid token")
        
        user_data = await db.users.find_one({"id": user_id})
        if not user_data:
            raise HTTPException(status_code=401, detail="User not found")
        
        return User(**user_data)
    except jwt.ExpiredSignatureError:
        raise HTTPException(status_code=401, detail="Token expired")
    except jwt.InvalidTokenError:
        raise HTTPException(status_code=401, detail="Invalid token")

def generate_quote_number():
    return f"2025-{str(uuid.uuid4())[:8].upper()}"

# Auth routes
@api_router.post("/auth/register")
async def register_user(user_data: UserCreate):
    # Check if user exists
    existing_user = await db.users.find_one({"email": user_data.email})
    if existing_user:
        raise HTTPException(status_code=400, detail="Email already registered")
    
    # Hash password
    hashed_password = hash_password(user_data.password)
    
    # Create user
    user_dict = user_data.dict()
    user_dict.pop('password')
    user = User(**user_dict)
    
    # Save to DB
    user_with_password = user.dict()
    user_with_password['password'] = hashed_password
    await db.users.insert_one(user_with_password)
    
    # Create token
    token = create_jwt_token(user.id, user.email, user.role)
    
    return {"user": user, "token": token}

@api_router.post("/auth/login")
async def login_user(login_data: UserLogin):
    # Find user
    user_data = await db.users.find_one({"email": login_data.email})
    if not user_data:
        raise HTTPException(status_code=401, detail="Invalid credentials")
    
    # Verify password
    if not verify_password(login_data.password, user_data['password']):
        raise HTTPException(status_code=401, detail="Invalid credentials")
    
    user = User(**user_data)
    token = create_jwt_token(user.id, user.email, user.role)
    
    return {"user": user, "token": token}

# User management routes
@api_router.get("/users", response_model=List[User])
async def get_users(current_user: User = Depends(get_current_user)):
    if current_user.role != UserRole.ADMIN:
        raise HTTPException(status_code=403, detail="Admin access required")
    
    users = await db.users.find().to_list(1000)
    return [User(**user) for user in users]

@api_router.delete("/users/{user_id}")
async def delete_user(user_id: str, current_user: User = Depends(get_current_user)):
    if current_user.role != UserRole.ADMIN:
        raise HTTPException(status_code=403, detail="Admin access required")
    
    result = await db.users.delete_one({"id": user_id})
    if result.deleted_count == 0:
        raise HTTPException(status_code=404, detail="User not found")
    
    return {"message": "User deleted successfully"}

# Company routes
@api_router.get("/company")
async def get_company(current_user: User = Depends(get_current_user)):
    company = await db.company.find_one()
    if not company:
        # Return default company with new logo
        return {
            "name": "Ammann & Co Transport GmbH",
            "address": "Str. Bern\nTel: +41 31 55 55 55\ninfo@ammann-transport.ch\nwww.ammann-transport.ch",
            "phone": "+41 31 55 55 55",
            "email": "info@ammann-transport.ch",
            "website": "www.ammann-transport.ch",
            "logo_url": "https://ammanncotransport.ch/wp-content/uploads/2025/09/WhatsApp_Bild_2025-09-03_um_10.30.52_21275bd5-removebg-preview.png",
            "iban": "CH93 0076 2011 6238 5295 7",
            "bank_name": "UBS Switzerland AG",
            "swift_bic": "UBSWCHZH80A"
        }
    return Company(**company)

@api_router.put("/company")
async def update_company(company_data: CompanyUpdate, current_user: User = Depends(get_current_user)):
    if current_user.role != UserRole.ADMIN:
        raise HTTPException(status_code=403, detail="Admin access required")
    
    company_dict = company_data.dict()
    await db.company.replace_one({}, company_dict, upsert=True)
    return {"message": "Company updated successfully"}

# System settings routes
@api_router.get("/system-settings")
async def get_system_settings(current_user: User = Depends(get_current_user)):
    settings = await db.system_settings.find_one()
    if not settings:
        # Return default settings
        return SystemSettings()
    return SystemSettings(**settings)

@api_router.put("/system-settings")
async def update_system_settings(settings_data: SystemSettingsUpdate, current_user: User = Depends(get_current_user)):
    if current_user.role != UserRole.ADMIN:
        raise HTTPException(status_code=403, detail="Admin access required")
    
    settings_dict = settings_data.dict()
    settings_dict['updated_at'] = datetime.now(timezone.utc)
    settings_dict['id'] = str(uuid.uuid4())
    
    await db.system_settings.replace_one({}, settings_dict, upsert=True)
    return {"message": "System settings updated successfully"}

# Quote routes
@api_router.post("/quotes", response_model=Quote)
async def create_quote(quote_data: QuoteCreate, current_user: User = Depends(get_current_user)):
    quote_dict = quote_data.dict()
    quote = Quote(
        quote_number=generate_quote_number(),
        date=datetime.now(timezone.utc).strftime("%d.%m.%Y"),
        created_by=current_user.id,
        **quote_dict
    )
    
    await db.quotes.insert_one(quote.dict())
    return quote

@api_router.get("/quotes", response_model=List[Quote])
async def get_quotes(current_user: User = Depends(get_current_user)):
    quotes = await db.quotes.find().sort("created_at", -1).to_list(1000)
    return [Quote(**quote) for quote in quotes]

@api_router.get("/quotes/{quote_id}", response_model=Quote)
async def get_quote(quote_id: str, current_user: User = Depends(get_current_user)):
    quote = await db.quotes.find_one({"id": quote_id})
    if not quote:
        raise HTTPException(status_code=404, detail="Quote not found")
    return Quote(**quote)

@api_router.delete("/quotes/{quote_id}")
async def delete_quote(quote_id: str, current_user: User = Depends(get_current_user)):
    result = await db.quotes.delete_one({"id": quote_id})
    if result.deleted_count == 0:
        raise HTTPException(status_code=404, detail="Quote not found")
    return {"message": "Quote deleted successfully"}

@api_router.get("/debug/swiss-qr-version")
async def get_swiss_qr_version():
    """Debug endpoint to check Swiss QR implementation version"""
    import qrbill
    return {
        "version": "5.0-QRBILL-SVG",
        "implementation": "qrbill library (Official Swiss QR Bill - SVG output)",
        "qrbill_version": qrbill.__version__,
        "output_format": "SVG (base64 encoded)",
        "timestamp": datetime.now(timezone.utc).isoformat(),
        "status": "OFFICIAL_PACKAGE",
        "features": [
            "Swiss Payment Standards 2.0 compliant",
            "Swiss cross in QR code",
            "Full payment information",
            "Browser compatible (SVG)"
        ]
    }

@api_router.get("/quotes/{quote_id}/swiss-qr")
async def get_swiss_qr_code(quote_id: str, current_user: User = Depends(get_current_user)):
    """Generate Swiss QR Bill using official qrbill library"""
    logger.info(f"🇨🇭 Swiss QR generation started (qrbill library) - Quote ID: {quote_id}")
    
    try:
        # Fetch quote
        quote = await db.quotes.find_one({"id": quote_id})
        if not quote:
            raise HTTPException(status_code=404, detail="Quote not found")
        
        quote_obj = Quote(**quote)
        
        # Fetch company info
        company = await db.company.find_one()
        if not company:
            company = {
                "name": "Ammann & Co Transport GmbH",
                "address": "Str. Bern",
                "iban": "CH93 0076 2011 6238 5295 7",
            }
        
        # Clean IBAN
        iban = company.get('iban', 'CH93 0076 2011 6238 5295 7').replace(' ', '')
        
        # Parse address
        address_parts = company.get('address', 'Str. Bern').split('\n')
        street = address_parts[0] if address_parts else 'Str. Bern'
        
        # Create QRBill using dict format (qrbill accepts dict)
        my_bill = QRBill(
            account=iban,
            creditor={
                'name': company.get('name', 'Ammann & Co Transport GmbH')[:70],
                'street': street[:70],
                'pcode': '3000',
                'city': 'Bern',
                'country': 'CH'
            },
            debtor={
                'name': quote_obj.customer.company_name[:70],
                'street': quote_obj.customer.address[:70],
                'pcode': quote_obj.customer.postal_code[:16] if quote_obj.customer.postal_code else '8000',
                'city': 'Schweiz',
                'country': 'CH'
            },
            amount='%.2f' % quote_obj.grand_total,
            currency='CHF',
            additional_information=f"Transport-Offerte {quote_obj.quote_number}",
            language='de'
        )
        
        # Generate SVG (qrbill creates professional Swiss QR Bill)
        svg_buffer = StringIO()
        my_bill.as_svg(svg_buffer)
        svg_buffer.seek(0)
        svg_content = svg_buffer.read()
        
        # Encode SVG to base64 for data URI
        svg_bytes = svg_content.encode('utf-8')
        svg_base64 = base64.b64encode(svg_bytes).decode()
        
        logger.info(f"✅ Swiss QR Bill (SVG) generated - Size: {len(svg_content)} chars, IBAN: {iban}")
        
        return {
            "qr_code": f"data:image/svg+xml;base64,{svg_base64}",
            "qr_code_svg": svg_content,  # Raw SVG for direct use
            "payment_info": {
                "iban": iban,
                "amount": f"{quote_obj.grand_total:.2f}",
                "currency": "CHF",
                "creditor": company.get('name', 'Ammann & Co Transport GmbH'),
                "reference": f"Transport-Offerte {quote_obj.quote_number}"
            }
        }
        
    except Exception as e:
        logger.error(f"❌ Error generating Swiss QR Bill: {str(e)}", exc_info=True)
        raise HTTPException(status_code=500, detail=f"Swiss QR generation error: {str(e)}")

# Include the router in the main app
app.include_router(api_router)

cors_origins, cors_allow_credentials, cors_regex = _determine_cors_policy()
logging.info(
    "Configuring CORS. Origins: %s, Allow credentials: %s, Regex: %s",
    cors_origins,
    cors_allow_credentials,
    cors_regex
)

app.add_middleware(
    CORSMiddleware,
    allow_credentials=cors_allow_credentials,
    allow_origins=cors_origins,
    allow_methods=["*"],
    allow_headers=["*"],
    allow_origin_regex=cors_regex
)

# Configure logging
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(name)s - %(levelname)s - %(message)s'
)
logger = logging.getLogger(__name__)

@app.on_event("shutdown")
async def shutdown_db_client():
    client.close()
