<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    verifyuser(array("Officer"));
    if(isset($_SESSION["stid"]))
    {
        $id = $_SESSION["stid"];
    }
    else
    {
        header("location:staccounts.php");
    }
    
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
    
    if(isset($_POST['addvolopps']))
    {
        foreach($_POST['addvolopps'] as $oppnum)
        {
            addVolunteerValue($id,$oppnum);
        }
    }
?>
<html>
    <head> 
        <title>Student Account Information</title>
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head> 
    <body>
        <h1>Account Information of ID:<?php echo $id; ?></h1>
        <?php
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
        </table>
        
        <form name="modifyinfo" action="modify_staccount.php" method="POST">
            <input type="submit" name="button" value="Modify Information">
        </form><br />
        
        <form name="skippervalue" action="st_account_info.php" method="POST">
            <table border="1">
                <tr>
                    <th>Skipper</th>
                    <td><?php echo isSkipper($id)?"Yes":"No"; ?></td>
                </tr>
            </table>
            <input type="submit" name="button" value=
                <?php echo isSkipper($id)?"\"Remove skipper\"":"\"Become skipper\""; ?>>
        </form><br />
        
        <?php
        $volopps = getPersonalVolOpps($id);
        if($volopps)
        {
        ?>
        <table border="1">
            <caption><b>Volunteer Opportunities</b></caption>
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
                    <form name="unvolunteer" action="st_account_info.php" method="POST">
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
        
        $unregisteredvolopps = getUnregisteredVolOpps($id);
        if($unregisteredvolopps)
        {
        ?>
        <form name="unregisteredvolopps" action="st_account_info.php" method="POST">
            <b>Unregistered Volunteer Opportunities</b><br />
            <select name="addvolopps[]" size="10" multiple>
                <?php 
                foreach ($unregisteredvolopps as $volopp) 
                {
                    $num = $volopp["Oppnum"];
                    $date_name = $volopp["Date"]." ".$volopp["Oppname"];
                    echo "<option value=\"$num\">$date_name</option>";
                }
                ?>
            </select><br />

            <input type="submit" value="Add volunteer opportunities">
        </form><br />
        <?php
        }
        ?>
        
        
        <form name="home" action="staccounts.php" method="POST">
             <input type="submit" value="Back">
        </form>

    </body>
</html>