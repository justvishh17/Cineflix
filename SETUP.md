# 🎬 Cineflix Database Setup Guide

Welcome to Cineflix! This guide will help you set up the database and get your application running.

## 📋 Prerequisites

- XAMPP installed and running
- Apache and MySQL services started in XAMPP Control Panel
- Project files placed in `c:\xampp\htdocs\Cineflix\`

## 🚀 Quick Setup (3 Steps)

### Step 1: Check Configuration

Open your browser and go to:

```
http://localhost/Cineflix/setup/config_check.php
```

This will verify that XAMPP is properly configured.

### Step 2: Initialize Database

Open your browser and go to:

```
http://localhost/Cineflix/setup/init_db.php
```

This will create the database and all required tables automatically.

### Step 3: Verify Setup

Open your browser and go to:

```
http://localhost/Cineflix/setup/check_setup.php
```

This will confirm everything is working correctly.

### Step 4: Launch Application

Open your browser and go to:

```
http://localhost/Cineflix/
```

## 🔧 Setup Scripts

| Script | Purpose | When to Use |
|--------|---------|-------------|
| `setup/config_check.php` | Validates XAMPP configuration | First time setup or troubleshooting |
| `setup/init_db.php` | Creates database and tables | Initial setup or reset database |
| `setup/check_setup.php` | Verifies database setup | After initialization |
| `setup/seed_data.php` | Adds additional sample data | Optional - for more content |

## 👤 Default Accounts

After initialization, you can log in with these accounts:

| Role | Email | Password |
|------|-------|----------|
| Admin | <admin@cineflix.com> | admin123 |
| User | <test@example.com> | test123 |
| Subscriber | <sub@example.com> | test123 |

## 🗄️ Database Structure

The setup creates the following tables:

- `users` - User accounts and authentication
- `media` - Movies and TV shows
- `likes` - User ratings/likes
- `watchlist` - User saved items
- `watch_history` - Viewing history
- `subscriptions` - Available plans
- `plans` - Subscription plans (alias)

## ❓ Troubleshooting

### Database Connection Error

```
Fatal error: Unknown database 'cineflix'
```

**Solution:** Run `setup/init_db.php` to create the database.

### XAMPP Not Running

**Solution:**

1. Open XAMPP Control Panel
2. Start Apache and MySQL services
3. Verify green status indicators

### Permission Issues

**Solution:**

1. Ensure files are in `c:\xampp\htdocs\Cineflix\`
2. Check folder permissions
3. Restart XAMPP as administrator if needed

### Missing Tables

**Solution:** Run `setup/init_db.php` again to recreate all tables.

## 🔄 Reset Database

To completely reset the database:

1. Go to `http://localhost/Cineflix/setup/init_db.php`
2. The script will drop and recreate all tables
3. Run `setup/check_setup.php` to verify

## 📱 Features

After setup, your Cineflix application includes:

- User registration and authentication
- Movie and TV show browsing
- Personal watchlist
- Viewing history
- User ratings/likes
- Subscription management
- Admin panel

## 🆘 Need Help?

1. Run `setup/config_check.php` to diagnose configuration issues
2. Run `setup/check_setup.php` to verify database setup
3. Check XAMPP error logs in the XAMPP control panel
4. Ensure all XAMPP services are running

---

**Ready to start?** Go to `http://localhost/Cineflix/setup/config_check.php` to begin!
