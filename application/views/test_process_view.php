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

<h3>Your file was successfully uploaded!</h3>

<ul>
<?php foreach ($upload_data as $item => $value):?>
<li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>


</ul>
<br/>

<?php 
    echo 'fName ' . $fName;
    echo '<br/>';
    echo 'userfile: ' . $userfile;
    echo '<br/>';
    echo '<img src="./assets/images/avatars/' . $userfile . '" alt="avatar"/>';

?>

<p><?php echo anchor('test', 'Upload Another File!'); ?></p>

</body>
</html>