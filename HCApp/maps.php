<!DOCTYPE HTML>
<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    include_once 'displayfunctions.php';
    verifyuser(array("Officer"));
    
    $map=isset($_POST['routemap'])?$_POST['routemap']:'North';
    
    if(isset($_POST['button']) && $_POST['button']=='Refresh')
    {
        $map=$_POST['currentmap'];
    }
    
    if(isset($_POST['stop']) && isset($_POST['button']))
    {
        if($_POST['button']=="Move to Different Route")
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
        <meta name="author" content="BCCS">
        <link rel="stylesheet" type="text/css" href="reset.css">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
        <link rel="stylesheet" type="text/css" media="print" href="print.css" />
                <?php
        if($list){
        ?>
        <script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>
        <script type="text/javascript">
            var middlePoints= new Array(<?php echo count($list); ?>);
            <?php
            for($i=0; $i<count($list); $i++)
            {
                echo"middlePoints[$i]=\"$list[$i], KS\";";
            }
            ?>
            function printpage()
            {
                window.print();
            }
        </script>
        <script src="map.js" type="text/javascript" charset="utf-8"></script>
        <?php
        }
        ?>
    </head>
    <body id="map">
        <div id="page-container">
            <div class="donotprint">
                <?php officermenu(); ?>
            </div>
            <div id="content" >
                <div class="donotprint">
                <br/>
                <?php
                $families=getFamiliesWithStop($map,'STOP');
                pulldownMap($map);
                echo "<br/>";
                if(!$families)
                {
                    echo "<h1>No families are on the $map Route</h1>";
                }
                else
                {
                    ?>
                </div>
                    <div id="map_canvas" style="position: relative; width:100%; height:700px;"></div>
                    <?php
                }

                ?>        
            </div>
            <div class="donotprint">
                <div id="sidebar" class="veroffset">
                    <?php showAddressList($map,$families);?>
                </div>
                <?php footer() ?>
            </div>
        </div>
<?php
function pulldownMap($map)
{
    ?>
    <form name="<?php echo $map;?>Route" action="maps.php" method="POST">
    <?php
    echo '<select name="routemap">';
    $selectmap=$map;
    for($i=0;$i<=2;$i++)
    {
        $textmap='';
        switch ($i) 
        {
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
    <input type="hidden" name="currentmap" value="<?php echo $map;?>">
    <input type="submit" name="button" value="Refresh">
    <input type="button" value="Print this page" onclick="printpage()">
    </form>
    <?php
}

        function showAddressList($map,$families)
        {
            $size=count($families);
            if($size>30)
                $size=30;
            ?>
            <form name="<?php echo $map;?>RouteList" action="maps.php" method="POST">
                <b>A: Benedictine College</b><br />
                <select name="stop" size="<?php echo $size;?>" style="font-size: 18px;">
                    <?php 
                    foreach ($families as $family) 
                    {
                        $stop = $family["STOP"];
                        $stopAlphabet = num_to_str($stop);
                        $family_info = $stopAlphabet.": ".$family["Famname"].", ".$family["Address"].", ".$family["City"];
                        echo "<option value=\"$stop\">$family_info</option>";
                    }
                    ?>
                </select><br />
                <input type="hidden" name="routemap" value=<?php echo $map;?>>
                <input type="submit" name="button" value="UP">
                <input type="submit" name="button" value="DOWN">
                <br/>
                <input type="submit" name="button" value="Move to Different Route">
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
            </form><br />
            <?php
        }
        ?>
    </body>
</html>
