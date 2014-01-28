<?php

/* 23
 * Author: Marijn
 * Created on: 11/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


//iterate rows in table

$fields = $result->list_fields();


foreach ($fields as $row) {
    echo $row . '<br/>';
}
?>