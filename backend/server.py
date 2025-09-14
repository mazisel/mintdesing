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

class CompanyUpdate(BaseModel):
    name: str
    address: str
    phone: str
    email: str
    website: str
    logo_url: Optional[str] = None

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
            "logo_url": "https://ammanncotransport.ch/wp-content/uploads/2025/09/WhatsApp_Bild_2025-09-03_um_10.30.52_21275bd5-removebg-preview.png"
        }
    return Company(**company)

@api_router.put("/company")
async def update_company(company_data: CompanyUpdate, current_user: User = Depends(get_current_user)):
    if current_user.role != UserRole.ADMIN:
        raise HTTPException(status_code=403, detail="Admin access required")
    
    company_dict = company_data.dict()
    await db.company.replace_one({}, company_dict, upsert=True)
    return {"message": "Company updated successfully"}

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