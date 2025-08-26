<?php
/**
 * Database Setup and Test Script
 * Run this file to set up the database and test connectivity
 */

// Database configuration for XAMPP
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'school_management';

echo "<h1>School Management System - Database Setup</h1>";
echo "<hr>";

try {
    // Test MySQL connection
    echo "<h2>Step 1: Testing MySQL Connection</h2>";
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ MySQL connection successful!<br><br>";

    // Create database
    echo "<h2>Step 2: Creating Database</h2>";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $database");
    echo "✅ Database '$database' created successfully!<br><br>";

    // Connect to the specific database
    echo "<h2>Step 3: Connecting to School Management Database</h2>";
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connected to '$database' database!<br><br>";

    // Check if tables exist
    echo "<h2>Step 4: Checking Database Tables</h2>";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "⚠️ No tables found. You need to import the SQL schema.<br>";
        echo "<strong>Next Steps:</strong><br>";
        echo "1. Go to phpMyAdmin: <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a><br>";
        echo "2. Select the 'school_management' database<br>";
        echo "3. Import the file: backend/sql/comprehensive_schema.sql<br><br>";
    } else {
        echo "✅ Found " . count($tables) . " tables in the database:<br>";
        foreach ($tables as $table) {
            echo "- $table<br>";
        }
        echo "<br>";
        
        // Test sample data
        if (in_array('users', $tables)) {
            $stmt = $pdo->query("SELECT COUNT(*) FROM users");
            $userCount = $stmt->fetchColumn();
            echo "✅ Users table has $userCount records<br>";
        }
    }

    echo "<h2>Step 5: Testing File Permissions</h2>";
    if (is_writable(__DIR__)) {
        echo "✅ Directory is writable<br>";
    } else {
        echo "⚠️ Directory permissions may need adjustment<br>";
    }

    echo "<h2>🎉 Setup Complete!</h2>";
    echo "<p>Your XAMPP environment is ready. Access your application at:</p>";
    echo "<a href='http://localhost/school_management/' target='_blank'>http://localhost/school_management/</a><br><br>";

} catch(PDOException $e) {
    echo "<h2>❌ Database Error</h2>";
    echo "Error: " . $e->getMessage() . "<br>";
    echo "<br><strong>Common Solutions:</strong><br>";
    echo "1. Make sure XAMPP MySQL service is running<br>";
    echo "2. Check if the MySQL port (3306) is available<br>";
    echo "3. Verify MySQL root user has no password set<br>";
    echo "4. Try restarting XAMPP services<br>";
}

echo "<hr>";
echo "<p><strong>XAMPP Access URLs:</strong></p>";
echo "- XAMPP Control Panel<br>";
echo "- phpMyAdmin: <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a><br>";
echo "- School Management: <a href='http://localhost/school_management/' target='_blank'>http://localhost/school_management/</a><br>";
?>

<style>
body { 
    font-family: Arial, sans-serif; 
    max-width: 800px; 
    margin: 20px auto; 
    padding: 20px;
    background: #f5f5f5;
}
h1, h2 { color: #333; }
a { color: #007cba; text-decoration: none; }
a:hover { text-decoration: underline; }
</style>
