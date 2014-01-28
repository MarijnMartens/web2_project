<?php

/*
 * Author: Marijn
 * Created on: 11/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<h2>Edit profile</h2>
<?php echo $error; ?>
<?php
$this->load->helper('form');
$this->load->helper('date');
$days = array(1 => 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
$months = array(1 => 'Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December');
for($i = date('Y')-16; $i >= date('Y')-70; $i--){
            $years[$i] = $i;
}
echo form_open('profile/saveSecure');
echo form_label('Email', 'email');
echo form_input($userdata['email']);
echo '<br/>';
echo form_label('Herhaal Email', 'emailConf');
echo form_input($userdata['emailConf']);
echo '<br/>';
echo form_label('Nieuw wachtwoord', 'password');
echo form_password($userdata['password']);
echo '<br/>';
echo form_label('Herhaal nieuw wachtwoord', 'passwordConf');
echo form_password($userdata['passwordConf']);
echo '<br/>';
echo form_label('Oud wachtwoord', 'passwordOld');
echo form_password($userdata['passwordOld']);
echo '<br/>';
echo form_submit('submit', 'Wijzig inloggegevens');
echo form_close();

echo '<br/><br/>';

echo form_open_multipart('profile/save');
echo form_label('Avatar', 'userfile');
echo form_upload($userdata['avatar']);
echo '<br/>';
echo form_label('Voornaam', 'fName');
echo form_input($userdata['fName']);
echo '<br/>';
echo form_label('Achternaam', 'lName');
echo form_input($userdata['lName']);
echo '<br/>';
echo form_label('Geboortedatum', 'dateOfBirth');
//if data is empty take first of list
if($userdata['dateOfBirth'] == ''){
    $dateOfBirth[0] = key($years);
    $dateOfBirth[1] = key($months);
    $dateOfBirth[2] = key($days);
} else {
$dateOfBirth = explode('-', $userdata['dateOfBirth']);
}
echo form_dropdown('day', $days, $dateOfBirth[2]);
echo form_dropdown('month', $months, $dateOfBirth[1]);
echo form_dropdown('year', $years, $dateOfBirth[0]);
echo '<br/>';
echo form_label('Geslacht m / v', 'gender');
echo form_radio($userdata['genderM']);
echo form_radio($userdata['genderF']);
echo '<br/>';
echo form_label('Locatie', 'city');
echo form_input($userdata['city']);
echo '<br/>';
echo form_submit('submit', 'Pas gegevens aan');
echo form_close();
//Do not change anyting
echo form_open('profile');
echo form_submit('cancel', 'Annuleer');
echo form_close();

?>