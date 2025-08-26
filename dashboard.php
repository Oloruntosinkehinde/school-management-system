<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

require 'db.php';

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Optional: Fetch user info from DB
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?= htmlspecialchars($user['username']) ?>!</h2>
    <p>You are logged in as <strong><?= $role ?></strong>.</p>
    
    <!-- Role-specific content -->
    <?php if ($role === 'admin'): ?>
        <p><a href="admin_panel.php">Go to Admin Panel</a></p>
    <?php elseif ($role