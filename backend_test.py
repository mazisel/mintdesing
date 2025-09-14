import requests
import sys
import json
from datetime import datetime

class TransportQuoteAPITester:
    def __init__(self, base_url="https://custom-pdf-maker.preview.emergentagent.com/api"):
        self.base_url = base_url
        self.admin_token = None
        self.member_token = None
        self.tests_run = 0
        self.tests_passed = 0
        self.created_user_id = None
        self.created_quote_id = None

    def run_test(self, name, method, endpoint, expected_status, data=None, token=None):
        """Run a single API test"""
        url = f"{self.base_url}/{endpoint}"
        headers = {'Content-Type': 'application/json'}
        if token:
            headers['Authorization'] = f'Bearer {token}'

        self.tests_run += 1
        print(f"\n🔍 Testing {name}...")
        print(f"   URL: {url}")
        
        try:
            if method == 'GET':
                response = requests.get(url, headers=headers)
            elif method == 'POST':
                response = requests.post(url, json=data, headers=headers)
            elif method == 'PUT':
                response = requests.put(url, json=data, headers=headers)
            elif method == 'DELETE':
                response = requests.delete(url, headers=headers)

            success = response.status_code == expected_status
            if success:
                self.tests_passed += 1
                print(f"✅ Passed - Status: {response.status_code}")
                try:
                    response_data = response.json()
                    if isinstance(response_data, dict) and len(str(response_data)) < 500:
                        print(f"   Response: {response_data}")
                    return True, response_data
                except:
                    return True, {}
            else:
                print(f"❌ Failed - Expected {expected_status}, got {response.status_code}")
                try:
                    error_data = response.json()
                    print(f"   Error: {error_data}")
                except:
                    print(f"   Error: {response.text}")
                return False, {}

        except Exception as e:
            print(f"❌ Failed - Error: {str(e)}")
            return False, {}

    def test_admin_login(self):
        """Test admin login"""
        success, response = self.run_test(
            "Admin Login",
            "POST",
            "auth/login",
            200,
            data={"email": "admin@example.com", "password": "admin123"}
        )
        if success and 'token' in response:
            self.admin_token = response['token']
            print(f"   Admin token obtained: {self.admin_token[:20]}...")
            return True
        return False

    def test_invalid_login(self):
        """Test invalid login credentials"""
        success, _ = self.run_test(
            "Invalid Login",
            "POST",
            "auth/login",
            401,
            data={"email": "invalid@example.com", "password": "wrongpass"}
        )
        return success

    def test_register_user(self):
        """Test user registration"""
        test_email = f"test_member_{datetime.now().strftime('%H%M%S')}@example.com"
        success, response = self.run_test(
            "Register New User",
            "POST",
            "auth/register",
            200,
            data={
                "email": test_email,
                "name": "Test Member",
                "password": "testpass123",
                "role": "member"
            }
        )
        if success and 'token' in response:
            self.member_token = response['token']
            if 'user' in response:
                self.created_user_id = response['user']['id']
            print(f"   Member token obtained: {self.member_token[:20]}...")
            return True
        return False

    def test_get_users_admin(self):
        """Test getting users list (admin only)"""
        success, response = self.run_test(
            "Get Users (Admin)",
            "GET",
            "users",
            200,
            token=self.admin_token
        )
        if success and isinstance(response, list):
            print(f"   Found {len(response)} users")
            return True
        return False

    def test_get_users_member(self):
        """Test getting users list as member (should fail)"""
        success, _ = self.run_test(
            "Get Users (Member - Should Fail)",
            "GET",
            "users",
            403,
            token=self.member_token
        )
        return success

    def test_get_company(self):
        """Test getting company information"""
        success, response = self.run_test(
            "Get Company Info",
            "GET",
            "company",
            200,
            token=self.admin_token
        )
        if success and 'name' in response:
            print(f"   Company: {response['name']}")
            return True
        return False

    def test_create_quote(self):
        """Test creating a quote"""
        quote_data = {
            "customer": {
                "company_name": "Test Transport GmbH",
                "address": "Teststraße 123, 12345 Berlin",
                "postal_code": "12345"
            },
            "transport_details": {
                "pickup_date": "15.02.2025",
                "pickup_time": "08:00",
                "pickup_location": "Berlin Hauptbahnhof",
                "delivery_date": "16.02.2025",
                "delivery_time": "14:00",
                "delivery_location": "München Hauptbahnhof",
                "shipment_type": "Paletten",
                "total_weight": "2500 kg",
                "service_type": "Express",
                "transport_type": "LKW"
            },
            "price_items": [
                {
                    "description": "Transport Berlin-München",
                    "quantity": "1",
                    "unit_price": 850.0,
                    "total_net": 850.0,
                    "vat_rate": 19.0,
                    "total_incl_vat": 1011.5
                },
                {
                    "description": "Express-Zuschlag",
                    "quantity": "1",
                    "unit_price": 150.0,
                    "total_net": 150.0,
                    "vat_rate": 19.0,
                    "total_incl_vat": 178.5
                }
            ],
            "subtotal": 1000.0,
            "vat_total": 190.0,
            "grand_total": 1190.0
        }
        
        success, response = self.run_test(
            "Create Quote",
            "POST",
            "quotes",
            200,
            data=quote_data,
            token=self.admin_token
        )
        if success and 'id' in response:
            self.created_quote_id = response['id']
            print(f"   Quote created with ID: {self.created_quote_id}")
            print(f"   Quote number: {response.get('quote_number', 'N/A')}")
            return True
        return False

    def test_get_quotes(self):
        """Test getting quotes list"""
        success, response = self.run_test(
            "Get Quotes List",
            "GET",
            "quotes",
            200,
            token=self.admin_token
        )
        if success and isinstance(response, list):
            print(f"   Found {len(response)} quotes")
            return True
        return False

    def test_get_single_quote(self):
        """Test getting a single quote by ID"""
        if not self.created_quote_id:
            print("❌ No quote ID available for testing")
            return False
            
        success, response = self.run_test(
            "Get Single Quote",
            "GET",
            f"quotes/{self.created_quote_id}",
            200,
            token=self.admin_token
        )
        if success and 'id' in response:
            print(f"   Retrieved quote: {response.get('quote_number', 'N/A')}")
            return True
        return False

    def test_delete_quote(self):
        """Test deleting a quote"""
        if not self.created_quote_id:
            print("❌ No quote ID available for testing")
            return False
            
        success, _ = self.run_test(
            "Delete Quote",
            "DELETE",
            f"quotes/{self.created_quote_id}",
            200,
            token=self.admin_token
        )
        return success

    def test_unauthorized_access(self):
        """Test accessing protected endpoints without token"""
        success, _ = self.run_test(
            "Unauthorized Access (No Token)",
            "GET",
            "quotes",
            401
        )
        return success

