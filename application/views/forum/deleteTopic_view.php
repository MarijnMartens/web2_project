<?php

/*
 * Author: Marijn
 * Created on: 10/01/2014
 */

$this->load->helper('form');
echo form_open('forum/deleteTopicProcess'); ?>
<table>
    <p>Ben je ABSOLUUT zeker dat je '<b><?php echo $topic_title; ?></b>' wil verwijderen en niet enkel op slot wil doen?</p>
    <input type="submit" value="Ja, gooi het topic weg"/>
</table>
<?php echo form_close();