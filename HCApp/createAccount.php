<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Create an Account</title>
    </head>
    <body>
        <h1>Create an Account</h1>
        <form name="createaccount" action="submitcreation.php" method="POST">
            <h4>Name</h4>
            <input type="text" size="40" name="name">
            <h4>Student ID</h4>
            <input type="text" size="40" name="id">
            <h4>Phone</h4>
            <input type="text" size="40" name="phone">
            <h4>Password</h4>
            <input type="password" size="40" name="password1">
            <h4>Re-enter Password</h4>
            <input type="password" size="40" name="password2">
            <br/><br/>
            <input type="submit" value="Create">
        </form>
        <form name="cancel" action="stlogin.php" method="POST">
            <input type="submit" value="Cancel">
        </form>
        
        
    </body>
</html>
