<?php

/*
 * Author: Marijn
 * Created on: 11/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

?>

s


<table border="1">
<?php
foreach ($result as $row){
    echo '<tr>';
    echo '<td>' . $row->username . '</td>';
    echo '</tr>';
}
?>
</table>
