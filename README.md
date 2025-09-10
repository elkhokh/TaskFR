# TaskFP - Laravel 12 Application

A modern Laravel 12 application for managing posts and comments with comprehensive features including authentication, email notifications, and RESTful API endpoints.

## 🚀 Features

- **Posts & Comments**: Complete CRUD operations with role-based authorization via Laravel Policies
- **Blade Views**: Dynamic and responsive frontend templates with modern UI
- **RESTful API**: Fully functional API endpoints for posts and comments management
- **Email Notifications**: SMTP email notifications when comments are added to posts
- **Service Classes**: Clean architecture with business logic separated into dedicated service classes
- **Authorization Policies**: Role-based access control for posts and comments operations
- **API Resources & Helpers**: Structured API response formatting with consistent success/error handling
- **Unit Testing**: Comprehensive tests for controllers and services to ensure functionality
- **Validation & Error Handling**: Robust validation rules and structured exception logging
- **Database Seeding**: Pre-populated data for testing and development

## 📋 Prerequisites

Before installing this application, ensure you have the following installed on your system:

- **PHP 8.2+** with required extensions (PDO, Mbstring, Tokenizer, XML, Ctype, JSON)
- **Composer** (Dependency Manager for PHP)
- **Node.js 16+** & **npm** (for frontend asset compilation)
- **Git** (Version control)
- **Database**: SQLite (default) or MySQL/MariaDB
- **Web Server**: Apache or Nginx (optional for production)

## ⚡ Installation

### 1. Clone the Repository

```bash
git clone https://github.com/elkhokh/TaskFR.git
cd TaskFR
```

### 2. Install Dependencies

Install PHP dependencies via Composer:
```bash
composer install
```

Install frontend dependencies:
```bash
npm install
npm run build
```

### 3. Environment Configuration

Copy the environment variables file:
```bash
cp .env.example .env
```

Generate application key:
```bash
php artisan key:generate
```

### 4. Database Configuration

For SQLite (default):
```bash
touch database/database.sqlite
```

Or update `.env` for MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskfr
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Email Configuration

Configure SMTP settings in your `.env` file:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Note**: For Gmail, you'll need to use an App Password instead of your regular password. Follow [Google's guide](https://support.google.com/accounts/answer/185833) to generate one.

### 6. Database Setup

Run migrations and seed the database:
```bash
php artisan migrate --seed
```

### 7. Storage Link (if using file uploads)

Create symbolic link for storage:
```bash
php artisan storage:link
```

### 8. Start Development Server

Start the Laravel development server:
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## 🔧 Configuration

### Queue Configuration (Optional)

For email notifications, configure queue settings:

```env
QUEUE_CONNECTION=database
```

Then run:
```bash
php artisan queue:table
php artisan migrate
php artisan queue:work
```

### Cache Configuration

For better performance in production:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📚 API Documentation

Complete API documentation is available via Postman:

**[View API Documentation](https://documenter.getpostman.com/view/34519107/2sB3HnLL25)**

### API Endpoints Overview

- `GET /api/posts` - List all posts
- `POST /api/posts` - Create a new post
- `GET /api/posts/{id}` - Get specific post
- `PUT /api/posts/{id}` - Update a post
- `DELETE /api/posts/{id}` - Delete a post
- `GET /api/posts/{id}/comments` - Get post comments
- `POST /api/posts/{id}/comments` - Add comment to post

## 🧪 Testing

Run the test suite:

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/PostControllerTest.php

# Run with coverage (if configured)
php artisan test --coverage
```

## 🏗️ Project Structure

```
TaskFR/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Requests/
│   │   └── Resources/
│   ├── Models/
│   ├── Policies/
│   ├── Services/
│   └── Mail/
├── resources/
│   ├── views/
│   └── js/
├── routes/
│   ├── web.php
│   └── api.php
├── database/
│   ├── migrations/
│   └── seeders/
└── tests/
    ├── Feature/
    └── Unit/
```

## 🔐 Authentication & Authorization

The application uses Laravel's built-in authentication system with additional policies for:

- **Post Management**: Only authors can edit/delete their posts
- **Comment Management**: Users can delete their own comments
- **Admin Access**: Admin users have full access to all resources

## 🚀 Deployment

### Production Setup

1. Set environment to production:
```env
APP_ENV=production
APP_DEBUG=false
```

2. Optimize for production:
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Configure web server (Nginx/Apache) to point to `public/` directory

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 🐛 Troubleshooting

### Common Issues

**Permission Errors:**
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

**Cache Issues:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

**Email Not Sending:**
- Verify SMTP credentials
- Check firewall settings
- Ensure queue worker is running if using queues

## 📝 License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**elkhokh**
- GitHub: [@elkhokh](https://github.com/elkhokh)

## 🙏 Acknowledgments

- Laravel Framework Team
- Contributors and testers
- Open source community

---

For more information, please visit the [Laravel Documentation](https://laravel.com/docs) or open an issue on GitHub.
