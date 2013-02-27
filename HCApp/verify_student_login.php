<?php

$host="localhost:3306"; // Host name
$dbusername="hungerco"; // Mysql username
$dbpassword="intensiveness"; // Mysql password
$db_name="HUNGERCO"; // Database name
$tbl_name="students"; // Table name

// Connect to server and select databse.
mysql_connect("$host", "$dbusername", "$dbpassword")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

// username and password sent from form
$userid=$_POST['studentID'];
$password=$_POST['studentPass'];

// To protect MySQL injection
$stripuserid = stripslashes($userid);
$strippassword = stripslashes($password);
$cleanuserid = mysql_real_escape_string($stripuserid);
$cleanpassword = mysql_real_escape_string($strippassword);
$sql="SELECT * FROM $tbl_name WHERE Id='$cleanuserid' and StudPass='$cleanpassword'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $username and $password, table row must be 1 row
if($count==1){
    // Register $username, $password and redirect to file "login_success.php"
    session_register("studentid");
    session_register("studentpassword");
    $_SESSION["studentid"]=$cleanuserid;
    $_SESSION["studentpassword"]=$cleanpassword;
    header("location:stinfo.php");
}
else {
echo "<h1>Wrong Username or Password</h1>
      <form name=\"wrong\" action=\"stlogin.php\" method=\"POST\">
            <input type=\"hidden\" value=$userid name=\"enteredId\">
            <input type=\"submit\" value=\"Back\">
      </form>";
}

?>
