<p>FORUM</p>
<table border='1'>
    <?php foreach ($topics as $topic) { ?>
        <tr>
            <td><a href='<?php echo base_url(); ?>forum/posts/<?php echo $topic->id; ?>'><?php echo $topic->naam; ?></a></td>
            <td><?php echo $topic->datum; ?></td>
            <td><?php echo $topic->username; ?></td>
        </tr>
    <?php } ?>
</table>