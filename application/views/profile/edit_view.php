<?php

/*
 * Author: Marijn
 * Created on: 11/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<h2>Edit profile</h2>
<?php
$this->load->helper('form');
echo form_open('profile/save');
echo form_label('Voornaam', 'fName');
echo form_input($userdata['fName']);
echo '<br/>';
echo form_label('Achternaam', 'lName');
echo form_input($userdata['lName']);
echo '<br/>';
echo form_label('Geboortedatum', 'dateOfBirth');
echo form_input($userdata['dateOfBirth']);
echo '<br/>';
/*echo form_label('Geslacht', 'gender');
echo form_radio($userdata['genderM']);
echo form_radio($userdata['genderF']);*/
echo '<br/>';
echo form_label('Locatie', 'city');
echo form_input($userdata['city']);
echo '<br/>';
echo form_submit('submit', 'Pas gegevens aan');
echo form_reset('reset', 'Annuleren');
echo form_close();
?>