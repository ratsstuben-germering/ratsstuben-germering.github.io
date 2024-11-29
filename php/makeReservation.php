<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = htmlspecialchars($_POST['name'] ?? '');
    $telefon = htmlspecialchars($_POST['telefon'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $date = htmlspecialchars($_POST['date'] ?? '');
    $time = htmlspecialchars($_POST['time'] ?? '');
    $n_guests = htmlspecialchars($_POST['n_guests'] ?? '');
    $outsideArea = isset($_POST['outside-area']) ? 'Yes' : 'No';
    $kinderstuhl = isset($_POST['Kinderstuhl']) ? 'Yes' : 'No';
    $roolstuhl = isset($_POST['Roolstuhl']) ? 'Yes' : 'No';
    $hund = isset($_POST['Hund']) ? 'Yes' : 'No';
    $extra = htmlspecialchars($_POST['extra'] ?? '');

    // Email recipient and subject
    $to = "antegojin@gmail.com"; // Replace with your email address
    $subject = "NovaRezervacija";

    // Build email message
    $message = "Nova rezervacija je stigla:\n\n";
    $message .= "Name: $name\n";
    $message .= "Telefon: $telefon\n";
    $message .= "Email: $email\n";
    $message .= "Date: $date\n";
    $message .= "Time: $time\n";
    $message .= "Number of Guests: $n_guests\n";
    $message .= "Outside Area: $outsideArea\n";
    $message .= "Kinderstuhl: $kinderstuhl\n";
    $message .= "Roolstuhl: $roolstuhl\n";
    $message .= "Hund: $hund\n";
    $message .= "Extra Information: $extra\n";

    // Additional email headers
    $headers = "From: anton@ratsstuben-germering.de" . "\r\n" . // Replace with your sender email
               "Reply-To: 1josip.stojanovic@gmail.com" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        // Redirect to confirmation page
        echo "Die_Reservierung_ist_bestatigt";
        //header('Location: ../Die_Reservierung_ist_bestatigt.html');
        //exit;
    } else {
        echo "There was an error sending your reservation request. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
?>
