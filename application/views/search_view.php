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

        echo '<table border="2" width="100%">';

        //get fieldnames table
        $fields = $table->list_fields();
        echo '<tr>';
        //iterate fieldnames as tableheader
        for ($k = 0; $k < count($fields); $k++) {
            //echo "<th>$field</th>";
            switch($fields[$k]){
                case 'id':
                    break;
                default:
                    echo "<th>$fields[$k]</th>";
            }
        }
        echo '</tr>';
        //get data table
        $values = $table->result();
        //iterate rows in table
        foreach ($values as $row) {
            //iterate columns in table
            echo '<tr>';
            for ($j = 0; $j < count($fields); $j++) {
                //For specified action at certan fields search 
                //for match in switch else normal print
                switch($fields[$j]){
                    case 'avatar':
                        echo '<td><img class="avatar" src="' . base_url() . 'assets/images/avatars/' . $row->$fields[$j] . '" alt="Avatar" width="150"/></td>';
                        break;
                    case 'id':
                        $id = $row->$fields[$j];
                        break;
                    case 'username':
                        echo '<td><a href="' . base_url() . 'profile/index/' . $id . '">' . $row->$fields[$j] . '</a></td>';
                    default:
                        echo '<td>' . $row->$fields[$j] . '</td>';
                }
            }
            echo '</tr>';
        }
        echo '</table></br>';
    }
}
?>
