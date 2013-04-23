<!DOCTYPE HTML>
<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    verifyuser(array("Officer"));
    $map=isset($_POST['routemap'])?$_POST['routemap']:'North';
    if(isset($_POST['stop']))
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
        <script type="text/javascript" 
            src="http://maps.google.com/maps/api/js?v=3&sensor=false&language=en"></script>
        <script src="map.js" type="text/javascript"></script>
    </head> 
    <body onload="initialize()">
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
                    <td width="800" height="700"><div id="map_canvas" style="width:800px; height:700px"></div></td>
                    <td><?php showAddressList($map,$families);?></td>
                </tr>
            </table>
            <?php
        }
        
        ?>
    
        <!--<div id="route" style="width: 500px; height: 200px;overflow: scroll"></div>-->
        

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

    
    
    
    <?php
            /*
            echo 'var request ={origin: start,destination: end,';
            
            if(count($list)>1)
            {
                for($i=0; $i<count($list)-1; $i++)
                {
                    $middle=$list[$i];
                    echo "middles[$i]=\"$middle\"";
                }
            }
             
             
            echo 'travelMode: google.maps.DirectionsTravelMode.DRIVING,';
            echo 'unitSystem: google.maps.DirectionsUnitSystem.IMPERIAL,';
            echo 'optimizeWaypoints: true,avoidHighways: false,avoidTolls: false};';
            */
            ?>
            <?php
            /*
            var request ={
                origin: start,
                destination: end,
                waypoints:[
                {
                location: "1125 L St., Atchison",
                stopover:true
                }, 
                {
                location: "513 N. 10th, Atchison",
                stopover:true
                }, 
                {
                location: "1120 Laramie, Atchison",
                stopover:true
                }
                ],
                travelMode: google.maps.DirectionsTravelMode.DRIVING,
                unitSystem: google.maps.DirectionsUnitSystem.IMPERIAL,
                optimizeWaypoints: true,
                avoidHighways: false,
                avoidTolls: false 
                };*/
                ?>
            <?php
            /*
            for($i=0; $i<count($list)-1; $i++)
            {
                $middle=$list[$i];
                echo "middles[$i]=\"$middle\"";
            }*/
            ?>