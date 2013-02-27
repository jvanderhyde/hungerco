<?php
    session_start();
    if(!session_is_registered("IT")){
    header("location:stflogin.php");
    }

    // filename for download
    $filename = "skipper_list_" . date('Ymd') . ".xls";

    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Type: application/vnd.ms-excel");
    echo implode("\t", array( 1=>"First Name",
                            2=>"Middle Initial",
                            3=>"Last Name",
                            4=>"Student Id",)) . "\r\n";

    $username="hungerco";
    $password="intensiveness";
    $database="hungerco";
    mysql_connect('localhost',$username,$password);
    @mysql_select_db($database) or die( "Unable to select database");
    $query="SELECT fname,minit,lname,id
    FROM students
    WHERE isskipper=1";
    $result=mysql_query($query);
    $n=mysql_num_rows($result);

    for($i=0;$i<$n;$i++)
    {
        $row = mysql_fetch_assoc($result);
        array_walk($row, 'cleanData');
        echo implode("\t", $row) . "\r\n";
    }    
    
    function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }
?>