<!DOCTYPE HTML>
<?php 

include_once "functions.php";

require('dbconnect_localhost.php');

//Student

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
    return mysql_result($result,0,"isskipper")==chr(1);
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

function deleteStaccount($id)
{
    $link = connectToDB();
    $query="DELETE FROM students WHERE Id='$id'";
    mysql_query($query, $link);
}





//Volunteer Opportunities

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

function getMonthlyVolOpps($year, $month)
{
    $link = connectToDB();
    $ym=sprintf("%04d%02d", $year, $month);
    $query="SELECT * FROM vol_opps WHERE DATE_FORMAT(Date,'%Y%m')=$ym";
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

function getMonthlyRegisteredVolOpps($id, $year, $month)
{
    $link = connectToDB();
    $ym=sprintf("%04d%02d", $year, $month);
    $query="SELECT * FROM vol_opps WHERE Oppnum IN(
            SELECT Voppnum FROM volunteers WHERE Volid='$id')
            AND DATE_FORMAT(Date,'%Y%m')=$ym
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

function getPersonalVolOpps($id, $onlyfuture)
{
    $link = connectToDB();
    $ymd=date('Ymd');
    if($onlyfuture)
    {
        $query="SELECT * FROM vol_opps WHERE Oppnum IN(
                SELECT Voppnum FROM volunteers WHERE Volid='$id')
                AND DATE_FORMAT(Date,'%Y%m%d')>=$ymd
                ORDER BY Date";
    }
    else
    {
        $query="SELECT * FROM vol_opps WHERE Oppnum IN(
                SELECT Voppnum FROM volunteers WHERE Volid='$id')
                ORDER BY Date";
    }
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

function getUnregisteredVolOpps($id,$onlyfuture)
{
    $link = connectToDB();
    $ymd=date('Ymd');
    if($onlyfuture)
    {
        $query="SELECT * FROM vol_opps WHERE Oppnum NOT IN(
                SELECT Voppnum FROM volunteers WHERE Volid='$id')
                AND DATE_FORMAT(Date,'%Y%m%d')>=$ymd
                ORDER BY Date";
    }
    else
    {
        $query="SELECT * FROM vol_opps WHERE Oppnum NOT IN(
                SELECT Voppnum FROM volunteers WHERE Volid='$id')
                ORDER BY Date";
    }
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

function selectFutureVolOpps($volopps)
{
    $volopparray=array();
    $today=date("Y-m-s");
    foreach ($volopps as $volopp)
    {
        if($volopp['Date']>=$today)
            array_push($volopparray,$volopp);
    }
    return $volopparray;
}

function getVolunteerOppotunityInformation($oppnum)
{
    $link = connectToDB();
    $query="SELECT * FROM vol_opps WHERE Oppnum=$oppnum";
    $result = mysql_query($query, $link);
    return mysql_fetch_assoc($result);
}

function modifyVolunteerOpportunity($formInfo,$oppnum)
{
    $link = connectToDB();
    $name = empty($formInfo['oppname'])?'null':"'{$formInfo['oppname']}'";
    $description = empty($formInfo['description'])?'null':"'{$formInfo['description']}'";
    $query=
        "UPDATE vol_opps 
        SET Oppname=$name, Description=$description
        WHERE Oppnum=$oppnum";
        
    mysql_query($query,$link) or die('Query failed: ' . mysql_error());
}

function makeVolunteerOpportunity($formInfo,$date)
{
    $link = connectToDB();
    $name = empty($formInfo['oppname'])?'null':"'{$formInfo['oppname']}'";
    $description = empty($formInfo['description'])?'null':"'{$formInfo['description']}'";
    $query=
        "INSERT 
        INTO vol_opps(DATE,Oppname,Description)
        VALUES ('$date',$name,$description)";
    mysql_query($query,$link) or die('Query failed: ' . mysql_error());
}

