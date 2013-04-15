<!DOCTYPE HTML>
<?php
include_once 'functions.php';
include_once 'dbfunctions.php';
verifyuser(array("Officer"));
if(isset($_SESSION['oppnum']))
{
    $oppnum=$_SESSION['oppnum'];
}
else if(isset($_POST['oppnum']))
{
    $oppnum=$_POST['oppnum'];
}
else
{
    header("location:index.php");
}
$volopp=getVolunteerOppotunityInformation($oppnum);

$date=$volopp["Date"];
$oppname=isset($volopp["Oppname"])?$volopp["Oppname"]:"Nameless($oppnum)";
$year=date('Y',strtotime($date));
$month=date('m',strtotime($date));
$description=isset($volopp["Description"])?$volopp["Description"]:"No data";
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $oppname;?></title>
    </head>
    <body>
        <h1><?php echo $oppname;?></h1>
        <font size="4"><?php echo $date;?></font><br/>
        <font size="4"><?php echo $description;?></font><br/><br/>
        <form name="modify" action="modify_volopp.php" method="POST">
            <input type="hidden" name="oppnum" value=<?php echo $oppnum;?>>
            <input type="submit" value="Modify">
        </form>
        <form name="delete" action="officer_volopps.php" method="POST">
            <input type="hidden" name="oppnum" value=<?php echo $oppnum;?>>
            <input type="hidden" name="year" value=<?php echo $year;?>>
            <input type="hidden" name="month" value=<?php echo $month;?>>
            <input type="submit" name="button" value="Delete">
        </form>
        <form name="back" action="officer_volopps.php" method="POST">
            <input type="hidden" name="year" value=<?php echo $year;?>>
            <input type="hidden" name="month" value=<?php echo $month;?>>
            <input type="submit" value="Back">
        </form>
        
    </body>
</html>