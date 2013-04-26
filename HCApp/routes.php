<!DOCTYPE HTML>
<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    verifyuser(array("Officer"));
    
    $map=isset($_POST['routemap'])?$_POST['routemap']:'North';
    
    if(isset($_POST['stop']) && isset($_POST['button']))
    {
        if($_POST['button']=="Change Route")
        {
            $newroute=$_POST['newroute'];
            $oldroute=$_POST['routemap'];
            if($newroute!=$oldroute)
            {
                $movedFamily=getFamilyInfoFromStop($oldroute,$_POST['stop']);
                $addresscity=$movedFamily['Address'].",".$movedFamily['City'];
                changeRoute($addresscity,$oldroute,$newroute);
                $map=$newroute;
            }
        }
        elseif($_POST['button']=='UP')
        {
            upList($map,$_POST['stop']);
        }
        elseif($_POST['button']=='DOWN')
        {
            downList($map,$_POST['stop']);
        }
    }
    $list=getRouteAddresses($map);
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $map;?> Route</title>
        <?php
        if($list){
        ?>
        <script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>
        <script type="text/javascript">
            var middlePoints= new Array(<?php echo count($list); ?>);
            <?php
            for($i=0; $i<count($list); $i++)
            {
                echo"middlePoints[$i]=\"$list[$i]\";";
            }
            ?>
        </script>
        <script src="map.js" type="text/javascript" charset="utf-8"></script>
        <?php
        }
        ?>
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
                    <td width="800" height="700"><div id="map_canvas" style="position: relative; width:800px; height:700px;"></div></td>
                    <td><?php showAddressList($map,$families);?></td>
                </tr>
            </table><br/>
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
        A: Benedictine College<br />
        <select name="stop" size="<?php echo $size;?>" style="font-size: 16px;">
            <?php 
            foreach ($families as $family) 
            {
                $stop = $family["STOP"];
                $stopAlphabet = num_to_str($stop);
                $family_info = $stopAlphabet.": ".$family["Famname"].", ".$family["Address"]." ".$family["City"];
                echo "<option value=\"$stop\">$family_info</option>";
            }
            ?>
        </select><br />
        <input type="hidden" name="routemap" value=<?php echo $map;?>>
        <input type="submit" name="button" value="UP">
        <input type="submit" name="button" value="DOWN">
        <select name="newroute">
            <?php
            $selectroute=$map;
            for($i=0;$i<=2;$i++)
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
                }

                if($textroute==$selectroute)
                    echo "<option value=\"$textroute\" selected>$textroute</option>";
                else
                    echo "<option value=\"$textroute\">$textroute</option>";
            }
            ?>
        </select>
        <input type="submit" name="button" value="Change Route">
    </form><br />
    <?php
}
?>
