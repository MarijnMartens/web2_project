<h1>Replies</h1>
<p><a href="<?php echo base_url('forum/insertReply'); ?>">Insert new reply</a></p>
<table border='1'>
    <?php echo "$count Replies"; ?>
    <?php foreach ($replies as $reply) {
        $edit = false;
        ?>
        <tr>
            <td><?php echo $reply->date; ?></td>
            <td><?php
                $edit = false;
                if ($reply->username != NULL) {
                    echo $reply->username;
                    if ($reply->user_id == $this->session->userdata('user_id')) {
                        $edit = true;
                    } else if ($this->session->userdata('level') >= 3) {
                        $edit = true;
                    }
                } else {
                    echo 'Gast' . $reply->guest_id;
                    if ($reply->guest_id == $this->input->cookie('guest_id')) {
                        $edit = true;
                    }
                }
                ?></td>
            <td><?php echo nl2br($reply->message); ?></td>
            <?php if ($edit == true && $reply->mod_break == false) { ?>
                <td><a href="<?php echo base_url("forum/editReply/$reply->id"); ?>">Edit reply</a></td>
            <?php } ?> 
        </tr>
    <?php } ?>
</table>
<p><a href="<?php echo base_url('forum/insertReply'); ?>">Insert new reply</a></p>