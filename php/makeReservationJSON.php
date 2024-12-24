<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture and sanitize form data
    $reservation = [
        'name' => htmlspecialchars($_POST['name'] ?? ''),
        'telefon' => htmlspecialchars($_POST['telefon'] ?? ''),
        'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ?? '',
        'date' => htmlspecialchars($_POST['date'] ?? ''),
        'time' => htmlspecialchars($_POST['time'] ?? ''),
        'n_guests' => (int) ($_POST['n_guests'] ?? 0),
        'outside_area' => isset($_POST['outside-area']),
        'kinderstuhl' => isset($_POST['Kinderstuhl']),
        'roolstuhl' => isset($_POST['Roolstuhl']),
        'hund' => isset($_POST['Hund']),
        'extra' => htmlspecialchars($_POST['extra'] ?? '')
    ];

    // File to store the reservations in the top-level directory
    $file = __DIR__ . '/../new_reservations.json';

    // Initialize the data array
    $data = [];

    // Check if the file exists and read its contents
    if (file_exists($file)) {
        $fileContents = file_get_contents($file);
        $data = json_decode($fileContents, true);

        if ($data === null) {
            $data = []; // Handle cases where the JSON is invalid
        }
    }

    // Append the new reservation to the data
    $data[] = $reservation;

    // Save the updated data back to the file
    if (file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT))) {
        echo "Reservation saved successfully!";
    } else {
        echo "Error saving reservation. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
?>
