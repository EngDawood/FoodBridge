# FoodBridge

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS 4.0">
  <img src="https://img.shields.io/badge/MySQL-8.2-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL 8.2">
</p>

## About FoodBridge

**FoodBridge** is a web-based platform designed to combat food waste by connecting food donors with beneficiaries in Al-Jouf, Saudi Arabia. Built as a Computer Science thesis project for Jouf University, this application aligns with **Saudi Vision 2030** sustainability goals by facilitating efficient food redistribution and reducing environmental impact.

The platform creates a seamless ecosystem where:
- **Donors** (restaurants, hotels, supermarkets, individuals) can post surplus food donations
- **Beneficiaries** (charitable organizations, families in need) can request food assistance
- **Volunteers** coordinate and manage food deliveries
- **Administrators** oversee operations, generate reports, and ensure platform integrity

## Key Features

### Multi-Role Authentication System

- Four distinct user roles: Donor, Beneficiary, Volunteer, and Admin
- Role-based access control with protected routes
- Secure registration and login system

### Food Donation Management

- Create, edit, and delete food donations
- Track donation status (pending, scheduled, delivered)
- Monitor food quantity and expiration dates
- Real-time remaining quantity tracking

### Request Matching System

- Automated matching between donations and beneficiary requests
- Location-based coordination within Al-Jouf region
- Smart matching algorithm considering food type, quantity, and availability
- Real-time notifications for successful matches

### Delivery Coordination

- Volunteer task assignment and management
- Delivery status tracking (assigned, in progress, completed)
- Pickup and drop-off location management
- Task acceptance and completion workflow

### Feedback & Rating System

- User feedback collection after transactions
- Rating system for quality assurance
- Review history and statistics

### Admin Dashboard

- Comprehensive system oversight
- User management (create, edit, delete users)
- Transaction monitoring and reporting
- Feedback review and management
- Role promotion capabilities

## Technology Stack

### Backend

- **Laravel 12** - PHP web application framework
- **PHP 8.2+** - Server-side programming language
- **MySQL 8.2** - Relational database management system
- **Composer** - Dependency management for PHP

### Frontend

- **Blade Templates** - Laravel's templating engine
- **Tailwind CSS 4.0** - Utility-first CSS framework
- **Vite 6.0** - Modern frontend build tool
- **JavaScript (Vanilla)** - Client-side scripting
- **Axios** - HTTP client for API requests

### Development Tools

- **Laravel Pint** - Code style fixer
- **Laravel Sail** - Docker development environment (optional)
- **PHPUnit** - Testing framework
- **Faker** - Test data generation
- **Laravel Pail** - Log viewer

## Prerequisites

Before installing FoodBridge, ensure your system meets the following requirements:

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.0 and npm
- **MySQL** >= 8.0 or **MariaDB** >= 10.3
- **Git**

### PHP Extensions Required

- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/EngDawood/FoodBridge.git
cd FoodBridge
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node.js Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the example environment file and generate an application key:

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Database Configuration

Edit the `.env` file and configure your database connection:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=foodbridge
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 6. Create Database

Create a new MySQL database for the application:

```bash
mysql -u your_username -p
```

Then in MySQL console:

