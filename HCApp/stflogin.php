<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Student login</title>
    </head>
    <body>
        <h1>Staff login</h1>
        <h1>*Do not use real Password!</h1>
        <form name="stlogin" action="stinfo.php" method="POST">
            <h4>Username</h4>
            <input type="text" size="40" name="studentID">
            <h4>Password</h4>
            <input type="password" size="40" name="studentPass"><br/><br/>
            <input type="submit" value="Login">
        </form>
        <br/>
        <form name="createAccount" action="createaccount.php" method="POST">
            <input type="submit" value="Create an Account">
        </form>


    </body>
</html>
