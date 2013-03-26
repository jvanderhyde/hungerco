<!DOCTYPE HTML>
<html>
<head> 
<title></title> 
</head> 
<body> 
    
<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    verifyuser(array("Officer"));
?>

    <form name="stacounts" action="stacounts.php" method="POST">
        <input type="submit" value="Student Accounts">
    </form>
    <form name="skippers" action="skippers.php" method="POST">
        <input type="submit" value="View Skippers">
    </form>
    
    <form name="volunteer" action="volunteers.php" method="POST">
        <input type="submit" value="View Volunteers">
    </form>
    
    <form name="families" action="families.php" method="POST">
        <input type="submit" value="View Families">
    </form>
    
    <form name="routes" action="routes.php" method="POST">
        <input type="submit" value="View Routes">
    </form>
    
    <form name="logout" action="logout.php" method="POST">
            <input type="submit" value="Logout">
    </form>
    
</body>
</html>
