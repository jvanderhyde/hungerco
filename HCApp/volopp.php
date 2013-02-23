<?php
 session_start();
 if(!session_is_registered("studentid")){
     header("location:stlogin.php");
 }
 else if(!isset($_POST['year'])){
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
        $year=isset($_POST['year'])?$_POST['year']:"";
        $month=isset($_POST['month'])?$_POST['month']:"";
        
        makeLinks($year, $month);
        
        require_once("CalendarClass.php");
        $obj_cdr = &  new CalendarClass();
        $obj_cdr->setData(2013, 2, 1, "Test");
        ?>
<!--
        <a href="#" onclick="document.previousmonth.submit();return false;" > ＜Previous month</a>
        <a href="#" onclick="document.nextmonth.submit();return false;" > Next month＞</a>
        
        <form name="previousmonth" action="./volopp.php" method="POST">
            <input type="hidden" name="year" value=<?php echo $year;?>>
            <input type="hidden" name="month" value=<?php echo $month-1;?>>
        </form>
        <form name="nextmonth" action="./volopp.php" method="POST">
            <input type="hidden" name="year" value=<?php echo $year;?>>
            <input type="hidden" name="month" value=<?php echo $month+1;?>>
        </form>
        -->
        
        <?php
        echo $obj_cdr->getCalendar($year, $month);
        ?>

        <form name="back" action="stinfo.php" method="POST">
            <input type="submit" value="Back">
        </form>
        <?php
        function makeLinks($year, $month){
            ?>
            <a href="#" onclick="document.previousmonth.submit();return false;" > ＜Previous month</a>
            <a href="#" onclick="document.thismonth.submit();return false;" > This month</a>
            <a href="#" onclick="document.nextmonth.submit();return false;" > Next month＞</a>
            
            <form name="previousmonth" action="./volopp.php" method="POST">
                <input type="hidden" name="year" value=<?php echo $month==1?$year-1:$year;?>>
                <input type="hidden" name="month" value=<?php echo$month==1?12:$month-1;?>>
            </form>
            <form name="thismonth" action="./volopp.php" method="POST">
                <input type="hidden" name="year" value=<?php echo date("Y");?>>
                <input type="hidden" name="month" value=<?php echo date("m");?>>
            </form>
            <form name="nextmonth" action="./volopp.php" method="POST">
                <input type="hidden" name="year" value=<?php echo $month==12?$year+1:$year;?>>
                <input type="hidden" name="month" value=<?php echo$month==12?1:$month+1;?>>
            </form>
            <?php
        }
        ?>
    </body>
</html>