<?php 

function connectToDB()
{
    $username="hungerco";
    $password="intensiveness";
    $database="hungerco";
    $host="ec2-72-44-43-163.compute-1.amazonaws.com";                           
    $link = mysql_connect($host,$username,$password);
    @mysql_select_db($database, $link) or die( "Unable to select database");
    return $link;
}

?>
