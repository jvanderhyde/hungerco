<!DOCTYPE HTML>
<?php
include 'functions.php';
include 'dbfunctions.php';
verifyuser("Student");
if(!isset($_POST['oppnum'])){
     header("location:stinfo.php");
 }
 ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $oppnum=$_POST['oppnum'];
        getConnectionWithDatabase();
        $resource=getVolunteerOppotunityInformation($oppnum);
        mysql_close();
        
        $date=mysql_result($resource,0,"Date");
        $oppname=mysql_result($resource,0,"Oppname");
        $year=date('Y',strtotime($date));
        $month=date('m',strtotime($date));
        ?>
        <h1><?php echo $oppname;?></h1>
        <font size="4"><?php echo $date;?></font><br/>
        <font size="4">description here</font><br/>
        <form name="join" action="volopp.php" method="POST">
            <input type="hidden" name="year" value=<?php echo $year;?>>
            <input type="hidden" name="month" value=<?php echo $month;?>>
            <input type="hidden" name="oppnum" value=<?php echo $oppnum;?>>
            <input type="submit" value="Join">
        </form>
        <form name="cancel" action="volopp.php" method="POST">
            <input type="hidden" name="year" value=<?php echo $year;?>>
            <input type="hidden" name="month" value=<?php echo $month;?>>
            <input type="submit" value="Cancel">
        </form>
        
        <?php
        function getConnectionWithDatabase(){
            mysql_connect('localhost:3306', "hungerco", "intensiveness")
                    or die("cannot connect");
            mysql_select_db("HUNGERCO")or die("cannot select DB");
        }
        function getVolunteerOppotunityInformation($oppnum){
            $sql="SELECT * FROM vol_opps WHERE Oppnum=$oppnum";
            return mysql_query($sql);
        }
        ?>
    </body>
</html>