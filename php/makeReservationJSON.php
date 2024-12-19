<?php
 $myfile = fopen("/testfile.txt", "w") 
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     // Capture form data
//     $reservation = [
//         'name' => $_POST['name'] ?? '',
//         'telefon' => $_POST['telefon'] ?? '',
//         'email' => $_POST['email'] ?? '',
//         'date' => $_POST['date'] ?? '',
//         'time' => $_POST['time'] ?? '',
//         'n_guests' => $_POST['n_guests'] ?? '',
//         'outside_area' => isset($_POST['outside-area']),
//         'kinderstuhl' => isset($_POST['Kinderstuhl']),
//         'roolstuhl' => isset($_POST['Roolstuhl']),
//         'hund' => isset($_POST['Hund']),
//         'extra' => $_POST['extra'] ?? ''
//     ];

//     // File to store the reservations
//     $file = '/new_reservations.json';
//     //$myfile = fopen("/new_reservations.json", "w") 
//     // Check if the file exists, read the content, and decode the JSON
//     if (file_exists($file)) 
//     {
//         if ($data === null) 
//         {
//             $data = [];
//         }
//         else {$data = json_decode(file_get_contents($file), true);}
//     } 
//     else {$data = [];}

//     // Append the new reservation to the data
//     $data[] = $reservation;

//     if (file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT))) {
//         echo "Reservation saved successfully!";
//     } else {
//         echo "Error saving reservation. Please try again.";
//     }
// } else {
//     echo "Invalid request method.";
// }
?>
