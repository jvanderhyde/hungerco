<html>
<head> 
<title></title> 
</head> 
<body> 
    
<?php
    session_start();
    if(!session_is_registered("Officer"))
    {
        header("location:stflogin.php");
    }
?>

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
    
</body>
</html>
