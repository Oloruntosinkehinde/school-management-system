@echo off
echo ========================================
echo School Management System - Setup Script
echo ========================================
echo.

:: Check if PHP is available
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] PHP is not installed or not in PATH
    echo Please install PHP and add it to your system PATH
    pause
    exit /b 1
)

echo [INFO] PHP is available
echo.

:: Check if MySQL/MariaDB is running (basic check)
netstat -an | findstr :3306 >nul 2>&1
if %errorlevel% neq 0 (
    echo [WARNING] MySQL/MariaDB does not appear to be running on port 3306
    echo Please ensure your database server is running
    echo.
)

echo [STEP 1] Setting up database schema...
echo.

:: Navigate to backend directory
cd backend

:: Test database connection first
php -f test_connection.php
if %errorlevel% neq 0 (
    echo [ERROR] Database connection failed
    echo Please check your database configuration in backend/config/database.php
    pause
    exit /b 1
)

echo [SUCCESS] Database connection established
echo.

echo [STEP 2] Creating database schema...
mysql -u root -p school_management < sql/comprehensive_schema.sql
if %errorlevel% neq 0 (
    echo [ERROR] Failed to create database schema
    echo Please check your MySQL credentials and try again
    pause
    exit /b 1
)

echo [SUCCESS] Database schema created
echo.

echo [STEP 3] Generating sample data...
php -f generate_sample_data.php
if %errorlevel% neq 0 (
    echo [ERROR] Failed to generate sample data
    pause
    exit /b 1
)

echo [SUCCESS] Sample data generated
echo.

echo [STEP 4] Running system tests...
php -f test_runner.php?action=test
echo.

echo [STEP 5] Starting development server...
echo.
echo ========================================
echo Setup Complete!
echo ========================================
echo.
echo Your School Management System is ready!
echo.
echo Dashboard URL: http://localhost:8000
echo Test Suite: http://localhost:8000/system_test.html
echo.
echo Default Login Credentials:
echo - Admin: admin@school.edu / admin123
echo - Teacher: sarah.johnson@school.edu / teacher123  
echo - Student: aarav.sharma@student.edu / student123
echo - Parent: jennifer.anderson@parent.com / parent123
echo.
echo Starting PHP development server...
echo Press Ctrl+C to stop the server
echo.

:: Start PHP development server
cd ..
php -S localhost:8000

pause
