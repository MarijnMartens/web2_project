<?php

/*
 * Author: Marijn
 * Created on: 11/01/2014
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

?>

<html>
<head>
<title>Upload Form</title>
</head>
<body>

<?php echo $error; ?>

<?php echo form_open_multipart('test/process');?>
    <input type="text" name="fName" size="20" />
<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>