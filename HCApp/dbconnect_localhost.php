<?php 

function connectToDB()
{
    $username="hungerco";
    $password="intensiveness";
    $database="hungerco";
    $host="localhost";                           
    $link = mysql_connect($host,$username,$password);
    @mysql_select_db($database, $link) or die( "Unable to select database");
    return $link;
}

?>
