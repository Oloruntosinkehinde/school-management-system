<?php
require_once 'backend/config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    echo "Users created in database:\n";
    $stmt = $db->query("SELECT user_id, email, role, first_name, last_name FROM users ORDER BY role, email");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($users as $user) {
        echo "- [{$user['role']}] {$user['first_name']} {$user['last_name']} ({$user['email']})\n";
    }
    
    echo "\nTotal users: " . count($users) . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
