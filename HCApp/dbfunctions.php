<!DOCTYPE HTML>
<?php 

include "functions.php";

function connectToDB()
{
    $username="hungerco";
    $password="intensiveness";
    $database="hungerco";
    $link = mysqli_connect('localhost',$username,$password);
    @mysqli_select_db($link, $database) or die( "Unable to select database");
    return $link;
}

function getNumSkip()
{
    $link = connectToDB();
    $query=
        "SELECT COUNT(Id)
        FROM students
        WHERE isskipper = 1";
    $result=mysqli_query($link, $query);
    return mysqli_result($result,0,"count(id)");
}

function makeAccount($formInfo)
{
    $query=
        "INSERT 
        INTO students 
        VALUES ({$formInfo['fName']}, {$formInfo['minit']},{$formInfo['Name']},
        {$formInfo['id']},{$formInfo['pass1']},0,
        {$formInfo['phone']},{$formInfo['email']})";
        
    if(!mysqli_query($query))
    {
        $isMade['message'] = "Could not create account!";
        $isMade['flag'] = false;
        return $isMade;
    }
    else
    {
        $isMade['flag'] = true;
        return $isMade;
    }
}

function existsInDatabase1($table,$attr,$value)
{
    $link = connectToDB();
    $query=
        "SELECT * 
        FROM $table 
        WHERE $attr=$value";
    $result=mysqli_query($link, $query);
    $num=mysqli_numrows($result);

    if($num==1){
        return true;
    }
    else{
        return false;
    }
}

function existsInDatabase2($table,$attr1,$value1,$attr2,$value2)
{
    $link = connectToDB();
    $query=
        "SELECT * 
        FROM $table 
        WHERE $attr1=$value1 
          AND $attr2=$value2";
    $result=mysqli_query($link, $query);
    $num=mysqli_numrows($result);

    if($num==1){
        return true;
    }
    else{
        return false;
    }
}

function protectInjection($input)
{
    $stripinput=stripslashes($input);
    $cleaninput=mysqli_real_escape_string($stripinput);
    return $cleaninput;
}


?>

