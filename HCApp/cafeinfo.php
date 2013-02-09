<?php
    session_start();
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
