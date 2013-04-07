<!DOCTYPE HTML> 
<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    verifyuser(array("Student"));
    $id =$_SESSION["studentid"];
 ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
        <title>Student Information</title>
    </head>
    <body>
        <h1>Student Information</h1>
        <p id="Name"><font size="5"> <?php echo getStudName($id); ?> </font></p>
  
        <?php
        
        if(isset($_POST['button']))
        {
            //If the previous action was remove skipper
            if($_POST['button']=="Remove skipper")
                changeSkipperValue($id,0);

            //If the previous action was become skipper
            else if($_POST['button']=="Become skipper")
                changeSkipperValue($id,1);
        }
        
        if(isset($_POST['unvolunteer']))
        {
            removeVolunteerValue($id,$_POST['unvolunteer']);
        }
        
        if(isSkipper($id)){
            ?>
            <form name="removeSkipper" action="stinfo.php" method="POST">
                    <font size="4">You are a skipper.</font><br />
                    <input type="submit" name="button" value="Remove skipper">
            </form><br />
            <?php
        }
        else{
            ?>
            <form name="becomeSkipper" action="stinfo.php" method="POST">
                    <font size="4">You are not a skipper.</font><br />
                    <input type="submit" name="button" value="Become skipper">
            </form><br />
            <?php
        }
        $volopps = getPersonalVolOpps($id);
        if($volopps)
        {
        ?>
        <table border="1">
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th></th>
            </tr>
            <?php 
            foreach ($volopps as $volopp) 
            {
                echo "<tr>";
                echo "<td>".$volopp['Date']."</td>";
                echo "<td>".$volopp['Oppname']."</td>";
                ?>
                <td>
                    <form name="unvolunteer" action="stinfo.php" method="POST">
                        <input type="hidden" name="unvolunteer" value=<?php echo $volopp['Oppnum'];?>>
                        <input type="submit" value="Unvolunteer">
                    </form>
                </td>
                <?php
                echo "</tr>";
            }
            ?>
        </table>
        <br />
        <?php
        }
        ?>
        <form name="volopp" action="volopp.php" method="POST">
            <input type="hidden" name="year" value=<?php echo date("Y");?>>
            <input type="hidden" name="month" value=<?php echo date("m");?>>
            <input type="submit" value="Volunteer Opportunities">
        </form><br />
        <form name="logout" action="logout.php" method="POST">
            <input type="submit" value="Logout">
        </form>
    </body>
</html>
