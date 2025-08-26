<?php
// Direct test of auth functionality
$_POST['email'] = 'admin@school.edu';
$_POST['password'] = 'admin123';

// Capture any output
ob_start();

try {
    // Include the auth file directly
    include 'backend/api/auth.php';
    $output = ob_get_contents();
} catch (Exception $e) {
    $output = "Error: " . $e->getMessage();
}

ob_end_clean();

echo "Direct auth test result:\n";
echo $output . "\n";
?>
