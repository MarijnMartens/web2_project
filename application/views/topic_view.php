<h1>Topics</h1>
<p><a href="<?php echo base_url('forum/insertTopic'); ?>">Insert new topic</a></p>
<table border='1'>
    <?php echo "$count Topics"; ?>
    <?PHP
    foreach ($topics as $topic) {
        echo $topic;
    }
    ?>
</table>
<p><a href="<?php echo base_url('forum/insertTopic'); ?>">Insert new topic</a></p>