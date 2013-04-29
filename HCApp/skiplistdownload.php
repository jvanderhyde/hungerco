<!DOCTYPE HTML>
<?php 
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    include_once 'Excel.php';
    verifyuser(array("Officer","It"));

    // filename for download
    $filename = "skipper_list_" . date('Ymd');
    $xls = new Excel($filename);
    $xls->home();
    $xls->label("test");
    $xls->right();
    $xls->label("test2");
    $xls->down();
    
    ob_start();
    $xls->send();
    $data = ob_get_clean();
    file_put_contents("\\\\bccs.ravens.bc\\hungerco\\amanda\\itinfo.php\\$filename.xls", $data);

//    header("Content-Disposition: attachment; filename=\"$filename\"");
//    header("Content-Type: application/vnd.ms-excel");
//    header("Content-Transfer-Encoding: binary"); 
//    echo "test \t";
//    echo implode("\t", array( "First Name", "Middle Initial", "Last Name", "Student Id",)) . "\r\n";
//
//    $result =  getSkippers();
//    $n=mysql_num_rows($result);
//
//    for($i=0;$i<$n;$i++)
//    {
//        $row = mysql_fetch_assoc($result);
//        array_walk($row, 'cleanData');
//        echo implode("\t", $row) . "\r\n";
//    }    
    
    function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }
?>