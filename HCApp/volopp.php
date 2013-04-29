<!DOCTYPE HTML>
<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    include_once 'displayfunctions.php';
    require_once("CalendarClass.php");
    verifyuser(array("Student"));
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Volunteer Opportunities</title>
        <meta name="author" content="BCCS">
        <link rel="stylesheet" type="text/css" href="reset.css">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head>
    <body id="vol">
        <div id="page-container">
            <?php volmenu(); ?> 
            <div id="content">
                <?php
                $id=$_SESSION["studentid"];
                $year=isset($_POST['year'])?$_POST['year']:date("Y");
                $month=isset($_POST['month'])?$_POST['month']:date("m");
                makeLinks($year, $month);

                if(isset($_POST['oppnum']))
                {
                    addVolunteerValue($id,$_POST['oppnum']);
                }

                $monthlyAllVolopps = getMonthlyVolOpps($year, $month);
                $monthlyJoinVolopps = getMonthlyRegisteredVolOpps($id, $year, $month);

                $obj_cdr = &  new CalendarClass();
                if($monthlyAllVolopps){
                    $obj_cdr->setPersonalVolunteerOpportunity($monthlyJoinVolopps, $monthlyAllVolopps,"./volopp_info.php");
                }

                echo $obj_cdr->getCalendar($year, $month);

                ?>                    
            </div>
            <?php footer(); ?>
        </div>

        <?php
        function makeLinks($year, $month){
            ?>
        
            <div id='subnav'>
                <a href="#" onclick="document.previousmonth.submit();return false;" > ＜Previous month</a>
                <a href="#" onclick="document.thismonth.submit();return false;" > This month</a>
                <a href="#" onclick="document.nextmonth.submit();return false;" > Next month＞</a>

                <form name="previousmonth" action="./volopp.php" method="POST">
                    <input type="hidden" name="year" value=<?php echo $month==1?$year-1:$year;?>>
                    <input type="hidden" name="month" value=<?php echo $month==1?12:$month-1;?>>
                </form>
                <form name="thismonth" action="./volopp.php" method="POST">
                    <input type="hidden" name="year" value=<?php echo date("Y");?>>
                    <input type="hidden" name="month" value=<?php echo date("m");?>>
                </form>
                <form name="nextmonth" action="./volopp.php" method="POST">
                    <input type="hidden" name="year" value=<?php echo $month==12?$year+1:$year;?>>
                    <input type="hidden" name="month" value=<?php echo $month==12?1:$month+1;?>>
                </form>
            </div>
                <?php
        }
        ?>
    </body>
</html>