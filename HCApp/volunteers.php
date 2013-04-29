<html>
    <head> 
        <title>Volunteers</title>
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head> 
    <body> 
        <?php
            include_once 'functions.php';
            include_once 'dbfunctions.php';
            verifyuser(array("Officer"));

            $vol_opps = getVolOpps();   
            if(isset($_POST['volOpp']))
                $volnum = $_POST['volOpp'];
            else if(isset($vol_opps[0]))
                $volnum = $vol_opps[0]['oppnum'];
            
            $volunteers = setVols($volnum);
        ?>
        
        <h1>Volunteers</h1>
        <form name="selectOpp" action="volunteers.php" method="POST">
            <select name='volOpp'>
                <?php 
                    foreach ($vol_opps as $opp) 
                    {
                        echo "<option value='".$opp['oppnum']."'>".
                                $opp['oppname']." ".$opp['date']."</option>";
                    }
                ?>
            </select>
            <input type="submit" name="button" value="View Volunteers">
        </form>
        
        <table border="1">
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

        <form name="home" action="officerhome.php" method="POST">
            <input type="submit" value="Back to Home Page">
        </form>

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