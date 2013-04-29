<!DOCTYPE HTML>
<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    include_once 'displayfunctions.php';
    verifyuser(array("Officer"));
    if(!isset($_SESSION['delete']))
    {
        header("location:index.php");
    }
?>
<html>
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Confirm Delete</title> 
        <meta name="author" content="BCCS" />
        <link rel="stylesheet" type="text/css" href="reset.css">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head> 
    <body>
        <div id="page-container">
            <?php officermenu(); ?>        
            <div id="content">
                <br/>
                <h1>Are you sure you want to permanently delete this data?</h1>
                <div class="offset">
                    <?php
                    $del_info=$_SESSION['delete'];
                    $type=$del_info['type'];
                    switch ($type) {
                        case 'staccount':
                            askDeleteStaccount($del_info['id']);
                            break;
                        case 'volopp':
                            askDeleteVolopp($del_info['oppnum']);
                            break;
                        case 'family':
                            askDeleteFamily($del_info['addresscity']);
                            break;
                    }
                    ?>
                </div>
            </div>
            <?php footer();  ?>
        </div>
    </body>
</html>
<?php
function askDeleteStaccount($id)
{
    $stinfo = getStudentInfo($id);
    ?>
    <table border="1">
        <tr>
            <th>First Name</th>
            <td><?php echo $stinfo['fName']; ?></td>
        </tr>
        <tr>
            <th>Middle Name</th>
            <td><?php echo isset($stinfo['minit'])?$stinfo['minit']:"&nbsp;"; ?></td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td><?php echo $stinfo['lName']; ?></td>
        </tr>
        <tr>
            <th>Student ID</th>
            <td><?php echo $stinfo['id']; ?></td>
        </tr>
        <tr>
            <th>Skipper</th>
            <td><?php echo ($stinfo['isSkipper']==1)?'Yes':'No'; ?></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td><?php echo isset($stinfo['phone'])?$stinfo['phone']:"&nbsp;"; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo isset($stinfo['email'])?$stinfo['email']:"&nbsp;"; ?></td>
        </tr>
        <tr>
            <th>Password</th>
            <td><?php echo $stinfo['pass']; ?></td>
        </tr>
    </table><br/><br/>
    <table border="0">
        <tr>
            <td>
                <form name="delete" action="staccounts.php" method="POST">
                    <input type="hidden" name="delete_id" value="<?php echo $id;?>">
                    <input type="submit" name="button" value="Delete">
                </form>
            </td>
            <td>
                <form name="cancel" action="st_account_info.php" method="POST">
                    <input type="submit" value="Cancel">
                </form>
            </td>
        </tr>
    </table>
    <?php
}

function askDeleteVolopp($oppnum)
{
    $volopp=getVolunteerOppotunityInformation($oppnum);

    $date=$volopp["Date"];
    $oppname=isset($volopp["Oppname"])?$volopp["Oppname"]:"Nameless($oppnum)";
    $year=date('Y',strtotime($date));
    $month=date('m',strtotime($date));
    $description=isset($volopp["Description"])?$volopp["Description"]:"No data";
    ?>
    <font size="4"><?php echo $oppname;?></font><br/>
    <font size="4"><?php echo $date;?></font><br/>
    <font size="4"><?php echo $description;?></font><br/><br/>
    <table border="0">
        <tr>
            <td>
                <form name="delete" action="officer_volopps.php" method="POST">
                    <input type="hidden" name="oppnum" value=<?php echo $oppnum;?>>
                    <input type="hidden" name="year" value=<?php echo $year;?>>
                    <input type="hidden" name="month" value=<?php echo $month;?>>
                    <input type="submit" name="button" value="Delete">
                </form>
            </td>
            <td>
                <form name="cancel" action="officer_volopp_info.php" method="POST">
                    <input type="hidden" name="oppnum" value=<?php echo $oppnum;?>>
                    <input type="submit" value="Cancel">
                </form>
            </td>
        </tr>
    </table>
    
    <?php
}

function askDeleteFamily($addresscity)
{
    $familyInfo = getFamilyInfo($addresscity);
    
    ?>
    <table border="1">
        <tr>
            <th>Name</th>
            <td><?php echo $familyInfo['Famname']; ?></td>
        </tr>
        <tr>
            <th>Number of lunches</th>
            <td><?php echo isset($familyInfo['NumLunch'])?$familyInfo['NumLunch']:"&nbsp;"; ?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><?php echo $familyInfo['Address']; ?></td>
        </tr>
        <tr>
            <th>City</th>
            <td><?php echo $familyInfo['City']; ?></td>
        </tr>
        <tr>
            <th>Phone Number</th>
            <td><?php echo isset($familyInfo['Famphone'])?$familyInfo['Famphone']:"&nbsp;"; ?></td>
        </tr>
        <tr>
            <th>Notes</th>
            <td><?php echo isset($familyInfo['Notes'])?$familyInfo['Notes']:"&nbsp;"; ?></td>
        </tr>
    </table><br/><br/>
    <table border="0">
        <tr>
            <td>
                <form name="delete" action="families.php" method="POST">
                    <input type="hidden" name="addresscity" value="<?php echo $addresscity;?>">
                    <input type="submit" name="button" value="Delete">
                </form>
            </td>
            <td>
                <form name="cancel" action="families.php" method="POST">
                    <input type="submit" value="Cancel">
                </form>
            </td>
        </tr>
    </table>
    <?php
}
?>