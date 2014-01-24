<?php
/*
 * Author: Marijn
 * Created on: 11/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<h2>Profile Details</h2>
<?php
$months = array(1 => 'Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December');
if ($userdata->gender == 'm') {
    $gender = 'Man';
} else if ($userdata->gender == 'f') {
    $gender = 'Vrouw';
} else {
    $gender = '';
}
$dateOfBirth = $userdata->dateOfBirth;
$dateOfBirth2 = explode('-', $dateOfBirth);
echo '<img class="avatar" src="' . base_url() . 'assets/images/avatars/' . $userdata->avatar . '" alt="Avatar"/><br/>'; 
echo 'Voornaam ' . $userdata->fName . '<br/>';
echo 'Achternaam ' . $userdata->lName . '<br/>';
if ($dateOfBirth != '') {
    $monthDigit = ltrim($dateOfBirth2[1], '0'); //remove starting 0 if present
    echo 'Geboortedatum ' . $dateOfBirth2[2] . ' ' . $months[$monthDigit] . ' ' . $dateOfBirth2[0] . '<br/>';
} else {
    echo 'Geboortedatum </br>';
}
echo 'Geslacht ' . $gender . '<br/>';
echo 'Regio ' . $userdata->city . '<br/>';
?>