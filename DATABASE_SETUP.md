# Portfolio Database Setup Guide

This guide will help you set up the complete database structure for the Portfolio website backend.

## 🗄️ Database Structure Overview

The database includes the following main tables:

### Core Tables
- **users** - User management with roles (admin, super_admin)
- **blogs** - Blog posts with SEO optimization
- **portfolios** - Project showcase with galleries and technologies
- **contacts** - Contact form submissions with tracking
- **testimonials** - Client testimonials and reviews

### Content Management
- **services** - Service offerings
- **service_packages** - Service packages and pricing
- **site_settings** - Dynamic site configuration

### Analytics & Tracking
- **analytics** - Event tracking and user behavior
- **page_views** - Page view analytics
- **newsletter_subscribers** - Email subscription management

### SEO & Media
- **seo_meta** - SEO metadata for pages
- **redirects** - URL redirects management
- **media_files** - File upload management

## 🚀 Quick Setup

### Option 1: Automated Setup (Recommended)

**For Windows:**
```bash
cd portfolio-backend
setup-database.bat
```

**For Linux/Mac:**
```bash
cd portfolio-backend
chmod +x setup-database.sh
./setup-database.sh
```

### Option 2: Manual Setup

1. **Install Dependencies**
   ```bash
   composer install
   ```

2. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

3. **Run Migrations**
   ```bash
   php artisan migrate
   ```

4. **Seed Database**
   ```bash
   php artisan db:seed
   ```

## 📊 Database Features

### Relationships
- Users can have multiple blogs and portfolios
- Portfolios can have multiple testimonials
- Users can be assigned to contacts
- All content supports author attribution

### JSON Fields
- **blogs.tags** - Array of tag strings
- **portfolios.gallery** - Array of image URLs
- **portfolios.technologies** - Array of technology names
- **portfolios.features** - Array of feature descriptions
- **services.features** - Array of service features
- **services.benefits** - Array of service benefits
- **analytics.properties** - Custom event properties

### Indexes for Performance
- Unique indexes on slugs (blogs, portfolios)
- Composite indexes for filtering (published, featured, category)
- Performance indexes on analytics tables
- Foreign key indexes for relationships

## 🔧 Model Features

### Automatic Slug Generation
- Blogs and portfolios automatically generate URL-friendly slugs
- Slugs are unique and SEO-optimized

### Scopes for Filtering
- `published()` - Only published content
- `featured()` - Only featured content
- `category()` - Filter by category
- `recent()` - Recent content (configurable days)

### Casting
- JSON fields are automatically cast to arrays
- Boolean fields are properly cast
- Date fields use Carbon instances

## 📝 Sample Data

The seeder creates:
- 1 admin user (admin@portfolio.com / password)
- 3 additional users
- 10 portfolio projects (3 featured)
- 15 blog posts (5 featured)
- 20 contact submissions
- 50 newsletter subscribers
- 30 media files
- 4 services with packages
- 3 testimonials
- Complete site settings

## 🔍 Testing the Setup

1. **Check Database Connection**
   ```bash
   php artisan tinker
   >>> App\Models\User::count()
   ```

2. **Verify Relationships**
   ```bash
   php artisan tinker
   >>> $user = App\Models\User::first()
   >>> $user->blogs
   >>> $user->portfolios
   ```

3. **Test API Endpoints** (if controllers are created)
   ```bash
   php artisan serve
   # Visit http://localhost:8000/api/blogs
   ```

## 🛠️ Customization

### Adding New Fields
1. Create migration: `php artisan make:migration add_field_to_table`
2. Update model's `$fillable` array
3. Update factory if needed
4. Run migration: `php artisan migrate`

### Adding New Models
1. Create model: `php artisan make:model ModelName`
2. Create migration: `php artisan make:migration create_model_names_table`
3. Create factory: `php artisan make:factory ModelNameFactory`
4. Add to seeder if needed

## 📋 Available Commands

```bash
# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Reset all migrations
php artisan migrate:reset

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Run only seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=PortfolioSeeder
```

## 🔒 Security Notes

- All passwords are hashed using Laravel's built-in hashing
- User roles are properly enforced
- Mass assignment protection is enabled
- Foreign key constraints ensure data integrity

## 📈 Performance Considerations

- Database indexes are optimized for common queries
- JSON fields are indexed where appropriate
- Pagination is recommended for large datasets
- Consider caching for frequently accessed data

## 🐛 Troubleshooting

### Common Issues

1. **Migration fails**: Check database connection in `.env`
2. **Seeder fails**: Ensure all models are properly imported
3. **Foreign key errors**: Run migrations in correct order
4. **Memory issues**: Increase PHP memory limit for large seeders

### Debug Commands

```bash
# Check migration status
php artisan migrate:status

# Check database connection
php artisan tinker
>>> DB::connection()->getPdo()

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 📚 Next Steps

After database setup:
1. Create API controllers for frontend integration
2. Set up authentication middleware
3. Configure CORS for frontend requests
4. Create API resources for data serialization
5. Set up file upload handling
6. Configure email settings for contact forms

---

**Need Help?** Check the Laravel documentation or create an issue in the project repository.
