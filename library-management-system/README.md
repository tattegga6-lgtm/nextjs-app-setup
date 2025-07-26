# Library Management System

A comprehensive PHP-based Library Management System with modern design and extensive features for managing students, books, reservations, lockers, events, and fees.

## Features

### 🔐 User Authentication & Role-Based Access
- Secure login system with password hashing
- Three user roles: Admin, Staff, and Student
- Role-based access control for different features

### 👥 Student Management
- Complete student registration and profile management
- Membership tracking with start/end dates
- Dues and fee management
- Student search and filtering capabilities

### 📚 Book Catalog & Inventory Management
- Comprehensive book catalog with ISBN, author, category
- Inventory tracking with total and available copies
- Book search and categorization

### 🪑 Real-Time Seat Reservations
- Interactive seat reservation system
- Real-time availability checking
- Time-based reservations with start/end times
- Section-wise seat organization

### 🔒 Locker Assignment System
- Digital locker management
- Student locker assignments
- Availability tracking by sections

### ⏰ Shift Management
- Multiple time period management
- Shift scheduling for different time slots
- Capacity management per shift

### 🎉 Event Management
- Event creation and management
- Student registration for events
- Attendance tracking
- Registration deadlines and capacity limits

### 💰 Fee Tracking & Payment Management
- Multiple fee types (membership, late fees, damages)
- Payment status tracking
- Due date management
- Payment history and receipts

### 📊 Comprehensive Reporting & Analytics
- Dashboard with key statistics
- Monthly trend analysis
- Custom report generation
- Data export capabilities (CSV/JSON)

## Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Styling**: Custom CSS with modern design principles
- **Security**: PDO prepared statements, password hashing, input sanitization

## Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- mod_rewrite enabled (for clean URLs)

### Step 1: Download and Setup
1. Clone or download the project files
2. Place the `library-management-system` folder in your web server directory
3. Ensure the web server has read/write permissions for the project folder

### Step 2: Database Setup
1. Create a new MySQL database named `library_management`
2. Update database credentials in `config/database.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'library_management');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   ```
3. The system will automatically create all required tables on first run

### Step 3: Web Server Configuration

#### Apache
- Ensure mod_rewrite is enabled
- The `.htaccess` file is already configured for clean URLs

#### Nginx
Add this configuration to your server block:
```nginx
location / {
    try_files $uri $uri/ /index.php?route=$uri&$args;
}
```

### Step 4: Access the System
1. Navigate to `http://your-domain/library-management-system/public/`
2. Use the default admin credentials:
   - **Username**: `admin`
   - **Password**: `admin123`

## Default Login Credentials

| Role | Username | Password |
|------|----------|----------|
| Admin | admin | admin123 |

**Important**: Change the default password immediately after first login!

## Directory Structure

```
library-management-system/
├── config/
│   └── database.php          # Database configuration
├── public/
│   ├── index.php            # Front controller
│   ├── css/
│   │   └── styles.css       # Main stylesheet
│   └── .htaccess           # URL rewriting rules
├── app/
│   ├── controllers/         # Application controllers
│   │   ├── AuthController.php
│   │   ├── StudentController.php
│   │   ├── BookController.php
│   │   ├── ReservationController.php
│   │   ├── LockerController.php
│   │   ├── ShiftController.php
│   │   ├── EventController.php
│   │   ├── FeeController.php
│   │   └── ReportController.php
│   └── models/             # Data models
│       ├── User.php
│       ├── Student.php
│       ├── Book.php
│       ├── Reservation.php
│       ├── Locker.php
│       ├── Shift.php
│       ├── Event.php
│       ├── Fee.php
│       └── Report.php
└── views/                  # View templates
    ├── layouts/
    ├── auth/
    ├── students/
    ├── books/
    ├── reservations/
    ├── lockers/
    ├── shifts/
    ├── events/
    ├── fees/
    └── reports/
```

## Usage Guide

### For Administrators
1. **Dashboard**: View system overview and statistics
2. **Student Management**: Add, edit, and manage student records
3. **Book Management**: Maintain book catalog and inventory
4. **Fee Management**: Track and manage student fees
5. **Event Management**: Create and manage library events
6. **Reports**: Generate comprehensive reports and analytics
7. **System Settings**: Manage shifts, lockers, and system configuration

### For Staff
- Access to student and book management
- Fee tracking and collection
- Event management
- Basic reporting features

### For Students
- View personal dashboard
- Make seat reservations
- View assigned lockers
- Register for events
- Check fee status

## Security Features

- **Password Security**: Bcrypt hashing for all passwords
- **SQL Injection Protection**: PDO prepared statements
- **XSS Prevention**: Input sanitization and output escaping
- **CSRF Protection**: Session-based request validation
- **Role-Based Access**: Granular permission system
- **Secure Headers**: Security headers via .htaccess

## Customization

### Adding New Features
1. Create new model in `app/models/`
2. Create corresponding controller in `app/controllers/`
3. Add routes in `public/index.php`
4. Create view templates in `views/`

### Styling Customization
- Modify `public/css/styles.css` for design changes
- The system uses a modern, clean design with:
  - Sans-serif typography
  - Responsive grid layouts
  - Clean color palette (blacks, whites, grays)
  - No external icons or images

### Database Schema Modifications
- Update table structures in `config/database.php`
- Modify corresponding model methods
- Update view templates as needed

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check database credentials in `config/database.php`
   - Ensure MySQL service is running
   - Verify database exists

2. **Clean URLs Not Working**
   - Ensure mod_rewrite is enabled (Apache)
   - Check .htaccess file permissions
   - Verify web server configuration

3. **Permission Denied Errors**
   - Check file/folder permissions
   - Ensure web server has read/write access

4. **Session Issues**
   - Check PHP session configuration
   - Ensure session directory is writable

### Error Logging
- PHP errors are logged to the system error log
- Application errors are logged with timestamps
- Check server error logs for debugging

## Performance Optimization

- **Database Indexing**: Key fields are indexed for faster queries
- **Pagination**: Large datasets are paginated
- **Caching**: Static assets are cached via .htaccess
- **Optimized Queries**: Efficient SQL queries with JOINs

## Future Enhancements

The system is designed to be easily extensible. Potential additions include:

- **API Integration**: RESTful API for mobile apps
- **Email Notifications**: Automated email alerts
- **SMS Integration**: SMS notifications for due dates
- **Payment Gateway**: Online payment processing
- **Barcode System**: Book and student ID scanning
- **Mobile App**: Companion mobile application
- **Advanced Analytics**: More detailed reporting features

## Support

For technical support or questions:
1. Check the troubleshooting section
2. Review error logs
3. Ensure all prerequisites are met
4. Verify configuration settings

## License

This project is open-source and available for educational and commercial use.

## Contributing

Contributions are welcome! Please follow these guidelines:
1. Follow existing code style and structure
2. Test thoroughly before submitting
3. Document any new features
4. Ensure security best practices

---

**Note**: This system is designed for educational and small to medium-scale library management. For large-scale deployments, consider additional security hardening and performance optimizations.
