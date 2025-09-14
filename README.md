# 🎬 Cineflix - Your Movie Universe

A modern, full-featured streaming platform that brings the cinema experience to your fingertips. Cineflix is a comprehensive web application built with PHP, MySQL, and modern frontend technologies to deliver a Netflix-like experience for movie and TV show enthusiasts.

![Cineflix Preview](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

## ✨ Features

### 🎭 User Experience

- **Sleek Modern Interface** - Netflix-inspired design with smooth animations
- **Responsive Design** - Optimized for desktop, tablet, and mobile devices  
- **Dark Theme** - Easy on the eyes with a cinematic dark interface
- **Intuitive Navigation** - Seamless browsing experience with category filters

### 🔐 Authentication & User Management

- **User Registration & Login** - Secure account creation and authentication
- **Admin Panel** - Comprehensive admin dashboard for content management
- **Role-based Access** - Different permission levels (User, Admin, Super Admin)
- **Profile Management** - Customizable user profiles with avatars

### 📺 Content Management

- **Extensive Media Library** - Movies, TV shows, web series, and anime
- **Content Categories** - Hollywood, Bollywood, Anime, Web Series
- **Detailed Media Information** - Ratings, descriptions, release years, posters
- **Content Discovery** - Browse by popularity, ratings, and categories

### ❤️ Personal Features

- **Personal Watchlist** - Save movies and shows to watch later
- **Viewing History** - Track your watched content automatically
- **Rating System** - Like and rate your favorite content
- **Personalized Recommendations** - Discover content based on your preferences

### 💎 Subscription System

- **Multiple Plans** - Basic, Standard, Diamond, and Diamond+ tiers
- **Flexible Billing** - Monthly and annual subscription options
- **Premium Content** - Exclusive content for subscribers
- **PayPal Integration** - Secure payment processing

### 🎯 Content Features

- **Advanced Search** - Find content by title, genre, or year
- **Most Liked Content** - Discover popular and trending media
- **Exclusive Content** - Premium subscriber-only titles
- **High-Quality Posters** - Beautiful HD movie posters and artwork

## 🛠️ Technology Stack

### Backend

- **PHP 7.4+** - Server-side scripting and API development
- **MySQL** - Robust database management with relational data
- **RESTful APIs** - Clean API endpoints for all functionality
- **Session Management** - Secure user session handling

### Frontend

- **Vanilla JavaScript** - Modern ES6+ for dynamic interactions
- **TailwindCSS** - Utility-first CSS framework for styling
- **Font Awesome** - Beautiful icons and visual elements
- **Responsive Grid** - CSS Grid and Flexbox for layouts

### Infrastructure

- **XAMPP** - Local development environment
- **Apache** - Web server configuration
- **JSON APIs** - Structured data exchange format

## 📱 Core Pages & Features

### 🏠 Home Page

- Featured content carousel
- Category-based content sections
- Most liked and trending content
- Quick access to watchlist items

### 👤 User Dashboard

- Personal viewing statistics
- Watch history management
- Quick access to favorites
- Subscription status overview

### 📋 Wishlist Management

- Add/remove content to personal watchlist
- Organized grid view of saved content
- Quick watch and remove options
- Empty state with helpful guidance

### ⭐ Rating & Reviews

- Like/unlike content instantly
- View community ratings
- Sort by most popular content
- Real-time like count updates

### 💳 Subscription Plans

- **Basic** - 720p, 1 device ($9.99/month)
- **Standard** - 1080p, 2 devices ($15.99/month)
- **Diamond** - 4K+HDR, 4 devices ($19.99/month) ⭐ Most Popular
- **Diamond+** - Ultimate 4K+HDR, 6 devices ($25.99/month)

## 🚀 Quick Start

### Prerequisites

- XAMPP (PHP 7.4+, MySQL, Apache)
- Modern web browser
- Internet connection for external assets

### Installation

1. **Clone or download** the project to your XAMPP htdocs folder:

   ```
   c:\xampp\htdocs\Cineflix\
   ```

2. **Start XAMPP services**:
   - Apache
   - MySQL

3. **Initialize the database**:

   ```
   http://localhost/Cineflix/init_db.php
   ```

4. **Verify setup**:

   ```
   http://localhost/Cineflix/check_setup.php
   ```

5. **Launch the application**:

   ```
   http://localhost/Cineflix/
   ```

### Default Login Credentials

- **Admin**: <admin@cineflix.com> / admin123
- **Test User**: <test@example.com> / test123

## 🗄️ Database Schema

The application uses a well-structured MySQL database with the following key tables:

- **users** - User accounts, roles, and subscription info
- **media** - Movies, shows, and content metadata  
- **likes** - User ratings and preferences
- **watchlist** - Personal saved content lists
- **watch_history** - Viewing tracking and analytics
- **subscriptions** - Available subscription plans
- **plans** - Billing and feature configurations

## 🔧 API Endpoints

### Authentication

- `POST /api/login.php` - User authentication
- `POST /api/signup.php` - Account registration
- `POST /api/logout.php` - Session termination
- `POST /api/admin_login.php` - Admin authentication

### Content Management

- `GET /api/get_most_liked.php` - Popular content
- `POST /api/add_media.php` - Add new content (Admin)
- `PUT /api/update_media.php` - Update content (Admin)
- `DELETE /api/delete_media.php` - Remove content (Admin)

### User Features

- `GET /api/get_user_dashboard.php` - User dashboard data
- `GET /api/get_wishlist.php` - Personal watchlist
- `POST /api/add_to_wishlist.php` - Save to watchlist
- `DELETE /api/remove_from_wishlist.php` - Remove from watchlist
- `POST /api/add_to_history.php` - Track viewing

### Subscriptions

- `POST /api/subscribe.php` - Subscribe to plan
- `POST /api/cancel_subscription.php` - Cancel subscription

## 🎨 Design Features

- **Cinematic Theme** - Dark, immersive design inspired by Netflix
- **Smooth Animations** - CSS transitions and hover effects
- **Responsive Layout** - Works perfectly on all screen sizes
- **Loading States** - Beautiful loading animations and feedback
- **Error Handling** - Friendly error messages and validation
- **Accessibility** - Keyboard navigation and screen reader support

## 🔒 Security Features

- **Password Hashing** - Secure bcrypt password encryption
- **SQL Injection Prevention** - Prepared statements for all queries
- **Session Security** - Secure session management and CSRF protection
- **Input Validation** - Client and server-side data validation
- **Role-based Authorization** - Restricted admin and user capabilities

## 🌟 Future Enhancements

- [ ] Video streaming integration
- [ ] Advanced recommendation engine
- [ ] Social features and reviews
- [ ] Mobile app development
- [ ] Multi-language support
- [ ] Advanced analytics dashboard
- [ ] Content rating system expansion
- [ ] API rate limiting and caching

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- **The Movie Database (TMDb)** - For movie posters and metadata
- **Font Awesome** - For beautiful icons
- **TailwindCSS** - For rapid UI development
- **PHP Community** - For excellent documentation and support

---

**Built with ❤️ for movie lovers everywhere**

*Ready to dive into your movie universe? [Get started now!](http://localhost/Cineflix/)*
