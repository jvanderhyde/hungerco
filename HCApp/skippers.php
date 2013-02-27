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
    $username="hungerco";
    $password="intensiveness";
    $database="hungerco";
    mysql_connect('localhost',$username,$password);
    @mysql_select_db($database) or die( "Unable to select database");
    $query="SELECT COUNT(Id)
    FROM students
    WHERE isskipper = 1";
    $result=mysql_query($query);
    $numskip=mysql_result($result,0,"count(id)");
    print("Current number of skippers is: $numskip");
?>

    <form name="download" action="skiplistdownload.php" method="POST">
        <input type="submit" value="Download Skipper List">
    </form>
    
    <form name="logout" action="logout.php" method="POST">
        <input type="submit" value="Logout">
    </form>
    
</body>
</html>
