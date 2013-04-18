<html>
    <head> 
        <title>Families Information</title> 
    </head> 
    <body>
        <?php
            include_once 'functions.php';
            include_once 'dbfunctions.php';
            verifyuser(array("Officer"));
        ?>
        <h1>The Current Families</h1>

        <?php
        familiesTable('North');
        familiesTable('Middle');
        familiesTable('South');
        familiesTable('Unsigned');
        ?>
        <form name="add" action="create_family.php" method="POST">
            <input type="submit" value="Add Family">
        </form><br />

        <form name="home" action="officerhome.php" method="POST">
            <input type="submit" value="Back to Home Page">
        </form>

    </body>
</html>
<?php

function familiesTable($route)
{
    $families=getFamilies($route);
    if(!$families)
        return;
    ?>
    <form name="<?php echo $route;?>table" action="modify_family.php" method="POST">
        <table border="1">
            <caption><b><?php echo $route;?> Route</b></caption>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Number of Lunches</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Notes</th>
            </tr>
            <?php 
            $firstfamily=true;
            foreach ($families as $family) 
            {
                $addresscity=$family['Address'].','.$family['City'];
                ?>
                <tr>
                    <td><input type="radio" name="addresscity" value="<?php echo "$addresscity";?>"
                    <?php
                    if($firstfamily)
                    {
                        echo 'checked></td>';
                        $firstfamily=false;
                    }
                    else
                        echo '></td>';
                    
                    $l=isset($family['NumLunch'])?$family['NumLunch']:"&nbsp;";
                    $p=isset($family['Famphone'])?$family['Famphone']:"&nbsp;";
                    $n=isset($family['Notes'])?$family['Notes']:"&nbsp;";
                    echo "<td>".$family['Famname']."</td>";
                    echo "<td align=\"center\">$l</td>";
                    echo "<td>".$family['Address'].", ".$family['City']."</td>";
                    echo "<td>$p</td>";
                    echo "<td>$n</td>";
                echo "</tr>";
            }
            ?>
        </table>
        
        <input type="submit" value="Modify">
        <select name="newroute">
            <?php
            $selectroute=$route;
            for($i=0;$i<=3;$i++)
            {
                $textroute='';
                switch ($i) {
                    case 0:
                        $textroute='North';
                        break;
                    case 1:
                        $textroute='Middle';
                        break;
                    case 2:
                        $textroute='South';
                        break;
                    case 3:
                        $textroute='Unsigned';
                        break;
                }

                if($textroute==$selectroute)
                    echo "<option value=\"$textroute\" selected>$textroute</option>";
                else
                    echo "<option value=\"$textroute\">$textroute</option>";
            }
            ?>
        </select>
        <input type="hidden" name="oldroute" value="<?php echo $route;?>">
        <input type="submit" name="button" value="Change Route">
        <input type="submit" name="button" value="Delete">
        <br />
    </form>
    <?php
}

?>
