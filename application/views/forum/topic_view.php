<!-- 
Author: Marijn
Created on: 04/01/2014
References: none
-->
<h1>Topics</h1>
<p><a href="<?php echo base_url('forum/insertTopic'); ?>">Nieuw topic</a></p>
<table border='1'>
    <?php echo "$count Topics"; ?>
    <?php
    foreach ($topics as $topic) {
        echo $topic;
    }
    ?>
</table>