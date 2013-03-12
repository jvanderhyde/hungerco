<!DOCTYPE HTML>
<?php 

include_once "functions.php";

function connectToDB()
{
    $username="hungerco";
    $password="intensiveness";
    $database="hungerco";
    $link = mysql_connect('localhost',$username,$password);
    @mysql_select_db($database, $link) or die( "Unable to select database");
    return $link;
}

function getNumSkip()
{
    $link = connectToDB();
    $query=
        "SELECT COUNT(Id)
        FROM students
        WHERE isskipper = 1";
    $result=mysql_query($query, $link);
    return mysql_result($result,0,"count(id)");
}

function makeAccount($formInfo)
{
    $link = connectToDB();
    $query=
        "INSERT 
        INTO students 
        VALUES ({$formInfo['fName']}, {$formInfo['minit']},{$formInfo['Name']},
        {$formInfo['id']},{$formInfo['pass1']},0,
        {$formInfo['phone']},{$formInfo['email']})";
        
    if(!mysql_query($query, $link))
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
    
    $result=mysql_query($query, $link);
    $num=mysql_num_rows($result);
    
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
    $result=mysql_query($query, $link);
    $num=mysql_num_rows($result);

    if($num==1){
        return true;
    }
    else{
        return false;
    }
}

function protectInjection($input)
{
    $link = connectToDB();
    $stripinput=stripslashes($input);
    $cleaninput=mysql_real_escape_string($stripinput, $link);
    return $cleaninput;
}


?>

