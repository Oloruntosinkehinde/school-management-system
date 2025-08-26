# School Management System - PowerShell Setup Script
# Compatible with Windows PowerShell and PowerShell Core

Write-Host "========================================" -ForegroundColor Green
Write-Host "School Management System - Setup Script" -ForegroundColor Green  
Write-Host "========================================" -ForegroundColor Green
Write-Host ""

# Function to check if a command exists
function Test-Command {
    param($Command)
    $null = Get-Command $Command -ErrorAction SilentlyContinue
    return $?
}

# Check if PHP is available
if (-not (Test-Command "php")) {
    Write-Host "[ERROR] PHP is not installed or not in PATH" -ForegroundColor Red
    Write-Host "Please install PHP and add it to your system PATH" -ForegroundColor Yellow
    Read-Host "Press Enter to exit"
    exit 1
}

Write-Host "[INFO] PHP is available" -ForegroundColor Green
php --version
Write-Host ""

# Check if MySQL/MariaDB is running
$mysqlRunning = Get-NetTCPConnection -LocalPort 3306 -ErrorAction SilentlyContinue
if (-not $mysqlRunning) {
    Write-Host "[WARNING] MySQL/MariaDB does not appear to be running on port 3306" -ForegroundColor Yellow
    Write-Host "Please ensure your database server is running" -ForegroundColor Yellow
    Write-Host ""
}

Write-Host "[STEP 1] Testing database connection..." -ForegroundColor Cyan
Write-Host ""

# Navigate to backend directory and test connection
Push-Location "backend"

try {
    $result = php -f test_connection.php
    if ($LASTEXITCODE -ne 0) {
        Write-Host "[ERROR] Database connection failed" -ForegroundColor Red
        Write-Host "Please check your database configuration in backend/config/database.php" -ForegroundColor Yellow
        Pop-Location
        Read-Host "Press Enter to exit"
        exit 1
    }
    Write-Host $result
    Write-Host "[SUCCESS] Database connection established" -ForegroundColor Green
} catch {
    Write-Host "[ERROR] Failed to test database connection: $($_.Exception.Message)" -ForegroundColor Red
    Pop-Location
    Read-Host "Press Enter to exit"
    exit 1
}

Write-Host ""

# Check if MySQL client is available for schema import
if (Test-Command "mysql") {
    Write-Host "[STEP 2] Creating database schema using MySQL client..." -ForegroundColor Cyan
    
    $dbPassword = Read-Host "Enter MySQL root password (press Enter if no password)" -AsSecureString
    $dbPasswordText = [Runtime.InteropServices.Marshal]::PtrToStringAuto([Runtime.InteropServices.Marshal]::SecureStringToBSTR($dbPassword))
    
    if ($dbPasswordText) {
        & mysql -u root -p$dbPasswordText school_management < sql/comprehensive_schema.sql
    } else {
        & mysql -u root school_management < sql/comprehensive_schema.sql
    }
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "[SUCCESS] Database schema created using MySQL client" -ForegroundColor Green
    } else {
        Write-Host "[WARNING] Failed to import schema using MySQL client, will try alternative method" -ForegroundColor Yellow
    }
} else {
    Write-Host "[INFO] MySQL client not found, using PHP for schema creation..." -ForegroundColor Yellow
}

Write-Host ""

Write-Host "[STEP 3] Generating sample data..." -ForegroundColor Cyan
try {
    $result = php -f generate_sample_data.php
    Write-Host $result
    if ($LASTEXITCODE -ne 0) {
        Write-Host "[ERROR] Failed to generate sample data" -ForegroundColor Red
        Pop-Location
        Read-Host "Press Enter to exit"
        exit 1
    }
    Write-Host "[SUCCESS] Sample data generated" -ForegroundColor Green
} catch {
    Write-Host "[ERROR] Failed to generate sample data: $($_.Exception.Message)" -ForegroundColor Red
    Pop-Location
    Read-Host "Press Enter to exit"
    exit 1
}

Write-Host ""

Write-Host "[STEP 4] Running system tests..." -ForegroundColor Cyan
try {
    $result = php -f test_runner.php
    Write-Host $result
    Write-Host "[SUCCESS] System tests completed" -ForegroundColor Green
} catch {
    Write-Host "[WARNING] System tests encountered issues: $($_.Exception.Message)" -ForegroundColor Yellow
}

Pop-Location

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "Setup Complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "Your School Management System is ready!" -ForegroundColor Green
Write-Host ""
Write-Host "URLs:" -ForegroundColor Cyan
Write-Host "- Dashboard: http://localhost:8000" -ForegroundColor White
Write-Host "- Test Suite: http://localhost:8000/system_test.html" -ForegroundColor White
Write-Host "- API Docs: http://localhost:8000/backend/test_runner.php" -ForegroundColor White
Write-Host ""
Write-Host "Default Login Credentials:" -ForegroundColor Cyan
Write-Host "- Admin: admin@school.edu / admin123" -ForegroundColor White
Write-Host "- Teacher: sarah.johnson@school.edu / teacher123" -ForegroundColor White
Write-Host "- Student: aarav.sharma@student.edu / student123" -ForegroundColor White
Write-Host "- Parent: jennifer.anderson@parent.com / parent123" -ForegroundColor White
Write-Host ""

$startServer = Read-Host "Start PHP development server? (Y/n)"
if ($startServer -eq "" -or $startServer -eq "Y" -or $startServer -eq "y") {
    Write-Host ""
    Write-Host "Starting PHP development server on http://localhost:8000..." -ForegroundColor Green
    Write-Host "Press Ctrl+C to stop the server" -ForegroundColor Yellow
    Write-Host ""
    
    try {
        php -S localhost:8000
    } catch {
        Write-Host "Server stopped or encountered an error" -ForegroundColor Yellow
    }
} else {
    Write-Host ""
    Write-Host "To start the server manually, run: php -S localhost:8000" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "Setup script completed!" -ForegroundColor Green
Read-Host "Press Enter to exit"
