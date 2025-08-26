<?php
/**
 * XAMPP Diagnostic Script
 * This will help identify specific issues with the school management system
 */

echo "<h1>🔍 XAMPP Diagnostic Report</h1>";
echo "<style>body{font-family:Arial;max-width:1000px;margin:20px auto;padding:20px;background:#f5f5f5;} .success{color:green;} .error{color:red;} .warning{color:orange;} table{width:100%;border-collapse:collapse;} th,td{border:1px solid #ddd;padding:8px;text-align:left;} th{background:#f2f2f2;}</style>";

// Test 1: Basic PHP
echo "<h2>📋 Test 1: PHP Environment</h2>";
echo "<table>";
echo "<tr><th>Check</th><th>Status</th><th>Details</th></tr>";
echo "<tr><td>PHP Version</td><td class='success'>✅ PASS</td><td>" . PHP_VERSION . "</td></tr>";
echo "<tr><td>Server Software</td><td class='success'>✅ PASS</td><td>" . $_SERVER['SERVER_SOFTWARE'] . "</td></tr>";
echo "<tr><td>Document Root</td><td class='success'>✅ PASS</td><td>" . $_SERVER['DOCUMENT_ROOT'] . "</td></tr>";
echo "<tr><td>Current Directory</td><td class='success'>✅ PASS</td><td>" . __DIR__ . "</td></tr>";
echo "</table><br>";

// Test 2: File Permissions
echo "<h2>📁 Test 2: File System</h2>";
echo "<table>";
echo "<tr><th>File/Directory</th><th>Status</th><th>Details</th></tr>";

$paths = [
    'index.html',
    'pages/',
    'pages/login.html',
    'pages/dashboard.html',
    'pages/student_management.html',
    'pages/attendance_management.html',
    'backend/',
    'backend/config/',
    'backend/config/database.php',
    'backend/sql/',
    'backend/sql/comprehensive_schema.sql',
    'css/',
    'css/main.css'
];

foreach($paths as $path) {
    if(file_exists($path)) {
        $status = is_readable($path) ? "<span class='success'>✅ READABLE</span>" : "<span class='error'>❌ NOT READABLE</span>";
        $type = is_dir($path) ? "Directory" : "File (" . round(filesize($path)/1024, 2) . " KB)";
        echo "<tr><td>$path</td><td>$status</td><td>$type</td></tr>";
    } else {
        echo "<tr><td>$path</td><td class='error'>❌ MISSING</td><td>File not found</td></tr>";
    }
}
echo "</table><br>";

// Test 3: Database Connection
echo "<h2>🗄️ Test 3: Database Connection</h2>";
echo "<table>";
echo "<tr><th>Test</th><th>Status</th><th>Details</th></tr>";

