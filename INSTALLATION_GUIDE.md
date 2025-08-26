# 🎓 School Management System - Complete Installation Guide

## 📋 Table of Contents
1. [System Overview](#system-overview)
2. [Prerequisites](#prerequisites)
3. [Installation Methods](#installation-methods)
4. [Configuration](#configuration)
5. [Testing](#testing)
6. [Deployment](#deployment)
7. [Troubleshooting](#troubleshooting)

---

## 🌟 System Overview

This School Management System is a comprehensive web-based application built with:
- **Frontend**: HTML5, CSS3, Tailwind CSS, JavaScript
- **Backend**: Pure PHP (no framework dependencies)
- **Database**: MySQL 5.7+ / MariaDB 10.3+
- **Architecture**: RESTful API with MVC pattern

### ✨ Key Features
- ✅ Student Management
- ✅ Staff Directory
- ✅ Fee Management
- ✅ Attendance Tracking
- ✅ Grade Management
- ✅ Dashboard Analytics
- ✅ User Authentication
- ✅ Role-based Access Control
- ✅ Responsive Design

---

## 🔧 Prerequisites

### Required Software:
1. **PHP 7.4 or higher**
2. **MySQL 5.7+ or MariaDB 10.3+**
3. **Web Server** (Apache/Nginx) or PHP built-in server

### Recommended: XAMPP/WAMP/MAMP
For beginners, we recommend using an all-in-one solution:
- **Windows**: XAMPP or WAMP
- **macOS**: MAMP or XAMPP
- **Linux**: XAMPP or manual installation

---

## 🚀 Installation Methods

### Method 1: XAMPP Installation (Recommended)

#### Step 1: Download XAMPP
```
1. Visit https://www.apachefriends.org/
2. Download XAMPP for your operating system
3. Install XAMPP with default settings
```

#### Step 2: Start Services
```
1. Open XAMPP Control Panel
2. Start Apache and MySQL services
3. Ensure both show "Running" status
```

#### Step 3: Setup Project
```bash
# 1. Copy the school management folder to XAMPP htdocs
# Windows: C:\xampp\htdocs\
# macOS/Linux: /Applications/XAMPP/htdocs/

# 2. Rename folder to 'school-management'
# Final path: C:\xampp\htdocs\school-management\
```

#### Step 4: Create Database
```sql
-- Open http://localhost/phpmyadmin
-- Create new database named 'school_management'
-- Import the schema file: backend/sql/comprehensive_schema.sql
```

### Method 2: Manual Installation

#### For Windows:
```powershell
# 1. Install PHP
# Download from https://windows.php.net/download/
# Add PHP to system PATH

# 2. Install MySQL
# Download from https://dev.mysql.com/downloads/installer/
# Follow installation wizard

# 3. Configure PHP extensions
# Enable: pdo, pdo_mysql, mbstring, json
```

#### For Linux (Ubuntu/Debian):
```bash
# Update package list
sudo apt update

# Install PHP and required extensions
sudo apt install php php-mysql php-mbstring php-json php-curl

# Install MySQL
sudo apt install mysql-server

# Secure MySQL installation
sudo mysql_secure_installation
```

#### For macOS:
```bash
# Using Homebrew
brew install php mysql

# Start MySQL
brew services start mysql
```

---

## ⚙️ Configuration

### Step 1: Database Configuration
Edit `backend/config/database.php`:

```php
<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'school_management';
    private $username = 'root';        // Change for production
    private $password = '';            // Set your password
    private $conn;
    
    // ... rest of the configuration
}
?>
```

### Step 2: Import Database Schema
```sql
-- Method 1: Using phpMyAdmin
-- 1. Open http://localhost/phpmyadmin
-- 2. Select 'school_management' database
-- 3. Go to 'Import' tab
-- 4. Choose file: backend/sql/comprehensive_schema.sql
-- 5. Click 'Go'

-- Method 2: Using MySQL command line
mysql -u root -p school_management < backend/sql/comprehensive_schema.sql
```

### Step 3: Generate Sample Data
```bash
# Navigate to backend directory
cd backend/

# Run sample data generator
php generate_sample_data.php
```

### Step 4: Test Database Connection
```bash
# Test connection
php backend/test_connection.php

# Should output: "Database connection successful"
```

---

## 🧪 Testing

### Option 1: Built-in Test Suite
```bash
# Start PHP development server
php -S localhost:8000

# Open in browser:
# http://localhost:8000/system_test.html
```

### Option 2: Manual Testing
```bash
# Test individual components:

# 1. Database connection
php backend/test_connection.php

# 2. Authentication system
curl -X POST http://localhost:8000/backend/api/auth.php \
  -H "Content-Type: application/json" \
  -d '{"action":"login","email":"admin@school.edu","password":"admin123","role":"administrator"}'

# 3. Student API
curl http://localhost:8000/backend/api/students.php?action=get_all
```

### Default Login Credentials:
```
Administrator:
- Email: admin@school.edu
- Password: admin123

Teacher:
- Email: sarah.johnson@school.edu  
- Password: teacher123

Student:
- Email: aarav.sharma@student.edu
- Password: student123

Parent:
- Email: jennifer.anderson@parent.com
- Password: parent123
```

---

## 🌐 Deployment

### Local Development:
```bash
# PHP built-in server
php -S localhost:8000

# Access at: http://localhost:8000
```

### Production Deployment:

#### 1. Shared Hosting:
```bash
# 1. Upload all files to public_html/
# 2. Import database via cPanel/phpMyAdmin
# 3. Update database.php with hosting credentials
# 4. Set proper file permissions (755 for directories, 644 for files)
```

#### 2. VPS/Cloud Hosting:
```bash
# 1. Install LAMP/LEMP stack
# 2. Configure virtual host
# 3. Setup SSL certificate
# 4. Configure firewall
# 5. Set up database backups
```

#### 3. Docker Deployment:
```dockerfile
# Create Dockerfile (example)
FROM php:7.4-apache
COPY . /var/www/html/
RUN docker-php-ext-install mysqli pdo pdo_mysql
EXPOSE 80
```

---

## 🔐 Security Checklist

### For Production:
- [ ] Change default database credentials
- [ ] Update default user passwords
- [ ] Enable HTTPS/SSL
- [ ] Configure proper file permissions
- [ ] Set up regular database backups
- [ ] Configure firewall rules
- [ ] Update PHP and MySQL to latest versions
- [ ] Enable error logging (disable display_errors)
- [ ] Set up monitoring and alerts

---

## 🛠️ Troubleshooting

### Common Issues:

#### 1. Database Connection Failed
```
Solution:
- Check MySQL service is running
- Verify database credentials in backend/config/database.php
- Ensure database 'school_management' exists
- Check PHP PDO extension is enabled
```

#### 2. API Endpoints Not Working
```
Solution:
- Verify web server is running
- Check file permissions (PHP files should be readable)
- Ensure .htaccess allows PHP execution
- Check error logs for PHP errors
```

#### 3. Login Issues
```
Solution:
- Verify sample data was imported correctly
- Check user table has records
- Ensure password hashing is working
- Test with default credentials
```

#### 4. CSS/JS Not Loading
```
Solution:
- Check file paths are correct
- Verify web server can serve static files
- Clear browser cache
- Check browser developer console for errors
```

### Debug Mode:
Enable debugging in `backend/config/database.php`:
```php
// Add at the top of files for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

---

## 📞 Support

### Quick Start Checklist:
1. ✅ Install XAMPP/WAMP
2. ✅ Start Apache & MySQL
3. ✅ Copy project to htdocs
4. ✅ Create database
5. ✅ Import schema
6. ✅ Generate sample data
7. ✅ Test login

### File Structure:
```
school management/
├── index.html                 # Homepage
├── system_test.html          # Test suite
├── system_validation.html    # Validation report
├── setup.ps1                 # PowerShell setup script
├── setup.bat                 # Batch setup script
├── css/
│   ├── main.css
│   └── tailwind.css
├── pages/
│   ├── dashboard.html
│   ├── login.html
│   ├── student_management.html
│   ├── staff_directory.html
│   ├── fee_management.html
│   └── reports_analytics.html
└── backend/
    ├── config/
    │   └── database.php
    ├── classes/
    │   ├── Auth.php
    │   └── Student.php
    ├── api/
    │   ├── auth.php
    │   └── students.php
    ├── sql/
    │   └── comprehensive_schema.sql
    ├── test_connection.php
    ├── test_runner.php
    └── generate_sample_data.php
```

---

## 🎉 Success!

Your School Management System should now be running successfully!

**Next Steps:**
1. Explore the dashboard at `http://localhost:8000`
2. Test the login functionality
3. Review the student management features
4. Customize the system for your school's needs
5. Deploy to production when ready

**Happy coding! 🚀**
