<?php
header('Content-Type: application/json');

// Specify the file to serve
$file = 'new_reservations.json';

if (file_exists($file)) {
    // Serve the file content
    echo file_get_contents($file);
} else {
    // Return an empty array if the file doesn't exist
    echo json_encode([]);
}
?>
