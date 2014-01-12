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
    echo 'Voornaam ' . $userdata['fName'] . '<br/>';
    echo 'Achternaam ' . $userdata['lName'] . '<br/>';
    echo 'Geboortedatum ' . $userdata['dateOfBirth'] . '<br/>';
    echo 'Geslacht ' . $userdata['gender'] . '<br/>';
    echo 'Regio ' . $userdata['city'] . '<br/>';
?>

<a href="edit">Pas gegevens aan</a>
<br/>
<a href="editLogin">Pas wachtwoord aan</a>