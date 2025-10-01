# iWellCare Healthcare Management System

A comprehensive healthcare management system built with Laravel 10, featuring role-based access control, appointment scheduling, patient management, and medical record keeping.

## Features

### 🏥 Core Healthcare Features
- **Patient Management**: Complete patient records with medical history
- **Appointment Scheduling**: Easy appointment booking and management
- **Medical Consultations**: Comprehensive consultation workflow
- **Prescription Management**: Digital prescription system
- **Billing & Payments**: Integrated billing and payment processing
- **Medical Records**: Secure digital health records
- **Inventory Management**: Medical supplies and medication tracking

### 👥 Role-Based Access Control
- **Admin**: Full system access and user management
- **Doctor**: Patient consultations, prescriptions, and medical records
- **Staff**: Appointment management, billing, and inventory
- **Patient**: Appointment booking and personal health records

### 🛡️ Security & Privacy
- Role-based permissions using Spatie Laravel Permission
- Secure authentication and authorization
- Data encryption and privacy protection
- Audit trails for sensitive operations

## Technology Stack

- **Framework**: Laravel 10
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **Authorization**: Spatie Laravel Permission
- **Frontend**: Bootstrap 5, Font Awesome, AOS
- **PDF Generation**: TCPDF
- **Image Processing**: Intervention Image

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL 5.7 or higher
- Node.js & NPM (for asset compilation)

## Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd iwellcare
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp env.example .env
```

Edit the `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=iwellcare
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Run Database Migrations
```bash
php artisan migrate
```

### 6. Seed the Database
```bash
php artisan db:seed
```

### 7. Compile Assets
```bash
npm run dev
```

### 8. Set Up Storage
```bash
php artisan storage:link
```

### 9. Configure Web Server
Point your web server's document root to the `public` directory.

## Default Login Credentials

After running the seeder, you can use these demo accounts:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@iwellcare.com | password |
| Doctor | doctor@iwellcare.com | password |
| Staff | staff@iwellcare.com | password |
| Patient | patient@iwellcare.com | password |

## Directory Structure

```
iwellcare/
├── app/
│   ├── Console/           # Artisan commands
│   ├── Http/
│   │   ├── Controllers/   # Application controllers
│   │   └── Middleware/    # Custom middleware
│   ├── Models/            # Eloquent models
│   └── Providers/         # Service providers
├── config/                # Configuration files
├── database/
│   ├── migrations/        # Database migrations
│   └── seeders/          # Database seeders
├── public/               # Web server document root
├── resources/
│   └── views/            # Blade templates
├── routes/               # Route definitions
└── storage/              # File storage
```

## Key Models

- **User**: Authentication and role management
- **Patient**: Patient information and medical records
- **Appointment**: Appointment scheduling and management
- **Consultation**: Medical consultation workflow
- **Prescription**: Medication prescriptions
- **Billing**: Financial transactions and billing

## API Endpoints

The system includes RESTful API endpoints for:
- User authentication
- Patient management
- Appointment scheduling
- Consultation workflow
- Billing operations

## Scheduled Tasks

The system includes automated tasks:
- Appointment reminders (daily at 8 AM)
- File cleanup (weekly)
- Daily reports generation (6 PM)
- Database backups (2 AM)
- Doctor availability checks (hourly)

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support and questions, please contact:
- Email: support@iwellcare.com
- Documentation: [Link to documentation]

## Security

If you discover any security vulnerabilities, please send an e-mail to security@iwellcare.com.

## Changelog

### Version 1.0.0
- Initial release
- Basic healthcare management features
- Role-based access control
- Appointment scheduling
- Patient management
- Medical consultations
- Billing system
- Inventory management

## Roadmap

- [ ] Mobile application
- [ ] Telemedicine integration
- [ ] Advanced analytics dashboard
- [ ] Multi-language support
- [ ] API rate limiting
- [ ] Advanced reporting
- [ ] Integration with external healthcare systems 