<!DOCTYPE HTML>
<?php
include_once 'functions.php';
include_once 'dbfunctions.php';
include_once 'displayfunctions.php';
verifyuser(array("Student"));
if(!isset($_POST['oppnum'])){
     header("location:stinfo.php");
}
$oppnum=$_POST['oppnum'];
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
        <meta name="author" content="BCCS">
        <link rel="stylesheet" type="text/css" href="reset.css">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head>
    <body>
        <div id="page-container">
            <?php volmenu(); ?> 
            <div id="content">
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
            </div>
            <?php footer(); ?>
        </div>
    </body>
</html>