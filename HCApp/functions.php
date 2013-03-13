<!DOCTYPE HTML>
<?php

include_once "dbfunctions.php";

function logout()
{
    session_start();
    session_destroy();
}

function verifyuser($expected)
{    
    session_start();
    if(!in_array($_SESSION['user'],$expected))
    {
        header("location:index.php");
    }
}

function regUser($user,$page)
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
