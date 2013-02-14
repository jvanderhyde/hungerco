<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?php
 session_start();
 if(!session_is_registered("studentid")){
 header("location:stlogin.php");
 }
 ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Student Information</title>
    </head>
    <body>
        <h1>Student Information</h1>
        <?php
        $id=$_SESSION["studentid"];
        //$password=$_SESSION["studentpassword"];
        $host="localhost:3306"; // Host name
        $dbusername="hungerco"; // Mysql username
        $dbpassword="intensiveness"; // Mysql password
        $db_name="HUNGERCO"; // Database name
        $tbl_name="students"; // Table name

        // Connect to server and select databse.
        mysql_connect("$host", "$dbusername", "$dbpassword")or die("cannot connect");
        mysql_select_db("$db_name")or die("cannot select DB");
        
        if(isset($_POST['updateSkipper'])){
            $updateskipper=$_POST['updateSkipper'];
            $sqlup="UPDATE $tbl_name SET IsSkipper=$updateskipper WHERE Id='$id'";
            mysql_query($sqlup);
        }
        
        $sql="SELECT * FROM $tbl_name WHERE Id='$id'";
        $result=mysql_query($sql);
        if(mysql_result($result,0,"IsSkipper")==1){
            echo "<form name=\"removeSkipper\" action=\"stinfo.php\" method=\"POST\">
                    <font size=\"4\">You are a skipper.</font>
                    <input type=\"hidden\" name=\"updateSkipper\" value=\"0\">
                    <input type=\"submit\" value=\"Remove skipper\">
                </form>";
        }
        else{
            echo "<form name=\"becomeSkipper\" action=\"stinfo.php\" method=\"POST\">
                    <font size=\"4\">You are not a skipper.</font>
                    <input type=\"hidden\" name=\"updateSkipper\" value=\"1\">
                    <input type=\"submit\" value=\"Become skipper\">
                </form>";
        }
        
        ?>
        
        
        
    </body>
</html>
