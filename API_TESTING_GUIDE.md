# API Testing Guide - Phase 1

## 🚀 Quick Start

1. **Start the server:**
   ```bash
   php artisan serve
   ```

2. **Test health check:**
   ```bash
   curl http://localhost:8000/api/health
   ```

## 📋 API Endpoints

### **Public Endpoints**

#### **Health Check**
```http
GET /api/health
```

#### **Blogs**
```http
# Get all published blogs
GET /api/v1/blogs

# Get featured blogs
GET /api/v1/blogs/featured

# Get blog categories
GET /api/v1/blogs/categories

# Get single blog post
GET /api/v1/blogs/{slug}

# Search blogs
GET /api/v1/blogs?search=laravel

# Filter by category
GET /api/v1/blogs?category=Web Development

# Pagination
GET /api/v1/blogs?page=2&per_page=10
```

#### **Portfolios**
```http
# Get all published portfolios
GET /api/v1/portfolios

# Get featured portfolios
GET /api/v1/portfolios/featured

# Get portfolio categories
GET /api/v1/portfolios/categories

# Get portfolio industries
GET /api/v1/portfolios/industries

# Get single portfolio project
GET /api/v1/portfolios/{slug}

# Search portfolios
GET /api/v1/portfolios?search=react

# Filter by category
GET /api/v1/portfolios?category=Web Development

# Filter by industry
GET /api/v1/portfolios?industry=Technology
```

#### **Contact Form**
```http
POST /api/v1/contact
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+1234567890",
    "company": "Acme Corp",
    "subject": "Website Development Inquiry",
    "message": "I'm interested in your web development services...",
    "project_type": "Web Development",
    "budget": "$5,000 - $10,000",
    "timeline": "2-3 months",
    "utm_source": "google",
    "utm_medium": "cpc",
    "utm_campaign": "web_dev"
}
```

#### **Testimonials**
```http
# Get all published testimonials
GET /api/v1/testimonials

# Get featured testimonials
GET /api/v1/testimonials/featured
```

### **Admin Endpoints**

#### **Authentication**
```http
# Admin login
POST /api/v1/admin/login
Content-Type: application/json

{
    "email": "admin@portfolio.com",
    "password": "password"
}

# Admin logout
POST /api/v1/admin/logout
Authorization: Bearer {token}

# Get admin profile
GET /api/v1/admin/profile
Authorization: Bearer {token}

# Get dashboard stats
GET /api/v1/admin/dashboard
Authorization: Bearer {token}
```

#### **Contact Management**
```http
# Get all contacts
GET /api/v1/admin/contacts
Authorization: Bearer {token}

# Get contact statistics
GET /api/v1/admin/contacts/stats
Authorization: Bearer {token}

# Get single contact
GET /api/v1/admin/contacts/{id}
Authorization: Bearer {token}

# Update contact status
PUT /api/v1/admin/contacts/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "status": "read",
    "priority": "high",
    "notes": "Follow up required"
}
```

## 🧪 Testing with Postman

### **1. Import Collection**
Create a new Postman collection with these requests:

### **2. Environment Variables**
Set up these variables:
- `base_url`: `http://localhost:8000/api`
- `admin_token`: (set after login)

### **3. Test Sequence**

#### **Step 1: Health Check**
```http
GET {{base_url}}/health
```

#### **Step 2: Test Public Endpoints**
```http
GET {{base_url}}/v1/blogs
GET {{base_url}}/v1/portfolios
GET {{base_url}}/v1/testimonials
```

#### **Step 3: Test Contact Form**
```http
POST {{base_url}}/v1/contact
Content-Type: application/json

{
    "name": "Test User",
    "email": "test@example.com",
    "subject": "Test Message",
    "message": "This is a test message from Postman"
}
```

#### **Step 4: Admin Login**
```http
POST {{base_url}}/v1/admin/login
Content-Type: application/json

{
    "email": "admin@portfolio.com",
    "password": "password"
}
```
*Save the token from response to `admin_token` variable*

#### **Step 5: Test Admin Endpoints**
```http
GET {{base_url}}/v1/admin/profile
Authorization: Bearer {{admin_token}}

GET {{base_url}}/v1/admin/dashboard
Authorization: Bearer {{admin_token}}

GET {{base_url}}/v1/admin/contacts
Authorization: Bearer {{admin_token}}
```

## 🔍 Expected Responses

### **Success Response Format**
```json
{
    "success": true,
    "data": { ... },
    "message": "Optional message"
}
```

### **Error Response Format**
```json
{
    "success": false,
    "message": "Error description",
    "errors": {
        "field": ["Validation error message"]
    }
}
```

### **Pagination Response**
```json
{
    "success": true,
    "data": [...],
    "pagination": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 12,
        "total": 50
    }
}
```

## 🐛 Common Issues & Solutions

### **1. CORS Errors**
- Ensure `CorsMiddleware` is registered
- Check browser developer tools for CORS headers

### **2. Authentication Errors**
- Verify Sanctum is properly installed
- Check token format: `Bearer {token}`
- Ensure user has admin role

### **3. Database Errors**
- Run migrations: `php artisan migrate`
- Check database connection in `.env`
- Verify SQLite file exists

### **4. Email Errors**
- Check mail configuration in `.env`
- Verify SMTP settings
- Check Laravel logs: `storage/logs/laravel.log`

## 📊 Performance Testing

### **Load Testing with Apache Bench**
```bash
# Test blog listing
ab -n 100 -c 10 http://localhost:8000/api/v1/blogs

# Test portfolio listing
ab -n 100 -c 10 http://localhost:8000/api/v1/portfolios
```

### **Response Time Targets**
- Health check: < 100ms
- Blog listing: < 500ms
- Portfolio listing: < 500ms
- Contact form: < 1000ms
- Admin dashboard: < 1000ms

## 🔧 Debugging Tips

### **1. Enable Debug Mode**
```bash
# In .env file
APP_DEBUG=true
LOG_LEVEL=debug
```

### **2. Check Logs**
```bash
tail -f storage/logs/laravel.log
```

### **3. Database Queries**
```bash
# Enable query logging
DB::enableQueryLog();
# ... run your code ...
dd(DB::getQueryLog());
```

### **4. API Response Debugging**
```bash
# Add to any controller method
\Log::info('API Request', [
    'url' => request()->fullUrl(),
    'method' => request()->method(),
    'data' => request()->all()
]);
```

## ✅ Testing Checklist

- [ ] Health check endpoint works
- [ ] All public endpoints return data
- [ ] Contact form accepts and stores data
- [ ] Email notifications are sent
- [ ] Admin login works
- [ ] Admin endpoints require authentication
- [ ] CORS headers are present
- [ ] Pagination works correctly
- [ ] Search functionality works
- [ ] Error handling is proper
- [ ] Response times are acceptable
- [ ] Database constraints are enforced

## 🚀 Next Steps

After Phase 1 testing is complete:
1. Move to Phase 2: Frontend Development
2. Set up Next.js API client
3. Create React components
4. Implement authentication flow
5. Build admin dashboard UI
