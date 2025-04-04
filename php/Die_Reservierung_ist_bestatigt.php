<?php
session_start(); 

if (isset($_SESSION['reservation'])) {
    $reservation = $_SESSION['reservation'];
    echo"<h3>Reservierung wurde erfasst und <br>an das Restaurant gesendet.</h3>";
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
    echo "Err3<br>Es ist ein Fehler aufgetreten.<br>Dieser tritt auf, wenn der Benutzer direkt <br>auf diese Seite navigiert(Startseite überspringt) oder wenn die Seitenach dem Absenden<br> und Anzeigen der Reservierung aktualisiert wird.<br>Dies hat jedoch keinen Einfluss<br>auf die bereits getätigte Reservierung.<br>Telefonische Reservierungen sind Dienstag bis Sonntag<br>von 11:30 bis 22:00 Uhr möglich.<br> <a href='tel:+4989847989'>+49 89 847989</a><br><br><a href='/index.html'>Zurück zur Startseite.</a>";
    unset($_SESSION['reservation']);
}
?>