function deleteVolunteerOpportunity($oppnum)
{
    $link = connectToDB();
    $query="DELETE FROM vol_opps WHERE Oppnum=$oppnum";
    mysql_query($query, $link);
}





//Volunteers

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





//Family

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

function getFamilies($route)
{
    $link = connectToDB();
    $query='';
    if($route=='Unsigned')
    {
        $query="SELECT *
            FROM families AS F
            WHERE NOT EXISTS 
                ( SELECT *
                FROM routes AS R
                WHERE F.Address=R.Famaddress AND F.City=R.Famcity)
            ORDER BY F.Famname,F.City,F.Address";
    }
    else
    {
        $query="SELECT *
            FROM families
            WHERE (Address,City) IN
                ( SELECT Famaddress,Famcity
                FROM routes
                WHERE ROUTE='$route')
            ORDER BY Famname,City,Address";
    }
    
    $result=mysql_query($query, $link);
    $n=mysql_num_rows($result);
    if($n==0)
        return false;

    for($i=0;$i<$n;$i++)
    {
        $families[$i] = mysql_fetch_assoc($result);
    }    
    
    return $families;
}

function getFamiliesWithStop($route, $order)
{
    $link = connectToDB();
    $query="SELECT *
            FROM families 
            INNER JOIN routes ON Address=Famaddress AND City=Famcity
            WHERE  ROUTE='$route'";
    $textOrder="ORDER BY $order";
    
    
    $result=mysql_query($query.' '.$textOrder,$link) or die('Query failed: ' . mysql_error());
    $n=mysql_num_rows($result);
    if($n==0)
        return false;

    for($i=0;$i<$n;$i++)
    {
        $families[$i] = mysql_fetch_assoc($result);
    }    
    
    return $families;
}

function getFamilyInfo($addresscity)
{
    $link = connectToDB();
    $query=
        "SELECT *
        FROM families
        WHERE CONCAT_WS(',',Address,City)='$addresscity'";
    $result = mysql_query($query, $link);
    return mysql_fetch_assoc($result);
}

