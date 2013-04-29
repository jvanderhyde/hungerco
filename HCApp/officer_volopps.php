<?php
        include_once 'functions.php';
        include_once 'dbfunctions.php';
        include_once 'displayfunctions.php';
        require_once("CalendarClass.php");
        verifyuser(array("Officer"));
        if(isset($_SESSION["oppnum"]))
        {
            unset($_SESSION["oppnum"]);
        }
        if(isset($_SESSION["delete"]))
        {
            unset($_SESSION["delete"]);
        }
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
            <?php officermenu(); ?>        
            <div id="content">
                <?php
                if(isset($_POST['button']) && $_POST['button']=='Delete')
                {
                    deleteVolunteerOpportunity($_POST['button']);
                }

                if(isset($_POST['year']))
                {
                    $year=$_POST['year'];
                    $month=$_POST['month'];
                }
                elseif(isset($_SESSION["date"]))
                {
                    $year=date('Y',strtotime($_SESSION["date"]));
                    $month=date('m',strtotime($_SESSION["date"]));
                }
                else
                {
                    $year=date("Y");
                    $month=date("m");
                }
                if(isset($_POST['directyear']))
                {
                    if(is_numeric($_POST['directyear']) && strlen($_POST['directyear'])==4)
                    {
                        $directyear=intval($_POST['directyear']);
                        if($directyear>0)
                        {
                            $year=$directyear;
                            $month=$_POST['directmonth'];
                        }
                        else
                        {
                            $message="Please enter a positive year.";
                        }
                    }
                    else
                    {
                        $message="Please enter a four-digit year.";
                    }
                }
                ?>
                <p id="message">
                <?php if(isset($message)) echo $message; ?>
                </p>
                <?php
                makeLinks($year, $month);

                $monthlyAllVolopps = getMonthlyVolOpps($year, $month);

                $obj_cdr = &  new CalendarClass();
                if($monthlyAllVolopps){
                    $obj_cdr->setAdminVolunteerOpportunity($monthlyAllVolopps,"./officer_volopp_info.php");
                }
                $obj_cdr->setAllLinks("./create_volopp.php");
                echo $obj_cdr->getCalendar($year, $month);
                ?>
                <br/>
            </div>
            <?php footer();  ?>
        </div>

        <?php
        function makeLinks($year, $month){
            ?>
            <div id='subnav'>
                <br/>
                <table border="0">
                    <tr>
                         <td>
                             <form id="form" name="chooseyearmonth" action="officer_volopps.php" method="POST">
                                <input type="text" size="4" maxlength="4" name="directyear" value=<?php echo $year;?>>
                                <select name="directmonth">
                                    <?php
                                    $selectMonth=$month;
                                    for($i=1;$i<=12;$i++)
                                    {
                                        $textmonth='';
                                        switch ($i) {
                                            case 1:
                                                $textmonth='Jan.';
                                                break;
                                            case 2:
                                                $textmonth='Feb.';
                                                break;
                                            case 3:
                                                $textmonth='Mar.';
                                                break;
                                            case 4:
                                                $textmonth='Apr.';
                                                break;
                                            case 5:
                                                $textmonth='May';
                                                break;
                                            case 6:
                                                $textmonth='Jun.';
                                                break;
                                            case 7:
                                                $textmonth='Jul.';
                                                break;
                                            case 8:
                                                $textmonth='Aug.';
                                                break;
                                            case 9:
                                                $textmonth='Sep.';
                                                break;
                                            case 10:
                                                $textmonth='Oct.';
                                                break;
                                            case 11:
                                                $textmonth='Nov.';
                                                break;
                                            case 12:
                                                $textmonth='Dec.';
                                                break;
                                        }

                                        if($i==$selectMonth)
                                            echo "<option value=\"$i\" selected>$textmonth</option>";
                                        else
                                            echo "<option value=\"$i\">$textmonth</option>";
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="year" value=<?php echo $year;?>>
                                <input type="hidden" name="month" value=<?php echo $month;?>>
                                <input type="submit" name="button" value="View">
                            </form>
                         </td>
                    </tr>
                </table>
                <br/>
                    <a href="#" onclick="document.previousmonth.submit();return false;" > ＜Previous month</a>
                    <a href="#" onclick="document.thismonth.submit();return false;" > This month</a>
                    <a href="#" onclick="document.nextmonth.submit();return false;" > Next month＞</a>

                    <form name="previousmonth" action="./officer_volopps.php" method="POST">
                        <input type="hidden" name="year" value=<?php echo $month==1?$year-1:$year;?>>
                        <input type="hidden" name="month" value=<?php echo $month==1?12:$month-1;?>>
                    </form>
                    <form name="thismonth" action="./officer_volopps.php" method="POST">
                        <input type="hidden" name="year" value=<?php echo date("Y");?>>
                        <input type="hidden" name="month" value=<?php echo date("m");?>>
                    </form>
                    <form name="nextmonth" action="./officer_volopps.php" method="POST">
                        <input type="hidden" name="year" value=<?php echo $month==12?$year+1:$year;?>>
                        <input type="hidden" name="month" value=<?php echo $month==12?1:$month+1;?>>
                    </form>
                </div>
        <?php
        }
        ?>
    </body>
</html>

