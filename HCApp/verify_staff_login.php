<?php

$host="localhost"; // Host name
$dbusername="hungerco"; // Mysql username
$dbpassword="intensiveness"; // Mysql password
$db_name="hungerco"; // Database name
$tbl_name="staff"; // Table name

// Connect to server and select databse.
mysql_connect("$host", "$dbusername", "$dbpassword")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

// username and password sent from form
$username=$_POST['staffName'];
$password=$_POST['staffPass'];

// To protect MySQL injection
$stripusername = stripslashes($username);
$strippassword = stripslashes($password);
$cleanusername = mysql_real_escape_string($stripusername);
$cleanpassword = mysql_real_escape_string($strippassword);
$sql="SELECT * FROM $tbl_name WHERE Staffname='$cleanusername' and Staffpass='$cleanpassword'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $username and $password, table row must be 1 row
if($count==1){

// Register $username, $password and redirect to file "login_success.php"
session_start();
$_SESSION['user']=$cleanusername;
$mysql_result = mysql_result($result,0,"type");
switch($mysql_result)
{
    case "Cafe":
        header("location:cafeinfo.php");
        break;
    case "It":
        header("location:itinfo.php");
        break;
    case "Officer":
        header("location:officerhome.php");
        break;
    default:
        header("location:stflogin.php");
}
}
else {
echo "Wrong Username or Password";
}

?>
