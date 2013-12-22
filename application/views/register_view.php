        <?php echo form_open('register'); ?>
        <p>
        <label>Username</label>
        <input type="text" name="username" placeholder="Username" value="<?php echo set_value('username'); ?>" size="20" />
        <?php echo form_error('username'); ?>
        </p>
        
        <p>
        <label>Password</label>
        <input type="password" name="password" placeholder="Password" value="<?php echo set_value('password'); ?>" size="20" />
        <?php echo form_error('password'); ?>
        </p>
        
        <p>
        <label>Confirm Password</label>
        <input type="password" name="passconf" placeholder="Password" value="<?php echo set_value('passconf'); ?>" size="20" />
        <?php echo form_error('passconf'); ?>
        </p>
        
        <p>
        <label>Email Address</label>
        <input type="text" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>" size="30" />
        <?php echo form_error('email'); ?>
        </p>
        
        <input type="submit" value="Submit" />
        <?php echo form_close(); ?>