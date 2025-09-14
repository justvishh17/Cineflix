# 📁 Cineflix Project Structure

This document outlines the organized structure of the Cineflix project for better maintainability and readability.

## 🗂️ Directory Structure

```
Cineflix/
├── 📄 index.php                 # Main application entry point
├── 📄 README.md                 # Project documentation
├── 📄 SETUP.md                  # Setup instructions
├── 📄 .gitignore                # Git ignore rules
├── 📄 .gitattributes            # Git attributes
│
├── 📁 api/                      # API endpoints
│   ├── 📄 add_media.php         # Add new media (Admin)
│   ├── 📄 add_to_history.php    # Track viewing history
│   ├── 📄 add_to_wishlist.php   # Add to user wishlist
│   ├── 📄 admin_login.php       # Admin authentication
│   ├── 📄 cancel_subscription.php # Cancel user subscription
│   ├── 📄 delete_media.php      # Delete media (Admin)
│   ├── 📄 delete_user.php       # Delete user account
│   ├── 📄 get_dashboard_data.php # Get dashboard data
│   ├── 📄 get_most_liked.php    # Get popular content
│   ├── 📄 get_user_dashboard.php # Get user dashboard
│   ├── 📄 get_wishlist.php      # Get user wishlist
│   ├── 📄 login.php             # User authentication
│   ├── 📄 logout.php            # User logout
│   ├── 📄 remove_from_wishlist.php # Remove from wishlist
│   ├── 📄 signup.php            # User registration
│   ├── 📄 subscribe.php         # Subscribe to plan
│   ├── 📄 update_media.php      # Update media (Admin)
│   └── 📄 update_user.php       # Update user profile
│
├── 📁 config/                   # Configuration files
│   └── 📄 db_connect.php        # Database connection settings
│
├── 📁 css/                      # Stylesheets
│   └── 📄 style.css             # Main application styles
│
├── 📁 images/                   # Static images
│   ├── 📄 cinema2.jpg           # Background images
│   ├── 📄 family.jpg            # Content images
│   ├── 📄 girlwithpopcorn.jpg   # UI images
│   ├── 📄 loader-bg.jpg         # Loading background
│   ├── 📄 popcorn2.jpg          # Decorative images
│   ├── 📄 popcorn3.jpg
│   ├── 📄 poster.jpg            # Movie posters
│   ├── 📄 poster2.jpg
│   ├── 📄 poster3.jpg
│   ├── 📄 poster4.jpg
│   ├── 📄 poster5.jpg
│   ├── 📄 poster6.jpg
│   ├── 📄 poster7.jpg
│   ├── 📄 poster8.jpg
│   ├── 📄 poster9.jpg
│   ├── 📄 posterr.jpg
│   └── 📄 sanamterikasam.jpg
│
├── 📁 js/                       # JavaScript files
│   └── 📄 script.js             # Main application logic
│
├── 📁 pages/                    # Additional HTML pages
│   ├── 📄 loader.html           # Loading page
│   ├── 📄 paypal.html           # PayPal integration page
│   └── 📄 start.html            # Start/splash page
│
├── 📁 setup/                    # Setup and configuration scripts
│   ├── 📄 check_setup.php       # Verify database setup
│   ├── 📄 config_check.php      # Validate XAMPP configuration
│   ├── 📄 create_hash.php       # Password hash utility
│   ├── 📄 init_db.php           # Database initialization
│   └── 📄 seed_data.php         # Sample data seeder
│
├── 📁 sounds/                   # Audio files
│   ├── 📄 Netflix.mp3           # Sound effects
│   ├── 📄 rock.mp3
│   ├── 📄 whoosh.mp3
│   └── 📄 whoosh2.mp3
│
└── 📁 sql/                      # Database schemas
    └── 📄 cineflix.sql          # Database structure and data
```

## 🎯 Directory Purposes

### `/api/`

Contains all REST API endpoints for the application. Each file handles specific functionality:

- **Authentication**: `login.php`, `logout.php`, `signup.php`, `admin_login.php`
- **Media Management**: `add_media.php`, `update_media.php`, `delete_media.php`, `get_most_liked.php`
- **User Features**: `add_to_wishlist.php`, `remove_from_wishlist.php`, `get_wishlist.php`
- **Subscriptions**: `subscribe.php`, `cancel_subscription.php`
- **Analytics**: `add_to_history.php`, `get_dashboard_data.php`, `get_user_dashboard.php`

### `/config/`

Configuration files for the application:

- **`db_connect.php`**: Database connection settings and session management

### `/css/`

Stylesheet files:

- **`style.css`**: Main application styles with dark theme and animations

### `/images/`

Static image assets:

- **Backgrounds**: Cinema and loading backgrounds
- **Posters**: Movie and show posters
- **UI Elements**: Decorative images and icons

### `/js/`

JavaScript files:

- **`script.js`**: Main application logic, API calls, and UI interactions

### `/pages/`

Additional HTML pages:

- **`loader.html`**: Loading screen with animations
- **`paypal.html`**: PayPal payment integration
- **`start.html`**: Application splash/start page

### `/setup/`

Setup and maintenance scripts:

- **`config_check.php`**: Validates XAMPP and environment setup
- **`init_db.php`**: Creates database and tables
- **`check_setup.php`**: Verifies database configuration
- **`seed_data.php`**: Adds sample data for testing
- **`create_hash.php`**: Utility for password hashing

### `/sounds/`

Audio assets:

- **Sound Effects**: UI sounds and background audio

### `/sql/`

Database related files:

- **`cineflix.sql`**: Complete database schema and sample data

## 🔧 Key Files

### Root Level

- **`index.php`**: Main application entry point with movie grid and navigation
- **`README.md`**: Comprehensive project documentation
- **`SETUP.md`**: Step-by-step setup instructions
- **`.gitignore`**: Git ignore rules for PHP projects

## 🚀 Getting Started

1. **Setup**: Run scripts in `/setup/` directory in order
2. **Configuration**: Ensure `/config/db_connect.php` has correct database credentials
3. **Access**: Main application via `index.php`
4. **API**: All endpoints available under `/api/` directory

## 📝 Development Guidelines

### File Organization

- **API endpoints**: Always in `/api/` directory
- **Configuration**: Keep in `/config/` directory
- **Static assets**: Organize by type (`/css/`, `/js/`, `/images/`, `/sounds/`)
- **Setup scripts**: Maintain in `/setup/` directory
- **Additional pages**: Place in `/pages/` directory

### Naming Conventions

- **API files**: Descriptive action names (e.g., `add_to_wishlist.php`)
- **Config files**: Purpose-based names (e.g., `db_connect.php`)
- **Setup files**: Action-based names (e.g., `init_db.php`, `check_setup.php`)

### Path References

- **From root**: Use relative paths (`config/db_connect.php`)
- **From API**: Use parent directory paths (`../config/db_connect.php`)
- **From setup**: Use parent directory paths (`../config/db_connect.php`)

This structure promotes:

- ✅ **Better organization** and maintainability
- ✅ **Clear separation** of concerns
- ✅ **Easier navigation** for developers
- ✅ **Logical grouping** of related files
- ✅ **Scalable architecture** for future development
