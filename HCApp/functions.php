<!DOCTYPE HTML>
<?php

include "dbfunctions.php";

function verifyuser($expected)
{    
    session_start();
    if($_SESSION['user']!=$expected)
    {
        header("location:index.php");
    }
}

function regSess($user,$page)
{               
    session_start();
    $_SESSION['user']=$user;
    header("location:$page");       
}

function chkErr($vldArry)
{
    if(!$vldArry['flag'])
    {
        echo $vldArry['message'];
        return false;
    }
    else
        return true;
}

function assignPostData($var)
{
    return isset($_POST[$var])?$_POST[$var]:"";
}



?>
