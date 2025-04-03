<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture and sanitize form data
    $reservation = [
        'nastanak_rezervacije' => date('H-i d-m-Y'), 
        'ime_prezime' => htmlspecialchars($_POST['name'] ?? ''),
        'telefon' => htmlspecialchars($_POST['telefon'] ?? ''),
        'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ?? '',
        'datum' => htmlspecialchars($_POST['date'] ?? ''),
        'vrijeme' => htmlspecialchars($_POST['time'] ?? ''),
        'broj_gostiju' => (int) ($_POST['n_guests'] ?? 0),
        'napolju' => isset($_POST['outside-area']),
        'Kinderstuhl' => isset($_POST['Kinderstuhl']),
        'Roolstuhl' => isset($_POST['Roolstuhl']),
        'Hund' => isset($_POST['Hund']),
        'Extra' => htmlspecialchars($_POST['extra'] ?? '')
    ];

    $file = __DIR__ . '/../new_reservations.json';

    $data = [];

    if (file_exists($file)) {
        $fileContents = file_get_contents($file);
        $data = json_decode($fileContents, true);

        if ($data === null) {
            $data = []; 
        }
    }

    $data[] = $reservation;

    if (file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT))) {
        header('Location: ../Die_Reservierung_ist_bestatigt.html');
        exit;
    } else {
        echo "Error saving reservation. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
?>