try {
    // Test MySQL connection
    $pdo = new PDO("mysql:host=localhost", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<tr><td>MySQL Connection</td><td class='success'>✅ SUCCESS</td><td>Connected to MySQL server</td></tr>";
    
    // Test if database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE 'school_management'");
    if($stmt->rowCount() > 0) {
        echo "<tr><td>Database Exists</td><td class='success'>✅ SUCCESS</td><td>school_management database found</td></tr>";
        
        // Connect to specific database
        $pdo = new PDO("mysql:host=localhost;dbname=school_management", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Check tables
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $tableCount = count($tables);
        
        if($tableCount > 0) {
            echo "<tr><td>Database Tables</td><td class='success'>✅ SUCCESS</td><td>$tableCount tables found</td></tr>";
            
            // Check for users table specifically
            if(in_array('users', $tables)) {
                $stmt = $pdo->query("SELECT COUNT(*) FROM users");
                $userCount = $stmt->fetchColumn();
                echo "<tr><td>Sample Data</td><td class='success'>✅ SUCCESS</td><td>$userCount users in database</td></tr>";
            } else {
                echo "<tr><td>Users Table</td><td class='error'>❌ MISSING</td><td>Users table not found</td></tr>";
            }
        } else {
            echo "<tr><td>Database Tables</td><td class='error'>❌ EMPTY</td><td>No tables found - need to import SQL</td></tr>";
        }
        
    } else {
        echo "<tr><td>Database Exists</td><td class='error'>❌ MISSING</td><td>school_management database not found</td></tr>";
    }
    
} catch(PDOException $e) {
    echo "<tr><td>Database Connection</td><td class='error'>❌ FAILED</td><td>Error: " . $e->getMessage() . "</td></tr>";
}
echo "</table><br>";

// Test 4: PHP Configuration
echo "<h2>⚙️ Test 4: PHP Configuration</h2>";
echo "<table>";
echo "<tr><th>Setting</th><th>Status</th><th>Value</th></tr>";

$phpSettings = [
    'display_errors' => ini_get('display_errors'),
    'error_reporting' => error_reporting(),
    'max_execution_time' => ini_get('max_execution_time'),
    'memory_limit' => ini_get('memory_limit'),
    'post_max_size' => ini_get('post_max_size'),
    'upload_max_filesize' => ini_get('upload_max_filesize')
];

foreach($phpSettings as $setting => $value) {
    $status = "<span class='success'>✅ OK</span>";
    if($setting == 'display_errors' && !$value) {
        $status = "<span class='warning'>⚠️ DISABLED</span>";
    }
    echo "<tr><td>$setting</td><td>$status</td><td>$value</td></tr>";
}
echo "</table><br>";

// Test 5: URL Access Test
echo "<h2>🌐 Test 5: URL Access</h2>";
echo "<table>";
echo "<tr><th>URL</th><th>Test</th><th>Action</th></tr>";
echo "<tr><td>http://localhost/school_management/</td><td>Main App</td><td><a href='http://localhost/school_management/' target='_blank'>🔗 Test</a></td></tr>";
echo "<tr><td>http://localhost/school_management/pages/login.html</td><td>Login Page</td><td><a href='http://localhost/school_management/pages/login.html' target='_blank'>🔗 Test</a></td></tr>";
echo "<tr><td>http://localhost/school_management/pages/dashboard.html</td><td>Dashboard</td><td><a href='http://localhost/school_management/pages/dashboard.html' target='_blank'>🔗 Test</a></td></tr>";
echo "<tr><td>http://localhost/phpmyadmin</td><td>phpMyAdmin</td><td><a href='http://localhost/phpmyadmin' target='_blank'>🔗 Test</a></td></tr>";
echo "</table><br>";

// Test 6: JavaScript Console Errors Check
echo "<h2>💻 Test 6: Common Issues Check</h2>";
echo "<div style='background:white;padding:15px;border-radius:5px;border-left:4px solid #007cba;'>";
echo "<h3>🔍 What to check if pages don't work:</h3>";
echo "<ol>";
echo "<li><strong>Browser Console:</strong> Press F12, check Console tab for JavaScript errors</li>";
echo "<li><strong>Network Tab:</strong> Check if CSS/JS files are loading (should show 200 status)</li>";
echo "<li><strong>PHP Errors:</strong> Check if display_errors is enabled above</li>";
echo "<li><strong>File Permissions:</strong> All files should be readable as shown in Test 2</li>";
echo "<li><strong>Database:</strong> Import the SQL file if tables are missing</li>";
echo "</ol>";
echo "</div><br>";

// Summary
echo "<h2>📊 Summary & Next Steps</h2>";
echo "<div style='background:white;padding:15px;border-radius:5px;'>";

// Count issues
$issues = [];
if(!file_exists('backend/config/database.php')) $issues[] = "Database config missing";

if(empty($issues)) {
    echo "<div class='success'><h3>✅ Setup looks good!</h3>";
    echo "<p>Your XAMPP environment appears to be configured correctly.</p>";
    echo "<p><strong>Next:</strong> <a href='http://localhost/school_management/'>Access your School Management System</a></p>";
    echo "</div>";
} else {
    echo "<div class='error'><h3>❌ Issues Found:</h3>";
    echo "<ul>";
    foreach($issues as $issue) {
        echo "<li>$issue</li>";
    }
    echo "</ul></div>";
}
echo "</div>";

echo "<hr>";
echo "<p><small>Diagnostic completed at " . date('Y-m-d H:i:s') . "</small></p>";
?>