```sql
CREATE DATABASE foodbridge CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 7. Run Database Migrations and Seeders

```bash
php artisan migrate:fresh --seed
```

This will create all necessary tables and populate them with sample data.

### 8. Storage Link

Create a symbolic link for file storage:

```bash
php artisan storage:link
```

### 9. Build Frontend Assets

For development:
```bash
npm run dev
```

For production:
```bash
npm run build
```

## Running the Application

### Development Server

Start the Laravel development server:

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

### Full Development Environment

To run the complete development stack (server, queue, logs, and Vite):

```bash
composer run dev
```

This will start:
- Laravel development server (port 8000)
- Queue worker for background jobs
- Laravel Pail for real-time log viewing
- Vite development server with hot module replacement

## Default User Accounts

After running the seeders, you can login with these default accounts:

### Admin Account

- **Email**: admin@foodbridge.sa
- **Password**: password

### Donor Accounts

- **Email**: nora@foodbridge.sa (نورة عبدالعزيز)
- **Email**: khaled@foodbridge.sa (خالد محمد)
- **Email**: alkheir@foodbridge.sa (مطعم الخير)
- **Password**: password (for all)

### Beneficiary Accounts

- **Email**: fatima@foodbridge.sa (فاطمة أحمد)
- **Email**: abdullah@foodbridge.sa (عبدالله سعيد)
- **Email**: maryam@foodbridge.sa (مريم حسن)
- **Password**: password (for all)

### Volunteer Accounts

- **Email**: mohammed@foodbridge.sa (محمد العنزي)
- **Email**: sara@foodbridge.sa (سارة الشمري)
- **Password**: password (for all)

## Development Workflow

### Common Artisan Commands

```bash
# Clear application cache
php artisan optimize:clear

# Run database migrations
php artisan migrate

# Reset database and seed data
php artisan migrate:fresh --seed

# Run tests
php artisan test

# Code style fixing
./vendor/bin/pint

# Interactive PHP shell
php artisan tinker
```

### Frontend Development

```bash
# Start Vite dev server with HMR
bun run dev

# Build production assets
bun run build
```

## Project Structure

```
FoodBridge/
├── app/
│   ├── Contracts/Services/    # Service interfaces
│   ├── Helpers/                # Helper functions
│   ├── Http/
│   │   ├── Controllers/        # Application controllers
│   │   │   └── Admin/          # Admin-specific controllers
│   │   └── Middleware/         # Custom middleware
│   ├── Models/                 # Eloquent models
│   ├── Providers/              # Service providers
│   └── Services/               # Business logic services
├── database/
│   ├── factories/              # Model factories
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── resources/
│   ├── css/                    # Stylesheets
│   ├── js/                     # JavaScript files
│   └── views/                  # Blade templates
│       ├── admin/              # Admin interface
│       ├── auth/               # Authentication views
│       ├── beneficiary/        # Beneficiary interface
│       ├── donor/              # Donor interface
│       ├── layouts/            # Layout templates
│       └── volunteer/          # Volunteer interface
├── routes/
│   ├── console.php             # Artisan commands
│   └── web.php                 # Web routes
└── tests/                      # Application tests
```

## Architecture Patterns

### MVC Architecture

The application follows Laravel's MVC pattern with clear separation of concerns.

### Role-Based Access Control (RBAC)

Routes are protected using custom middleware (`EnsureUserHasRole`) that validates user roles before granting access.

### Service-Oriented Architecture

Business logic is extracted into service classes:
- **MatchingService** - Handles donation-to-request matching logic
- **NotificationService** - Manages user notifications
- Service contracts define interfaces for dependency injection

### Repository Pattern

Data access is abstracted through Eloquent models with proper relationships and foreign key constraints.

## Database Schema

### Core Tables

- **users** - Multi-role user management
- **donations** - Food donation records
- **requests** - Beneficiary food requests
- **delivery_tasks** - Volunteer delivery coordination
- **feedback** - User ratings and feedback
- **notifications** - System notifications
- **reports** - Admin-generated reports

## Testing

Run the test suite:

```bash
php artisan test
```

Run tests with coverage:

```bash
php artisan test --coverage
```

## Code Quality

Format code according to Laravel standards:

```bash
./vendor/bin/pint
```

## Contributing

This is an academic project for Jouf University. If you'd like to contribute:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Security

If you discover any security vulnerabilities, please email the development team immediately. Do not create public GitHub issues for security vulnerabilities.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Acknowledgments

- Jouf University Computer Science Department
- Saudi Vision 2030 Sustainability Initiative
- Laravel Framework
- All contributors and testers

## Contact

**Project Repository**: [https://github.com/EngDawood/FoodBridge](https://github.com/EngDawood/FoodBridge)

---

Built with ❤️ for a sustainable future in Al-Jouf, Saudi Arabia
