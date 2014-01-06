<!-- 
Author: Marijn
Created on: 20/12/2013
References: none
-->

<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>

<h1>Forums</h1>
<table border='1'>
    <?PHP
    //Print all forums where user_level >= forum_level
    foreach ($forums as $forum) {
        echo $forum;
    }
    ?>
</table>