function getFamilyInfoFromStop($route,$stop)
{
    $link = connectToDB();
    $query="SELECT *
            FROM families 
            INNER JOIN routes ON Address=Famaddress AND City=Famcity
            WHERE  ROUTE='$route' AND STOP=$stop";
    $result=mysql_query($query,$link) or die('Query failed: ' . mysql_error());
    $n=mysql_num_rows($result);
    if($n!=1)
        return false;
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

function deleteFamily($addresscity)
{
    $link = connectToDB();
    $routestop=getRouteStop($addresscity);
    $query=
        "DELETE FROM families 
        WHERE CONCAT_WS(',',Address,City)='$addresscity'";
    mysql_query($query, $link);
    if($routestop)
        negativeUpdateStops($routestop['ROUTE'],$routestop['STOP']);
}








//Route

function createRoute($addresscity,$newroute)
{
    $link = connectToDB();
    $family=getFamilyInfo($addresscity);
    $query='';
    if(isEmptyRoute($newroute))
    {
        $query=
            "INSERT 
            INTO routes 
            VALUES ('{$family['Address']}','{$family['City']}','$newroute',1)";
    }
    else
    {
        $max=getMaxStop($newroute);
        $query=
            "INSERT 
            INTO routes 
            VALUES ('{$family['Address']}','{$family['City']}','$newroute',
                1 + $max)";
    }
    mysql_query($query, $link);
}

function deleteRoute($addresscity)
{
    $link = connectToDB();
    $routestop=getRouteStop($addresscity);
    $query=
        "DELETE FROM routes 
        WHERE CONCAT_WS(',',Famaddress,Famcity)='$addresscity'";
    mysql_query($query, $link);
    negativeUpdateStops($routestop['ROUTE'],$routestop['STOP']);
}

function changeRoute($addresscity,$oldroute,$newroute)
{
    $link = connectToDB();
    $routestop=getRouteStop($addresscity);
    $query='';
    if(isEmptyRoute($newroute))
    {
        $query=
            "UPDATE routes
            SET ROUTE='$newroute',
                STOP=1
            WHERE ROUTE='$oldroute' AND STOP={$routestop['STOP']}";
    }
    else
    {
        $max=getMaxStop($newroute);
        $query=
            "UPDATE routes
            SET ROUTE='$newroute',
                STOP=1+$max
            WHERE ROUTE='$oldroute' AND STOP={$routestop['STOP']}";
    }
    mysql_query($query, $link);
    negativeUpdateStops($routestop['ROUTE'],$routestop['STOP']);
}

function negativeUpdateStops($route,$numstop)
{
    $link = connectToDB();
    $query=
        "UPDATE routes
        SET STOP=STOP-1
        WHERE ROUTE='$route' AND STOP>$numstop";
    mysql_query($query, $link);
}

function getRouteStop($addresscity)
{
    $link = connectToDB();
    $query=
        "SELECT ROUTE,STOP
        FROM routes 
        WHERE CONCAT_WS(',',Famaddress,Famcity)='$addresscity'";
    $result=mysql_query($query, $link);
    $num=mysql_num_rows($result);
    if($num==0)
        return false;
    else
        return mysql_fetch_assoc($result);
}

function getMaxStop($route)
{
    $link = connectToDB();
    $queryt="SELECT MAX(STOP) FROM routes WHERE ROUTE='$route'";
    $result=mysql_query($queryt, $link);
    return mysql_result($result,0,"MAX(STOP)");    
}

function isEmptyRoute($route)
{
    $link = connectToDB();
    $query=
        "SELECT *
        FROM routes
        WHERE ROUTE='$route'";
    $result=mysql_query($query, $link);
    $num=mysql_num_rows($result);
    if($num==0)
        return true;
    else
        return false;
}

function upList($route,$stop)
{
    if($stop==0)
        return;
    
    $link = connectToDB();
    $query1=
        "UPDATE routes
        SET STOP=0
        WHERE ROUTE='$route' AND STOP=$stop";
    mysql_query($query1, $link);
    
    $query2=
        "UPDATE routes
        SET STOP=$stop
        WHERE ROUTE='$route' AND STOP=$stop-1";
    mysql_query($query2, $link);
    
    $query3=
        "UPDATE routes
        SET STOP=$stop-1
        WHERE ROUTE='$route' AND STOP=0";
    mysql_query($query3, $link);
}

function downList($route,$stop)
{
    if($stop==getMaxStop($route))
        return;
    
    $link = connectToDB();
    $query1=
        "UPDATE routes
        SET STOP=0
        WHERE ROUTE='$route' AND STOP=$stop";
    mysql_query($query1, $link) or die('Query failed: ' . mysql_error());
    
    $query2=
        "UPDATE routes
        SET STOP=$stop
        WHERE ROUTE='$route' AND STOP=$stop+1";
    mysql_query($query2, $link) or die('Query failed: ' . mysql_error());
    
    $query3=
        "UPDATE routes
        SET STOP=$stop+1
        WHERE ROUTE='$route' AND STOP=0";
    mysql_query($query3, $link) or die('Query failed: ' . mysql_error());
}

function getRouteAddresses($route)
{
    $link = connectToDB();
    $query="SELECT *
            FROM families 
            INNER JOIN routes ON Address=Famaddress AND City=Famcity
            WHERE  ROUTE='$route'
            ORDER BY STOP";
    $result=mysql_query($query,$link) or die('Query failed: ' . mysql_error());
    $n=mysql_num_rows($result);
    if($n==0)
        return false;

    for($i=0;$i<$n;$i++)
    {
        $address=mysql_result($result,$i,"Address");
        $city=mysql_result($result,$i,"City");
        $addresscity=$address.', '.$city;
        $list[$i] = $addresscity;
    }    
    
    return $list;
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

