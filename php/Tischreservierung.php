<?php
    $api_key = getenv('TELEGRAM_BOT_TOKEN');
    $chat_id = getenv('CHAT_ID');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $_SESSION['reservation'] = [
        'zanemari!' => date('H:i d-m-Y'),
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
    $reservation = $_SESSION['reservation'];
    // $file = __DIR__ . '/../new_reservations.json';
    // $data = [];
    // if (file_exists($file)) {
    //     $fileContents = file_get_contents($file);
    //     $data = json_decode($fileContents, true);
    //     if ($data === null) {
    //         $data = []; 
    //     }
    // }
    $data[] = $reservation;

    // if (file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT))) {
    //     header('Location: ./Die_Reservierung_ist_bestatigt.php');
    //     exit;
    // } else {
    //     echo "Es ist ein Fehler aufgetreten.<br>Bitte reservieren Sie telefonisch:<br> <a href='tel:+4989847989'>+49 89 847989</a>";
    //     unset($_SESSION['reservation']);
    // }

    $jsonData = json_encode($data);
    $escapedData = escapeshellarg($jsonData);
    $command = "/srv/www/ratsstuben-germering.de/GojinUnuk/send_msg_argv.py {$escapedData} {$api_key} {$chat_id} 2>&1";
    $output = shell_exec($command);
    if (trim($output) === '') {
        header('Location: ./Die_Reservierung_ist_bestatigt.php');
        exit;
    } else {
        echo "1<br>Es ist ein Fehler aufgetreten.<br>Bitte reservieren Sie telefonisch:<br> <a href='tel:+4989847989'>+49 89 847989</a>";
        unset($_SESSION['reservation']);
    }

}
else {
    echo "0<br>Es ist ein Fehler aufgetreten.<br>Bitte reservieren Sie telefonisch:<br> <a href='tel:+4989847989'>+49 89 847989</a>";
}

?>
