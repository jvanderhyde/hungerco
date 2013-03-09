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

function assignPostData($var)
{
    return isset($_POST[$var])?$_POST[$var]:"";
}

function chkCrtAcctVldty($formInfo)
{
    if(!$formInfo['fName']||!$formInfo['lName']||!$formInfo['id']
            ||!$formInfo['pass1']||!$formInfo['pass2'])
    {
        $isvalid['message'] = "Please fill all blank spaces required";
        $isvalid['flag'] = false;
        return $isvalid;
    }
    elseif(existsInDatabase("students","Id",$formInfo['id']))
    {
        $this->message = "This student ID has already been registered.";
        $isvalid['flag'] = false;
        return $isvalid;
    }
    elseif(strcmp($formInfo['pass1'],$formInfo['pass2']!=0))
    {
        $isvalid['message'] = "Your passwords do not equal.";
        $isvalid['flag'] = false;
        return $isvalid;
    }
    else
    {
        $isvalid['flag'] = true;
        return $isvalid;
    }
}

?>
