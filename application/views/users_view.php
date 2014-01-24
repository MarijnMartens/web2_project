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
        echo $key;
        echo '</th>';
        //print usernames for matching letter
        foreach($letter as $username){
            echo '<tr>';
            echo '<td>' . $username . '</td>';
            echo '</tr>';
        }
    }
}
echo '<br/>';


?>
</table>
