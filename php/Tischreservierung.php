<?php   
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        $_SESSION['reservation'] = [
            'zanemari!' => date('H:i d-m-Y'),
            'ime_prezime' => htmlspecialchars($_POST['name'] ?? ''),
            'datum' => htmlspecialchars($_POST['date'] ?? ''),
            'vrijeme' => htmlspecialchars($_POST['time'] ?? ''),
            'broj_gostiju' => (int) ($_POST['n_guests'] ?? 0),
            'telefon' => htmlspecialchars($_POST['telefon'] ?? ''),
            'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ?? '',
            'napolju' => isset($_POST['outside-area']),
            'Kinderstuhl' => isset($_POST['Kinderstuhl']),
            'Roolstuhl' => isset($_POST['Roolstuhl']),
            'Hund' => isset($_POST['Hund']),
            'Extra' => htmlspecialchars($_POST['extra'] ?? '')
        ];
        $reservation = $_SESSION['reservation'];
        
        $data[] = $reservation;

        #$api_key = getenv('TELEGRAM_BOT_TOKEN');
        #$chat_id = getenv('CHAT_ID');

        $jsonData = json_encode($data);
        $escapedData = escapeshellarg($jsonData);
        #$command = "/srv/www/ratsstuben-germering.de/GojinUnuk/send_msg_argv.py {$escapedData} {$api_key} {$chat_id} 2>&1";
        #$output = shell_exec($command);
        
        $process = proc_open(
            '/srv/www/ratsstuben-germering.de/GojinUnuk/send_msg_argv.py',
            [
                0 => ['pipe', 'r'], // stdin
                1 => ['pipe', 'w'], // stdout
                2 => ['pipe', 'w'], // stderr
            ],
            $pipes
        );
        
        if (is_resource($process)) {
            if (isset($pipes[0])) {
                fwrite($pipes[0], $escapedData);
                fclose($pipes[0]);
            }
            $output = isset($pipes[1]) ? stream_get_contents($pipes[1]) : '';
            if (isset($pipes[1])) fclose($pipes[1]);
            $error = isset($pipes[2]) ? stream_get_contents($pipes[2]) : '';
            if (isset($pipes[2])) fclose($pipes[2]);
            $return_value = proc_close($process);
        } else {
            $output = 'Proces nije poceo';
            $error = 'Failed to start process';
            $return_value = -1;
        }      
        
        if (trim($output) === '' && trim($error) === '') {
            header('Location: ./Die_Reservierung_ist_bestatigt.php');
            exit;
        } else {
            echo "Err1<br>Es ist ein Fehler aufgetreten.<br>Bitte reservieren Sie telefonisch:<br> <a href='tel:+4989847989'>+49 89 847989</a>";
            unset($_SESSION['reservation']);
        }
    }
else {
    echo "Err0<br>Es ist ein Fehler aufgetreten.<br>Dies tritt auf, wenn der Benutzer direkt <br>zu dieser Seite navigiert (die Startseite überspringt).<br> Bitte reservieren Sie telefonisch.<br>Telefonische Reservierungen sind von Dienstag bis Sonntag<br>von 11:30 bis 22:00 Uhr möglich.<br> <a href='tel:+4989847989'>+49 89 847989</a><br><br><a href='/index.html'>Zurück zur Startseite.</a>";
}

?>
