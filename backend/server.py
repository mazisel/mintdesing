from fastapi import FastAPI, APIRouter, HTTPException, Depends
from fastapi.security import HTTPBearer, HTTPAuthorizationCredentials
from dotenv import load_dotenv
from starlette.middleware.cors import CORSMiddleware
from motor.motor_asyncio import AsyncIOMotorClient
import os
import logging
from pathlib import Path
from pydantic import BaseModel, Field
from typing import List, Optional
import uuid
from datetime import datetime, timezone
import bcrypt
import jwt
from enum import Enum
import qrcode
import io
import base64
from fastapi.responses import Response

ROOT_DIR = Path(__file__).parent
load_dotenv(ROOT_DIR / '.env')

# MongoDB connection
mongo_url = os.environ['MONGO_URL']
client = AsyncIOMotorClient(mongo_url)
db = client[os.environ['DB_NAME']]

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

@api_router.get("/quotes/{quote_id}/swiss-qr")
async def get_swiss_qr_code(quote_id: str, current_user: User = Depends(get_current_user)):
    """Generate Swiss QR code for a quote"""
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
            "phone": "+41 31 55 55 55",
            "email": "info@ammann-transport.ch",
            "iban": "CH93 0076 2011 6238 5295 7",
        }
    
    # Generate Swiss QR Code payload according to Swiss Payment Standards
    # Format: https://www.paymentstandards.ch/dam/downloads/ig-qr-bill-en.pdf
    
    # Clean IBAN (remove spaces)
    iban = company.get('iban', 'CH93 0076 2011 6238 5295 7').replace(' ', '')
    
    # Build QR code data according to Swiss QR Bill standard
    qr_data_lines = [
        "SPC",  # QR Type
        "0200",  # Version
        "1",  # Coding Type (1 = UTF-8)
        iban,  # IBAN
        "K",  # Creditor Address Type (K = Combined, S = Structured)
        company.get('name', 'Ammann & Co Transport GmbH')[:70],  # Name (max 70 chars)
        company.get('address', 'Str. Bern')[:70],  # Street or Address Line 1
        "",  # Building number or Address Line 2
        "3000",  # Postal code
        "Bern",  # Town
        "CH",  # Country
        "",  # Ultimate Creditor Address Type (empty if not used)
        "",  # Ultimate Creditor Name
        "",  # Ultimate Creditor Street
        "",  # Ultimate Creditor Building
        "",  # Ultimate Creditor Postal
        "",  # Ultimate Creditor Town
        "",  # Ultimate Creditor Country
        f"{quote_obj.grand_total:.2f}",  # Amount
        "CHF",  # Currency
        "K",  # Ultimate Debtor Address Type
        quote_obj.customer.company_name[:70],  # Debtor Name
        quote_obj.customer.address[:70],  # Debtor Address
        "",  # Debtor Building
        quote_obj.customer.postal_code[:16],  # Debtor Postal
        "",  # Debtor Town
        "CH",  # Debtor Country
        "QRR",  # Reference Type (QRR, SCOR, or NON)
        "",  # Reference (empty for NON type, or QR reference number)
        f"Transport-Offerte {quote_obj.quote_number}",  # Unstructured Message
        "EPD",  # Trailer (End Payment Data)
        "",  # Bill information
        "",  # Alternative procedure parameter 1
        "",  # Alternative procedure parameter 2
    ]
    
    qr_data = "\r\n".join(qr_data_lines)
    
    # Generate QR code
    qr = qrcode.QRCode(
        version=None,
        error_correction=qrcode.constants.ERROR_CORRECT_M,
        box_size=10,
        border=4,
    )
    qr.add_data(qr_data)
    qr.make(fit=True)
    
    # Create image
    img = qr.make_image(fill_color="black", back_color="white")
    
    # Convert to base64
    img_buffer = io.BytesIO()
    img.save(img_buffer, format='PNG')
    img_buffer.seek(0)
    img_base64 = base64.b64encode(img_buffer.getvalue()).decode()
    
    return {
        "qr_code": f"data:image/png;base64,{img_base64}",
        "payment_info": {
            "iban": iban,
            "amount": f"{quote_obj.grand_total:.2f}",
            "currency": "CHF",
            "creditor": company.get('name', 'Ammann & Co Transport GmbH'),
            "reference": f"Transport-Offerte {quote_obj.quote_number}"
        }
    }

# Include the router in the main app
app.include_router(api_router)

app.add_middleware(
    CORSMiddleware,
    allow_credentials=True,
    allow_origins=os.environ.get('CORS_ORIGINS', '*').split(','),
    allow_methods=["*"],
    allow_headers=["*"],
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
