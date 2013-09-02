<?php 

function connectToDB()
{
    $username="root";//"hungerco";
    $password="intensiveness";
    $database="hungerco";
    $host="localhost";                           
    $link = mysql_connect($host,$username);
    @mysql_select_db($database, $link) or die( "Unable to select database");
    return $link;
}

?>