def main():
    print("🚀 Starting Transport Quote System API Tests")
    print("=" * 60)
    
    tester = TransportQuoteAPITester()
    
    # Authentication tests
    print("\n📋 AUTHENTICATION TESTS")
    print("-" * 30)
    if not tester.test_admin_login():
        print("❌ Admin login failed, stopping tests")
        return 1
    
    tester.test_invalid_login()
    tester.test_register_user()
    tester.test_unauthorized_access()
    
    # User management tests
    print("\n👥 USER MANAGEMENT TESTS")
    print("-" * 30)
    tester.test_get_users_admin()
    tester.test_get_users_member()
    
    # Company tests
    print("\n🏢 COMPANY TESTS")
    print("-" * 30)
    tester.test_get_company()
    
    # Quote management tests
    print("\n📄 QUOTE MANAGEMENT TESTS")
    print("-" * 30)
    tester.test_create_quote()
    tester.test_get_quotes()
    tester.test_get_single_quote()
    tester.test_delete_quote()
    
    # Print final results
    print("\n" + "=" * 60)
    print(f"📊 FINAL RESULTS: {tester.tests_passed}/{tester.tests_run} tests passed")
    
    if tester.tests_passed == tester.tests_run:
        print("🎉 All tests passed!")
        return 0
    else:
        failed = tester.tests_run - tester.tests_passed
        print(f"⚠️  {failed} test(s) failed")
        return 1

if __name__ == "__main__":
    sys.exit(main())