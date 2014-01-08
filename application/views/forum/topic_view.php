<h1>Topics</h1>
<p><a href="<?php echo base_url('forum/insertTopic'); ?>">Maak een nieuw topic aan</a></p>
<table border='1'>
    <?php echo "$count Topics"; ?>
    <?php
    foreach ($topics as $topic) {
        echo $topic;
    }
    ?>
</table>
<p><a href="<?php echo base_url('forum/insertTopic'); ?>">Maak een nieuw topic aan</a></p>