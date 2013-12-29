<p>FORUM</p>
<table border='1'>
    <?php foreach ($fora as $forum) { ?>
        <tr>
            <td><a href='<?php echo base_url(); ?>forum/topics/<?php echo $forum->id; ?>'><?php echo $forum->naam; ?></a></td>
            <td><?php echo $forum->omschrijving; ?></td>
        </tr>
    <?php } ?>
</table>