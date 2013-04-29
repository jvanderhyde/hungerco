<!DOCTYPE HTML>
<?php
include_once 'functions.php';
include_once 'dbfunctions.php';
include_once 'displayfunctions.php';
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

if(isset($_SESSION['delete']))
{
    unset($_SESSION['delete']);
}

if(isset($_POST['button']) && $_POST['button']=='Delete')
{
    $del_info['type']='volopp';
    $del_info['oppnum']=$oppnum;
    $_SESSION['delete']=$del_info;
    header("location:confirm_delete.php");
}


$volopp=getVolunteerOppotunityInformation($oppnum);
$volunteers = setVols($oppnum);

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
            <?php officermenu(); ?>        
            <div id="content">
                <div class="offset">
                    <h1><?php echo $oppname;?></h1>
                    <font size="4"><?php echo $date;?></font><br/>
                    <font size="4"><?php echo $description;?></font><br/><br/>
                    <form name="modify" action="modify_volopp.php" method="POST">
                        <input type="hidden" name="oppnum" value=<?php echo $oppnum;?>>
                        <input type="submit" value="Modify">
                    </form>
                    <form name="delete" action="officer_volopp_info.php" method="POST">
                        <input type="hidden" name="oppnum" value=<?php echo $oppnum;?>>
                        <input type="submit" name="button" value="Delete">
                    </form>
                    <form name="back" action="officer_volopps.php" method="POST">
                        <input type="hidden" name="year" value=<?php echo $year;?>>
                        <input type="hidden" name="month" value=<?php echo $month;?>>
                        <input type="submit" value="Back to Calendar">
                    </form>
                </div>
            </div>
            <div id="sidebar">
                <table class="voltable" border="1">
                    <caption><b>Volunteers</b></caption>
                    <tr>
                    <th>Name</th>
                    </tr>
                    <?php 
                        foreach ($volunteers as $student) 
                        {
                            echo "<tr>";
                            echo "<td>".$student['fname']." ".$student['lname']."</td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
            <?php footer();  ?>
        </div>
    </body>
</html>

<?php
    function setVols($num)
    {
        $areVols = getVolunteers($num);
            if($areVols['flag'])
                return $areVols['vols'];
            else
                return array();
    }

?>