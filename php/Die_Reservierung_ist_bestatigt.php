<?php
session_start(); 

if (isset($_SESSION['reservation'])) {
    $reservation = $_SESSION['reservation'];
    echo "<p>Im Falle einer Stornierung der Reservierung werden Sie kontaktiert.<br> Bitte hinterlassen Sie korrekte Informationen.</p>";
    echo "<h2>Reservierungsbestätigung</h2>";
    echo "<p><strong>Vorname und Nachname:</strong> " . $reservation['ime_prezime'] . "</p>";
    echo "<p><strong>Telefon:</strong> " . $reservation['telefon'] . "</p>";
    echo "<p><strong>Email:</strong> " . $reservation['email'] . "</p>";
    echo "<p><strong>Datum:</strong> " . $reservation['datum'] . "</p>";
    echo "<p><strong>Uhrzeit:</strong> " . $reservation['vrijeme'] . "</p>";
    echo "<p><strong>Anzahl der Gäste:</strong> " . $reservation['broj_gostiju'] . "</p>";
    echo "<p><strong>Reservierungszeitpunkt:</strong> " . $reservation['nastanak_rezervacije'] . "</p>";
    echo "<p><strong>Außenbereich:</strong> " . ($reservation['napolju'] ? 'Ja' : 'Nein') . "</p>";
    echo "<p><strong>Kinderstuhl:</strong> " . ($reservation['Kinderstuhl'] ? 'Ja' : 'Nein') . "</p>";
    echo "<p><strong>Roolstuhl:</strong> " . ($reservation['Roolstuhl'] ? 'Ja' : 'Nein') . "</p>";
    echo "<p><strong>Hund:</strong> " . ($reservation['Hund'] ? 'Ja' : 'Nein') . "</p>";
    echo "<p><strong>Extras:</strong> " . $reservation['Extra'] . "</p>";
    
    unset($_SESSION['reservation']);
} else {
    echo "<p>Reservierungsdaten sind nicht verfügbar.</p>";
    unset($_SESSION['reservation']);
}
?>
