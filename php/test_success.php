<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Create mock reservation data for testing
$_SESSION['reservation'] = [
    'ime_prezime' => 'Max Mustermann',
    'telefon' => '+49 170 12345678',
    'email' => 'max.mustermann@example.de',
    'datum' => date('Y-m-d', strtotime('+3 days')),
    'vrijeme' => '19:00',
    'broj_gostiju' => '4',
    'napolju' => true,
    'Kinderstuhl' => true,
    'Roolstuhl' => false,
    'Hund' => false,
    'Extra' => 'Bitte am Fenster, falls möglich',
    'nastanak_rezervacije' => date('d.m.Y H:i')
];

// Include the actual success page
include 'Die_Reservierung_ist_bestatigt.php';
