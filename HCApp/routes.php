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

    <form name="home" action="officerhome.php" method="POST">
        <input type="submit" value="Back to Home Page">
    </form>

</body>
</html>