<?php

/* 23
 * Author: Marijn
 * Created on: 11/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


//iterate rows in table

$fields = $result->list_fields();
$data = $result->result();
echo '<table border="2">';

echo '<tr>';

for ($i = 0; $i < count($fields); $i++){
//foreach ($fields as $fieldName) {
    echo '<th>' . $fields[$i] . '</th>';
}
echo '</tr>';


foreach ($data as $row) {
    echo '<tr>';
    for ($j = 0; $j < count($fields); $j++) {
        if ($fields[$j] == 'avatar') {
            echo '<td><img class="avatar" src="' . base_url() . 'assets/images/avatars/' . $row->$fields[$j] . '" alt="Avatar" width="150"/></td>';
        } else {
            echo '<td>' . $row->$fields[$j] . '</td>';
        }
    }
    echo '</tr>';
}


echo '</table>';
?>