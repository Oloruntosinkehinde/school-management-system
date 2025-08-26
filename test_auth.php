<?php
// Test authentication API
$url = 'http://localhost:8000/backend/api/auth.php';
$data = json_encode([
    'email' => 'admin@school.edu',
    'password' => 'admin123'
]);

$options = [
    'http' => [
        'header' => "Content-type: application/json\r\n",
        'method' => 'POST',
        'content' => $data
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

echo "Authentication test result:\n";
echo $result . "\n";

if ($http_response_header) {
    echo "\nHTTP Response Headers:\n";
    foreach ($http_response_header as $header) {
        echo $header . "\n";
    }
}
?>
