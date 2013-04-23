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

function num_to_str( $target ) {

    $alphabet = array(
        "A", "B", "C", "D", "E", "F", "G", "H", "I",
        "J", "K", "L", "M", "N", "O", "P", "Q", "R",
        "S", "T", "U", "V", "W", "X", "Y", "Z", 
    );

    if( ! is_numeric( $target ) || $target < 0 ) {
        return FALSE;
    }

    $one = fmod( $target , 26 );
    $result = $alphabet[ $one ];
    
    $carry = ( $target - $one ) / 26;

    while( $carry != 0 )
    {
        $one = fmod( $carry - 1 , 26 );
        $result = $alphabet[ $one ] . $result;
        $carry = ( $carry - 1 - $one ) / 26;
    }

    return $result;

}



?>
