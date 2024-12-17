<?php
header('Content-Type: application/json');

// File paths
$approvedFile = 'approved_reservations.json';
$rejectedFile = 'rejected_reservations.json';

// Ensure request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input data (assume JSON format)
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (isset($data['type']) && isset($data['reservation'])) {
        $file = $data['type'] === 'approved' ? $approvedFile : $rejectedFile;

        // Read current contents
        $currentData = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

        // Append new reservation
        $currentData[] = $data['reservation'];

        // Write updated data back to file
        file_put_contents($file, json_encode($currentData, JSON_PRETTY_PRINT));

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
