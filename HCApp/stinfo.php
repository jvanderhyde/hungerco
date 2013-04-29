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
        <link rel="stylesheet" type="text/css" href="reset.css">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head>
    <body id="home">
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
            <?php studmenu($id); ?>
            <div id="content" >      
                <?php
                    if(isSkipper($id))
                    {
                ?>
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
                    <?php
                        }
                        else
                        {
                    ?>
                    You are currently not on Skip-a-Meal.<br/><br/>
                    Want to help?
                    <form name="volopp" action="volopp.php" method="POST">
                        <input type="submit" value="Volunteer Opportunities">
                    </form><br/>
                    Want to sign up for Skip-a-Meal?
                    <form name="becomeSkipper" action="stinfo.php" method="POST">
                        <input type="hidden" name="updateSkipper" value="1">
                        <input type="submit" name="button" value="Add to list">
                    </form>
                    <?php   
                        }
                    ?>
            </div>
            <div id="sidebar"> 
                <?php showVolunteerInformation($id); ?>
            </div>
            <?php footer();  ?>
        </div>
    </body>
</html>


<?php
function showVolunteerInformation($id)
{        
    $volopps = getPersonalVolOpps($id,true);
    if($volopps)
    {
        echo "<table  class='voltable' border='1'>
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
        echo "</table>";
    }
}
?>   
