<?php
/**
 * Tischreservierung - Reservation Processing Script
 * Handles table reservation requests with security validation
 */

// Debug: Check if security.php exists
if (!file_exists(__DIR__ . '/security.php')) {
    error_log("DEBUG: security.php NOT FOUND at " . __DIR__ . '/security.php');
    die("Error: security.php missing. Please re-deploy.");
}

require_once __DIR__ . '/security.php';

// Set security headers
try {
    setSecurityHeaders();
} catch (Exception $e) {
    error_log("DEBUG: setSecurityHeaders failed: " . $e->getMessage());
    die("Error: Security headers failed.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !validateCsrfToken($_POST['csrf_token'])) {
        http_response_code(403);
        logError('CSRF validation failed', ['ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown']);
        die('Ungültige Anfrage. Bitte laden Sie die Seite neu und versuchen Sie es erneut.');
    }

    // Validate honeypot (spam protection)
    if (!validateHoneypot()) {
        http_response_code(403);
        die('Spam detected');
    }

    // Validate and sanitize inputs
    $name = sanitizeString($_POST['name'] ?? '', 100);
    $date = sanitizeString($_POST['date'] ?? '', 20);
    $time = sanitizeString($_POST['time'] ?? '', 10);
    $nGuests = sanitizeInt($_POST['n_guests'] ?? 0);
    $telefon = sanitizeString($_POST['telefon'] ?? '', 30);
    $email = sanitizeEmail($_POST['email'] ?? '');
    $extra = sanitizeString($_POST['extra'] ?? '', 500);

    // Server-side validation
    if (empty($name) || empty($date) || empty($time) || $nGuests < 1 || empty($telefon)) {
        http_response_code(400);
        die('Bitte füllen Sie alle Pflichtfelder aus.');
    }

    if (!validateDate($date)) {
        http_response_code(400);
        die('Ungültiges Datumsformat.');
    }

    if (!validateTime($time)) {
        http_response_code(400);
        die('Ungültiges Zeitformat.');
    }

    $_SESSION['reservation'] = [
        'timestamp' => date('H:i d-m-Y'),
        'name' => $name,
        'date' => $date,
        'time' => $time,
        'guests' => $nGuests,
        'phone' => $telefon,
        'email' => $email,
        'outside' => isset($_POST['outside-area']),
        'child_seat' => isset($_POST['Kinderstuhl']),
        'wheelchair' => isset($_POST['Roolstuhl']),
        'dog' => isset($_POST['Hund']),
        'extra' => $extra
    ];
        $reservation = $_SESSION['reservation'];
        
        $data[] = $reservation;

        $api_key = getenv('TELEGRAM_BOT_TOKEN');
        $chat_id = getenv('CHAT_ID');

        $jsonData = json_encode($data);

        // Debug: Check if env vars are set
        if (empty($api_key) || empty($chat_id)) {
            logError('Telegram credentials not configured', [
                'has_api_key' => !empty($api_key),
                'has_chat_id' => !empty($chat_id)
            ]);
            http_response_code(500);
            die(getSafeErrorMessage() . '<br><small>(Debug: Server configuration error)</small>');
        }

        $process = proc_open(
            "/srv/www/ratsstuben-germering.de/GojinUnuk/send_msg_argv.py {$api_key} {$chat_id}",
            [
                0 => ['pipe', 'r'], // stdin
                1 => ['pipe', 'w'], // stdout
                2 => ['pipe', 'w'], // stderr
            ],
            $pipes
        );
        
        if (is_resource($process)) {
            if (isset($pipes[0])) {
                fwrite($pipes[0], $jsonData);
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
            // Log error securely without exposing details
            logError('Reservation processing failed', [
                'return_code' => $return_value,
                'has_output' => !empty(trim($output)),
                'has_error' => !empty(trim($error))
            ]);

            http_response_code(500);
            echo getSafeErrorMessage();
            unset($_SESSION['reservation']);
        }
    }
else {
    logError('Direct access to PHP script without POST');
    http_response_code(405);
    echo "Es ist ein Fehler aufgetreten.<br>Dies tritt auf, wenn der Benutzer direkt zu dieser Seite navigiert.<br> Bitte reservieren Sie telefonisch.<br>Telefonische Reservierungen sind von Dienstag bis Sonntag<br>von 11:30 bis 22:00 Uhr möglich.<br> <a href='tel:+4989847989'>+49 89 847989</a><br><br><a href='/index.html'>Zurück zur Startseite.</a>";
}

?>
