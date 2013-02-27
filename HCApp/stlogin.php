<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?php 
session_start();
session_destroy();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Student login</title>
    </head>
    <body>
        <?php
        $enteredId=isset($_POST['enteredId'])?$_POST['enteredId']:"";
        ?>
        <h1>Student login</h1>
        <h1>*Do not use real Password!</h1>
        <form name="stlogin" action="verify_student_login.php" method="POST">
            <font size="4"><b>Student ID</b></font><br />
            <input type="text" size="40" name="studentID"value=<?php echo $enteredId;?>><br />
            <font size="4"><b>Password</b></font><br />
            <input type="password" size="40" name="studentPass"><br/>
            <input type="submit" value="Login">
        </form>
        <form name="createAccount" action="createaccount.php" method="POST">
            <input type="submit" value="Create an Account">
        </form>
        <form name="cancel" action="index.php" method="POST">
            <input type="submit" value="Cancel">
        </form>
        
        
    </body>
</html>
