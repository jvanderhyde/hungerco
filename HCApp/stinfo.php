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
        $partskipper = new StudentInformation();
        $partskipper->updateOrNot();
        if($partskipper->isSkipper()){
            ?>
            <form name="removeSkipper" action="stinfo.php" method="POST">
                    <font size="4">You are a skipper.</font>
                    <input type="hidden" name="updateSkipper" value="0">
                    <input type="submit" value="Remove skipper">
            </form>
            <?php
        }
        else{
            ?>
            <form name="becomeSkipper" action="stinfo.php" method="POST">
                    <font size="4">You are not a skipper.</font>
                    <input type="hidden" name="updateSkipper" value="1">
                    <input type="submit" value="Become skipper">
            </form>
            <?php
        }
        ?>
        
        <form name="logout" action="stlogin.php" method="POST">
                <input type="submit" value="Logout">
        </form>
        
        <?php
        class StudentInformation{
            private $id,$host,$dbusername,$dbpassword,$db_name,$tbl_name;
            
            function __construct(){
                $this->id=$_SESSION["studentid"];
                $this->host="localhost:3306"; // Host name
                $this->dbusername="hungerco"; // Mysql username
                $this->dbpassword="intensiveness"; // Mysql password
                $this->db_name="HUNGERCO"; // Database name
                $this->tbl_name="students"; // Table name
            }
            
            function getConnectionWithDatabase(){
                mysql_connect("$this->host", "$this->dbusername", "$this->dbpassword")
                        or die("cannot connect");
                mysql_select_db("$this->db_name")or die("cannot select DB");
            }
            
            function updateSkipperValue(){
                $this->getConnectionWithDatabase();
                $updateskipper=$_POST['updateSkipper'];
                $sqlup="UPDATE $this->tbl_name SET IsSkipper=$updateskipper WHERE Id='$this->id'";
                mysql_query($sqlup);
                mysql_close();
            }
            
            function updateOrNot(){
                if(isset($_POST['updateSkipper'])){
                    $this->updateSkipperValue();
                }
            }
            
            function isSkipper(){
                $this->getConnectionWithDatabase();
                $sql="SELECT * FROM $this->tbl_name WHERE Id='$this->id'";
                $result=mysql_query($sql);
                if(mysql_result($result,0,"IsSkipper")==1){
                    mysql_close();
                    return true;
                }
                else{
                    mysql_close();
                    return false;
                }
            }
            
        }
        ?>
        
        
        
    </body>
</html>
