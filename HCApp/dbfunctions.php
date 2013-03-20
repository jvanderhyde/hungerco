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

function getStudName($id)
{
    $link = connectToDB();
    $query=
        "SELECT fname, lname
        FROM students
        WHERE id = $id";
    $result=mysql_query($query, $link);
    return mysql_result($result,0,"fname")." ".mysql_result($result,0,"lname");
}

function isSkipper($id)
{
    $link = connectToDB();
    $query=
        "SELECT isSkipper
        FROM students
        WHERE id = $id";
    $result=mysql_query($query, $link);
    return mysql_result($result,0,"isskipper");
}

function getSkippers()
{
    $link = connectToDB();
    $query=
        "SELECT fname, lname, id
        FROM students
        WHERE isskipper = 1";
    $result=mysql_query($query, $link);
    $n=mysql_num_rows($result);

    for($i=0;$i<$n;$i++)
    {
        $students[$i] = mysql_fetch_assoc($result);
    }    
    
    return $students;
}

function getVolOpps()
{
    $link = connectToDB();
    $query=
        "SELECT date, oppname, oppnum
        FROM vol_opps
        WHERE date >= CURRENT_DATE
        ORDER BY date";
    $result=mysql_query($query, $link);
    $n=mysql_num_rows($result);

    for($i=0;$i<$n;$i++)
    { 
        $volOpps[$i] = mysql_fetch_assoc($result);
    }    
    
    return $volOpps;
}

function getVolunteers($oppnum)
{
    $link = connectToDB();
    $query=
        "SELECT fname, lname
        FROM students, volunteers
        WHERE voppnum='$oppnum' AND volid=id
        ORDER BY lname";
    $result=mysql_query($query, $link);
    $n=mysql_num_rows($result);

    for($i=0;$i<$n;$i++)
    { 
        $vols[$i] = mysql_fetch_assoc($result);
    }    
    if(isset($vols))
    {
        $areVols['flag']=1;
        $areVols['vols']=$vols;
    }
    else
        $areVols['flag']=0;
    return $areVols;
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
    $minit = empty($formInfo['minit'])?'null':"'{$formInfo['minit']}'";
    $phone = empty($formInfo['phone'])?'null':"'{$formInfo['phone']}'";
    $email = empty($formInfo['email'])?'null':"'{$formInfo['email']}'";
    $query=
        "INSERT 
        INTO students 
        VALUES ('{$formInfo['fName']}', $minit,'{$formInfo['lName']}',
        '{$formInfo['id']}','{$formInfo['pass1']}',0,$phone,$email)";
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

