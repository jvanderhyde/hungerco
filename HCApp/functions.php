<!DOCTYPE HTML>
<?php

function verifyuser($expected)
{    
    session_start();
    if($_SESSION['user']!=$expected)
    {
        header("location:stflogin.php");
        return "working";
    }
}

function assignPostData($var)
{
    $$var = isset($_POST[$var])?$_POST[$var]:"";
}

function getNumSkip()
{
    $username="hungerco";
    $password="intensiveness";
    $database="hungerco";
    mysql_connect('localhost',$username,$password);
    @mysql_select_db($database) or die( "Unable to select database");
    $query="SELECT COUNT(Id)
    FROM students
    WHERE isskipper = 1";
    $result=mysql_query($query);
    return mysql_result($result,0,"count(id)");
}

?>
