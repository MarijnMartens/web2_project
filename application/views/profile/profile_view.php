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
if ($userdata['gender'] = 'm'){
    $gender = 'Man';
} else {
    $gender = 'Vrouw';
}
$dateOfBirth = $userdata['dateOfBirth'];
$dateOfBirth = explode('-', $dateOfBirth);
$monthDigit = ltrim($dateOfBirth[1], '0'); //remove starting 0 if present
    echo 'Voornaam ' . $userdata['fName'] . '<br/>';
    echo 'Achternaam ' . $userdata['lName'] . '<br/>';
    echo 'Geboortedatum ' . $dateOfBirth[2] . ' ' . $months[$monthDigit] . ' ' . $dateOfBirth[0] . '<br/>';
    echo 'Geslacht ' . $gender . '<br/>';
    echo 'Regio ' . $userdata['city'] . '<br/>';
?>

<a href="edit">Pas gegevens aan</a>
<br/>
<a href="editLogin">Pas wachtwoord aan</a>