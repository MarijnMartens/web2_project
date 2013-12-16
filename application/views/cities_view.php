<table>
    <?php echo heading($heading, 1); ?>
    <p><a href="<?php echo base_url('welcome/index'); ?>">Naar index</a></p>
    <?php
    foreach ($gemeenten as $gemeente)
    {
        echo "<tr><td>$gemeente->Name</td></tr>";
    }
    ?>
</table>