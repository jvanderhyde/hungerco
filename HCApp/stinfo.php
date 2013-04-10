<!DOCTYPE HTML> 
<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    include_once 'displayfunctions.php';
    verifyuser(array("Student"));
    $id =$_SESSION["studentid"];
 ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Student Information</title>
        <meta name="author" content="BCCS">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head>
    <body>
        <?php
        
        if(isset($_POST['button']))
        {
            //If the previous action was remove skipper
            if($_POST['button']=="Remove from list")
                changeSkipperValue($id,0);

            //If the previous action was become skipper
            else if($_POST['button']=="Add to list")
                changeSkipperValue($id,1);
        }
        
        if(isset($_POST['unvolunteer']))
        {
            removeVolunteerValue($id,$_POST['unvolunteer']);
        }
        ?>
            
        <div id="page-container">
            <div id="header">
                <?php studmenu("Welcome <?php echo getStudName($id); ?>"); ?>
            </div>
            <div id="content">      
                <?php
                    if(isSkipper($id))
                    {
                ?>
                <p>
                    You are currently on Skip-a-Meal!<br/>
                    Thank you so much for your support!<br/><br/>
                    Want to help more?
                    <form name="volopp" action="volopp.php" method="POST">
                        <input type="hidden" name="year" value=<?php echo date("Y");?>>
                        <input type="hidden" name="month" value=<?php echo date("m");?>>
                        <input type="submit" value="Volunteer Opportunities">
                    </form><br/>
                    Can't do Skip-a-Meal?
                    <form name="removeSkipper" action="stinfo.php" method="POST">
                        <input type="submit" name="button" value="Remove from list">
                    </form>
                </p>
                <?php
                    }
                    else
                    {
                ?>
                <p>
                    You are currently not on Skip-a-Meal.<br/><br/>
                    Want to help?
                    <form name="volopp" action="volopp.php" method="POST">
                        <input type="hidden" name="year" value=<?php echo date("Y");?>>
                        <input type="hidden" name="month" value=<?php echo date("m");?>>
                        <input type="submit" value="Volunteer Opportunities">
                    </form><br/>
                    Want to sign up for Skip-a-Meal?
                    <form name="becomeSkipper" action="stinfo.php" method="POST">
                        <input type="hidden" name="updateSkipper" value="1">
                        <input type="submit" name="button" value="Add to list">
                    </form>
                </p>
                <?php   
                    }
                ?>
            </div>
            <div id="sidebar"> 
                <?php showVolunteerInformation($id); ?>
            </div>
            <div id="footer">Footer</div> 
        </div>
    </body>
</html>

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
}

function showVolunteerInformation($id)
{        
    $volopps = getPersonalVolOpps($id);
    if($volopps)
    {
        echo "<table border='1'>
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th></th>
            </tr>";
        foreach ($volopps as $volopp) 
        {
            $date = $volopp['Date'];
            $name = $volopp['Oppname'];
            $num = $volopp['Oppnum'];
            echo "<tr>
                    <td>$date</td>
                    <td>$name</td>
                    <td>
                        <form name='unvolunteer' action='stinfo.php' method='POST'>
                            <input type='hidden' name='unvolunteer' value=$num>
                            <input type='submit' value='Unvolunteer'>
                        </form>
                    </td>
                </tr>";
        }
        echo "</table><br/>";

        echo "</table><br/>";
    }
}
?>   
