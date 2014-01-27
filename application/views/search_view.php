<?php

/*
 * Author: Marijn
 * Created on: 11/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//iterate each database table in getAll
for ($i = 0; $i < count($result); $i++) {
    $table = $result[$i];
//foreach ($result as $table) { OUT OF USE
    //check database table has result
    if ($table) {
        //display table name where keyword found
        echo '<h1 class="searchHeader">';
        switch ($i) {
            case 0:
                echo 'Gebruikers:';
                break;
            case 1:
                echo 'Fora:';
                break;
            case 2:
                echo 'Topic titels:';
                break;
            case 3:
                echo 'Antwoorden in topics:';
                break;
                echo '</h3></td></tr>';
        }
        echo '</h1>';

        //iterate rows in table
        foreach ($table as $row) {
            echo '<table border="2" width="100%">';
            //iterate columns in table
            foreach ($row as $column) {
                echo "<tr><td>$column</td></tr>";
            }
            echo '</table></br>';
        }
    }
}
?>
