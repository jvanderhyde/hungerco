<!DOCTYPE HTML>
<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    verifyuser(array("Officer"));
    $map=isset($_POST['routemap'])?$_POST['routemap']:'North';
    if(isset($_POST['button']))
    {
        if($_POST['button']=='UP')
        {
            upList($map,$_POST['stop']);
        }
        elseif($_POST['button']=='DOWN')
        {
            downList($map,$_POST['stop']);
        }
    }
?>
<html>
    <head> 
        <title><?php echo $map;?> Route</title> 
    </head> 
    <body>
        <?php
        $families=getFamiliesWithStop($map);
        pulldownMap($map);
        if(!$families)
        {
            echo "<h1>No family is on the $map Route</h1>";
        }
        else
        {
            ?>
            
            <table border="1">
                <tr>
                    <td width="800" height="700"><?php echo $map;?> map</td>
                    <td><?php showAddressList($map,$families);?></td>
                </tr>
            </table>
            <?php
        }
        
        ?>
    

        <form name="home" action="officerhome.php" method="POST">
            <input type="submit" value="Back to Home Page">
        </form>

    </body>
</html>
<?php
function pulldownMap($map)
{
    ?>
    <form name="<?php echo $map;?>Route" action="routes.php" method="POST">
        <?php
        echo '<select name="routemap">';
        $selectmap=$map;
        for($i=0;$i<=2;$i++)
        {
            $textmap='';
            switch ($i) {
                case 0:
                    $textmap='North';
                    break;
                case 1:
                    $textmap='Middle';
                    break;
                case 2:
                    $textmap='South';
                    break;
            }

            if($textmap==$selectmap)
                echo "<option value=\"$textmap\" selected>$textmap Route</option>";
            else
                echo "<option value=\"$textmap\">$textmap Route</option>";
        }
        echo'</select>';
        ?>
        <input type="submit" value="View Route">
    </form>
    <?php
}

function showAddressList($map,$families)
{
    $size=count($families);
    if($size>30)
        $size=30;
    ?>
    <form name="<?php echo $map;?>RouteList" action="routes.php" method="POST">
        <select name="stop" size="<?php echo $size;?>">
            <?php 
            foreach ($families as $family) 
            {
                $stop = $family["STOP"];
                $family_info = $family["STOP"]." ".$family["Famname"]." ".$family["Address"].", ".$family["City"];
                echo "<option value=\"$stop\">$family_info</option>";
            }
            ?>
        </select><br />
        <input type="hidden" name="routemap" value=<?php echo $map;?>>
        <input type="submit" name="button" value="UP">
        <input type="submit" name="button" value="DOWN">
    </form><br />
    <?php
}
?>