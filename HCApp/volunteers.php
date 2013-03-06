<html>
<head> 
<title></title> 
</head> 
<body> 
    
<?php
    session_start();
    if(!session_is_registered("Officer")){
    header("location:stflogin.php");
    }
    echo "volunteers"
?>

    <form name="home" action="officerhome.php" method="POST">
        <input type="submit" value="Back to Home Page">
    </form>

</body>
</html>