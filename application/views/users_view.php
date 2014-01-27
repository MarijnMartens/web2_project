<?php

/*
 * Author: Marijn
 * Created on: 11/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

?>


<table border="1">
<?php
//Iterate through alphabet
foreach($alphabet as $key => $letter){
    //Search letters that are not empty
    if ($letter != null){ 
        echo '<th>';
        echo '<a href="#">' . $key . '</a>';
        echo '</th>';
        //print usernames for matching letter
        foreach($letter as $userData){
            echo '<tr>';
            echo '<td><a href="' . base_url() . 'profile/index/' . $userData->id . '">'. $userData->username . '</a></td>';
            echo '</tr>';
        }
    }
}
echo '<br/>';


?>
</table>
