<!DOCTYPE HTML>
<?php
    include 'functions.php';
    include 'dbfunctions.php';
    verifyuser("Student");
 ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Student Information</title>
    </head>
    <body>
        <h1>Student Information</h1>
        <?php
        $stinfo = new StudentInformation();
        $stinfo->startUp();
        
        if($stinfo->isSkipper()){
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
        $stinfo->showVolunteerInformation();
        ?>
        <form name="volopp" action="volopp.php" method="POST">
            <input type="hidden" name="year" value=<?php echo date("Y");?>>
            <input type="hidden" name="month" value=<?php echo date("m");?>>
            <input type="submit" value="Volunteer Opportunities">
        </form>
        <form name="logout" action="stlogin.php" method="POST">
            <input type="submit" value="Logout">
        </form>
        
        <?php
        class StudentInformation{
            private $fname,$lname,$skipper,$id,$resultVol,
                    $host,$dbusername,$dbpassword,$db_name,$tbl_name;
            
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
            
            function startUp(){
                $this->getConnectionWithDatabase();
                $this->updateOrNot();
                $this->getInformation();
                mysql_close();
                $this->showSkipperInformation();
            }
            
            function getInformation(){
                $sql="SELECT * FROM $this->tbl_name WHERE Id='$this->id'";
                $result=mysql_query($sql);
                $this->fname=mysql_result($result,0,"Fname");
                $this->lname=mysql_result($result,0,"Lname");
                $this->skipper=mysql_result($result,0,"IsSkipper");
                $ymd=date('Ymd');
                $sql2="SELECT * FROM vol_opps WHERE Oppnum IN(
                        SELECT Voppnum FROM volunteers WHERE Volid='$this->id')
                        AND DATE_FORMAT(Date,'%Y%m%d')>=$ymd
                        ORDER BY Date";
                $this->resultVol=mysql_query($sql2);
            }
            
            function updateSkipperValue(){
                $updateskipper=$_POST['updateSkipper'];
                $sqlup="UPDATE $this->tbl_name SET IsSkipper=$updateskipper WHERE Id='$this->id'";
                mysql_query($sqlup);
            }
            
            function removeVolunteerValue(){
                $unvolunteer=$_POST['unvolunteer'];
                $sqlup="DELETE FROM volunteers WHERE Volid='$this->id' AND Voppnum=$unvolunteer";
                mysql_query($sqlup);
            }
            
            function updateOrNot(){
                if(isset($_POST['updateSkipper'])){
                    $this->updateSkipperValue();
                }
                if(isset($_POST['unvolunteer'])){
                    $this->removeVolunteerValue();
                }
            }
            
            function isSkipper(){
                return $this->skipper==1;
            }
            
            function showSkipperInformation(){
                echo"<font size=\"4\"><b>$this->fname $this->lname ($this->id)</b></font>";
            }
            
            function showVolunteerInformation(){
                $result=$this->resultVol;
                $numVol=mysql_numrows($result);
                for($i=0; $i<$numVol; $i++){
                    $date=mysql_result($result,$i,"Date");
                    $oppname=mysql_result($result,$i,"Oppname");
                    $oppnum=mysql_result($result,$i,"Oppnum");
                    ?><!--I will modify to put these information into table -->
                    <form name="volunteers" action="stinfo.php" method="POST">
                        <font size="4"><?php echo "$date $oppname";?></font>
                        <input type="hidden" name="unvolunteer" value=<?php echo $oppnum;?>>
                        <input type="submit" value="Unvolunteer">
                    </form>
                    <?php
                }
            }
        }
        ?>
        
        
        
    </body>
</html>
