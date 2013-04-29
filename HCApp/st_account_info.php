<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    include_once 'displayfunctions.php';
    verifyuser(array("Officer"));
    if(isset($_SESSION["stid"]))
    {
        $id = $_SESSION["stid"];
    }
    else
    {
        header("location:staccounts.php");
    }
    if(isset($_SESSION["delete"]))
    {
        unset($_SESSION["delete"]);
    }
    
    if(isset($_POST['button']))
    {
        //If the previous action was remove skipper
        if($_POST['button']=="Remove skipper")
            changeSkipperValue($id,0);

        //If the previous action was become skipper
        elseif($_POST['button']=="Become skipper")
            changeSkipperValue($id,1);
        elseif($_POST['button']=="Delete Student")
        {
            $del_info['type']='staccount';
            $del_info['id']=$id;
            $_SESSION['delete']=$del_info;
            header("location:confirm_delete.php");
        }
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
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Student Account Information</title>
        <meta name="author" content="BCCS">
        <link rel="stylesheet" type="text/css" href="reset.css">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head> 
    <body>
        <div id="page-container">
            <?php officermenu(); ?>        
            <div id="content">
                <div class="offset">
                    <h1>Account Information of ID:<?php echo $id; ?></h1>
                    <br />
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
                    </form>
                    <br />
                    <form name="delete" action="st_account_info.php" method="POST">
                        <input type="submit" name="button" value="Delete Student">
                    </form><br />
                </div>
            </div>
            <div id="sidebar">
                <?php
                $volopps = getPersonalVolOpps($id,true);
                if($volopps)
                {
                ?>

                <table class='voltable' border="1">
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
                <div class="offset">
                    <?php
                    }

                    $unregisteredvolopps = getUnregisteredVolOpps($id,true);
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
                        </select>
                        <br />
                        <input type="submit" value="Add volunteer opportunities">
                    </form><br />
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php footer();  ?>
        </div>
    </body>
</html>