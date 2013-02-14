<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?php
 session_start();
 if(!session_is_registered("studentid")){
 header("location:stlogin.php");
 }
 ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Student Information</title>
    </head>
    <body>
        <h1>Student Information</h1>
        <?php
        $id=$_SESSION["studentid"];
        $password=$_SESSION["studentpassword"];
        ?>
        <?php
        echo "<h4>ID</h4><b>$id</b><br /><h4>Password</h4><b>$password</b><br />";
        ?>
        
        
    </body>
</html>
