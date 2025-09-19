# HealthHub - Professional Medical Equipment E-commerce Platform

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php" alt="PHP 8.1+">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Alpine.js-3.x-8BC34A?style=for-the-badge&logo=alpine.js" alt="Alpine.js">
</p>

HealthHub adalah platform e-commerce modern yang dirancang khusus untuk memenuhi kebutuhan peralatan medis dan kesehatan. Platform ini menyediakan pengalaman berbelanja yang profesional dan terpercaya untuk tenaga medis, rumah sakit, klinik, dan individu yang membutuhkan produk kesehatan berkualitas tinggi.

## ✨ Features

### 🛍️ E-commerce Core
- **Product Catalog**: Browse medical equipment by categories
- **Shopping Cart**: Add, update, and remove items with real-time totals
- **Secure Checkout**: Protected payment processing
- **Order Management**: Track order status and history
- **Invoice Generation**: Automated PDF invoices
- **User Dashboard**: Comprehensive order and profile management

### 👨‍💼 Admin Panel
- **Product Management**: Add, edit, and manage medical equipment
- **Category Management**: Organize products by medical specialties
- **Order Processing**: Manage customer orders and fulfillment
- **User Management**: Handle customer accounts and permissions
- **Feedback System**: Monitor customer reviews and ratings
- **Shop Requests**: Approve new vendor applications

### 🎨 Modern UI/UX
- **Responsive Design**: Perfect on desktop, tablet, and mobile
- **Professional Styling**: Medical industry-appropriate design
- **Interactive Elements**: Smooth animations and transitions
- **Accessible**: WCAG compliant with screen reader support
- **Fast Loading**: Optimized assets and caching strategies

### 🔒 Security Features
- **Secure Authentication**: Laravel Breeze with role-based access
- **CSRF Protection**: Complete form security
- **Input Validation**: Comprehensive data validation
- **Security Headers**: Production-ready security configuration
- **Rate Limiting**: API and form submission protection

### 📊 Performance Optimizations
- **Caching Strategy**: Redis-based caching for better performance
- **Database Optimization**: Eager loading and query optimization
- **Asset Optimization**: Minified CSS/JS with Vite
- **Image Optimization**: Optimized product images
- **CDN Ready**: Prepared for content delivery networks

## 🚀 Quick Start

### Prerequisites
- PHP 8.1+
- Composer 2.x
- Node.js 16+
- MySQL 8.0+ or MariaDB 10.4+
- Redis (recommended for production)

### Installation

1. **Clone the repository**
```bash
git clone https://github.com/your-repo/healthhub.git
cd healthhub
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure database**
Update your `.env` file with database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=healthhub
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Run migrations and seeders**
```bash
php artisan migrate
php artisan db:seed
```

6. **Create storage link**
```bash
php artisan storage:link
```

7. **Build assets**
```bash
npm run build
```

8. **Start the development server**
```bash
php artisan serve
```

Visit `http://localhost:8000` to see your application!

## 👤 Default Admin Account

After running the seeders, you can log in with:
- **Email**: admin@healthhub.com
- **Password**: password

## 📱 Responsive Design

HealthHub is fully responsive and works perfectly on:
- 📱 **Mobile devices** (320px+)
- 📲 **Tablets** (768px+) 
- 💻 **Desktops** (1024px+)
- 🖥️ **Large screens** (1440px+)

## 🎯 User Roles

### Customer
- Browse products and categories
- Add items to shopping cart
- Place and track orders
- Leave feedback and reviews
- Manage profile and addresses

### Admin
- Full system access
- Manage products and categories
- Process orders and handle fulfillment
- Manage users and permissions
- View analytics and reports
- Handle shop requests

## 🛠️ Technology Stack

- **Backend**: Laravel 11.x
- **Frontend**: Blade Templates + Alpine.js
- **Styling**: Tailwind CSS 3.x
- **Database**: MySQL/MariaDB
- **Caching**: Redis
- **Assets**: Vite
- **Authentication**: Laravel Breeze
- **PDF Generation**: DomPDF
- **Icons**: Heroicons

## 📦 Key Packages

- `laravel/breeze` - Authentication scaffolding
- `barryvdh/laravel-dompdf` - PDF generation
- `intervention/image` - Image processing
- `laravel/horizon` - Queue monitoring
- `spatie/laravel-backup` - Database backups

## 🔧 Configuration

### Caching
```bash
# Cache configuration for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### Queue Workers
```bash
# Start queue workers for background jobs
php artisan queue:work
```

### Task Scheduling
Add to your crontab:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## 🚀 Production Deployment

For production deployment, see our comprehensive [Deployment Guide](DEPLOYMENT.md) which covers:

- Server setup and configuration
- SSL certificate installation
- Performance optimization
- Security hardening
- Monitoring and logging
- Backup strategies

## 🧪 Testing

```bash
# Run PHPUnit tests
php artisan test

# Run with coverage
php artisan test --coverage
```

## 📚 API Documentation

The application includes RESTful API endpoints for:
- Product management
- Order processing
- User authentication
- Cart operations

API documentation is available at `/api/documentation` when running in development mode.

## 🔒 Security

HealthHub implements multiple security layers:

- **Input Validation**: All forms use Laravel Form Requests
- **CSRF Protection**: All state-changing operations protected
- **XSS Prevention**: Automatic output escaping
- **SQL Injection Protection**: Eloquent ORM usage
- **Security Headers**: Comprehensive HTTP security headers
- **Rate Limiting**: API and form submission limits

## 📈 Performance

Optimizations include:
- Database query optimization with eager loading
- Redis caching for frequently accessed data
- Compressed and minified assets
- Optimized images with lazy loading
- CDN-ready asset organization

## 🐛 Troubleshooting

### Common Issues

**500 Internal Server Error**
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log
```

**Permission Issues**
```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
```

**Cache Issues**
```bash
# Clear all caches
php artisan optimize:clear
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel community for the excellent framework
- Tailwind CSS for the utility-first CSS framework
- Alpine.js for lightweight JavaScript framework
- Heroicons for beautiful SVG icons

## 📞 Support

For support and questions:
- 📧 Email: support@healthhub.com
- 📱 Phone: +62 123 456 7890
- 🌐 Website: https://healthhub.com

---

Built with ❤️ for healthcare professionals worldwide.
