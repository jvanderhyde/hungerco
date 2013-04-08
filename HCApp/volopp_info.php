<!DOCTYPE HTML>
<?php
include_once 'functions.php';
include_once 'dbfunctions.php';
verifyuser(array("Student"));
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
        connectToDB();
        $resource=getVolunteerOppotunityInformation($oppnum);
        mysql_close();
        
        $date=mysql_result($resource,0,"Date");
        $oppname=mysql_result($resource,0,"Oppname");
        $year=date('Y',strtotime($date));
        $month=date('m',strtotime($date));
        $description=mysql_result($resource,0,"Description");
        ?>
        <h1><?php echo $oppname;?></h1>
        <font size="4"><?php echo $date;?></font><br/>
        <font size="4"><?php echo $description;?></font><br/><br/>
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
        
    </body>
</html>