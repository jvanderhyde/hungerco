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

function changeSkipperValue($id,$value)
{
    $link = connectToDB();
    $query=
        "UPDATE students
        SET IsSkipper = $value
        WHERE id = $id";
    mysql_query($query, $link);
}

function getStudentInfo($id)
{
    $link = connectToDB();
    $query=
        "SELECT *
        FROM students
        WHERE id = $id";
    $result=mysql_query($query, $link);
    
    $info['fName'] = mysql_result($result,0,"Fname");
    $info['minit'] = mysql_result($result,0,"Minit");
    $info['lName'] = mysql_result($result,0,"Lname");
    $info['phone'] = mysql_result($result,0,"Studphone");
    $info['id']    = mysql_result($result,0,"Id");
    $info['email'] = mysql_result($result,0,"StudEmail");
    $info['pass']  = mysql_result($result,0,"Studpass");
    $info['isSkipper'] = mysql_result($result,0,"IsSkipper");

    return $info;
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

function getPersonalVolOpps($id)
{
    $link = connectToDB();
    $ymd=date('Ymd');
    $query="SELECT * FROM vol_opps WHERE Oppnum IN(
            SELECT Voppnum FROM volunteers WHERE Volid='$id')
            AND DATE_FORMAT(Date,'%Y%m%d')>=$ymd
            ORDER BY Date";
    $result=mysql_query($query, $link);
    $n=mysql_num_rows($result);
    if($n==0)
    {
        return false;
    }
    else
    {
        for($i=0;$i<$n;$i++)
        { 
            $volOpps[$i] = mysql_fetch_assoc($result);
        }    

        return $volOpps;
    }
}

function getUnregisteredVolOpps($id)
{
    $link = connectToDB();
    $ymd=date('Ymd');
    $query="SELECT * FROM vol_opps WHERE Oppnum NOT IN(
            SELECT Voppnum FROM volunteers WHERE Volid='$id')
            AND DATE_FORMAT(Date,'%Y%m%d')>=$ymd
            ORDER BY Date";
    $result=mysql_query($query, $link);
    $n=mysql_num_rows($result);
    if($n==0)
    {
        return false;
    }
    else
    {
        for($i=0;$i<$n;$i++)
        { 
            $volOpps[$i] = mysql_fetch_assoc($result);
        }    

        return $volOpps;
    }
}

function removeVolunteerValue($id,$oppnum)
{
    $link = connectToDB();
    $query="DELETE FROM volunteers WHERE Volid='$id' AND Voppnum=$oppnum";
    mysql_query($query, $link);
}

function addVolunteerValue($id,$oppnum)
{
    $link = connectToDB();
    $query="INSERT INTO volunteers VALUES ('$id', $oppnum)";
    mysql_query($query, $link);
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

function modifyAccount($formInfo,$origID)
{
    $link = connectToDB();
    $middle = empty($formInfo['minit'])?'null':"'{$formInfo['minit']}'";
    $phone = empty($formInfo['phone'])?'null':"'{$formInfo['phone']}'";
    $email = empty($formInfo['email'])?'null':"'{$formInfo['email']}'";
    
    
    $query=
        "UPDATE students
        SET Fname='{$formInfo['fName']}', Minit=$middle, Lname='{$formInfo['lName']}',
            Studphone=$phone, StudEmail=$email, Studpass='{$formInfo['pass']}'
        WHERE Id='{$origID}'";
       
    $result = mysql_query($query,$link) or die('Query failed: ' . mysql_error());
    if(!$result)
    {
        $isMade['message'] = "Could not modify account!";
        $isMade['flag'] = false;
        return $isMade;
    }
    else
    {
        $isMade['flag'] = true;
        return $isMade;
    }
}

function makeFamily($formInfo)
{
    $link = connectToDB();
    $numLunch = empty($formInfo['numLunch'])?'null':$formInfo['numLunch'];
    $famPhone = empty($formInfo['famPhone'])?'null':"'{$formInfo['famPhone']}'";
    $notes = empty($formInfo['notes'])?'null':"'{$formInfo['notes']}'";
    $query=
        "INSERT 
        INTO families 
        VALUES ('{$formInfo['famName']}', $numLunch,'{$formInfo['address']}',
        '{$formInfo['city']}',$famPhone,$notes)";
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

function getFamilies()
{
    $link = connectToDB();
    $query=
        "SELECT *
        FROM families";
    $result=mysql_query($query, $link);
    $n=mysql_num_rows($result);

    for($i=0;$i<$n;$i++)
    {
        $families[$i] = mysql_fetch_assoc($result);
    }    
    
    return $families;
}

function getFamilyInfo($address,$city)
{
    $link = connectToDB();
    $query=
        "SELECT *
        FROM families
        WHERE Address='$address' AND City='$city'";
    $result = mysql_query($query, $link);
    return mysql_fetch_assoc($result);
}

function modifyFamily($formInfo,$origInfo)
{
    $link = connectToDB();
    $numLunch = empty($formInfo['numLunch'])?'null':$formInfo['numLunch'];
    $famPhone = empty($formInfo['famPhone'])?'null':"'{$formInfo['famPhone']}'";
    $notes = empty($formInfo['notes'])?'null':"'{$formInfo['notes']}'";
    $query=
        "UPDATE families 
        SET Famname='{$formInfo['famName']}', NumLunch=$numLunch, Address='{$formInfo['address']}',
            City='{$formInfo['city']}', Famphone=$famPhone, Notes=$notes
        WHERE Address='{$origInfo['Address']}' AND City='{$origInfo['City']}'";
        
    $result = mysql_query($query,$link) or die('Query failed: ' . mysql_error());
    if(!$result)
    {
        $isMade['message'] = "Could not modify account!";
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

function getVolunteerOppotunityInformation($oppnum){
    $sql="SELECT * FROM vol_opps WHERE Oppnum=$oppnum";
    return mysql_query($sql);
}

?>

