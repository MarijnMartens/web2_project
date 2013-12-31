<?php
session_start(); // i start most if not all pages with this depending on what Im using it for.
    $host = 'eu-cdbr-azure-west-b.cloudapp.net'; // host name OR IP
    $username = 'b638e6ea6511d6' ;//username
    $pass = 'ebd8654c' ; //password
    $dbname    = 'cdb_f8188f18d4'; // Database Name
    $conn = mysql_connect($host, $username, $pass) or die(mysql_error());
    if ($conn)
    {
        mysql_select_db($dbname) or die(mysql_error());
    }
    else
    {
       echo 'Connection failed.';
    } // The above code connects to your database or errors if it cannot connect. Again this is simple, security is your own priority.

//here you could add checks for any empty fields using (!($_POST['first_name']))
$first_name = $_POST['first_name']; // this line will collect our information from the field in our form that has the facebook first_name in it.
$last_name = $_POST['last_name']; // same as above
$email = $_POST ['email']; //same as above
$query = mysql_query("INSERT INTO user (username, lName, email, password) VALUES ('$first_name','$last_name','$email', 'zomaarwat')") or die(mysql_error());
// The query will insert our fields in to the database as the above line shows, make sure your database table headers are exactly correct otherwise this will not work

// You can now either send an email or if you wanted header to a new page. This is up to you. Tutorials on google will show you how to do this part
if($query){
header('location: home.html');
}else {
echo 'error adding to database';	
}
?>