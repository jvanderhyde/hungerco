<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    include_once 'displayfunctions.php';
    verifyuser(array("Officer"));
    
    if(isset($_POST['button']) && $_POST['button']=='Delete')
    {
        $addresscity=$_POST['addresscity'];
        deleteFamily($addresscity);
    }
    if(isset($_SESSION["delete"]))
    {
        unset($_SESSION["delete"]);
    }
    
    if(isset($_POST['button']) && $_POST['button']=='Change order')
    {
        if($_POST['orderType']=='stop')
        {
            $_SESSION['order']='stop';
        }
        else if($_POST['orderType']=='name' && isset($_SESSION['order']))
        {
            unset($_SESSION['order']);
        }
    }
    
?>
<html>
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Families Information</title> 
        <meta name="author" content="BCCS">
        <link rel="stylesheet" type="text/css" href="reset.css">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head> 
    <body id="family">
        <div id="page-container">
            <?php officermenu(); ?>
            <div id="content" >
                <div class="offset">
                    <h1>The Current Families</h1><br/>
                    <form name="chooseOrder" action="families.php" method="POST">
                        <p>
                        Order by<br/>
                        <input type="radio" name="orderType" value="name" <?php echo isset($_SESSION['order'])?'':'checked';?>>Name
                        <input type="radio" name="orderType" value="stop" <?php echo isset($_SESSION['order'])?'checked':'';?>>Stop
                        </p>
                        <input type="submit" name="button" value="Change order">
                    </form>
                    <form name="add" action="create_family.php" method="POST">
                        <input type="submit" value="Add Family">
                    </form>
                    <br/>
                    <?php
                    familiesTable('North');
                    familiesTable('Middle');
                    familiesTable('South');
                    familiesTable('Mall Towers');
                    familiesTable('Unsigned');
                    ?>
                    <br />
                </div>
            </div>
            <?php footer() ?>
        </div>
        <?php

        function familiesTable($route)//
        {
            if($route=='Unsigned')
            {
                $families=getFamilies($route);
            }
            else if(isset($_SESSION['order']) && $_SESSION['order']=='stop')  
            {
                $families=getFamiliesWithStop($route, 'STOP');
            }
            else
            {
                $families=getFamiliesWithStop($route, 'Famname,City,Address');
            }

            if(!$families)
            {
                return;
            }

            ?>
            <form name="<?php echo $route;?>table" action="modify_family.php" method="POST">
                <table border="1">
                    <caption><b><?php echo $route;?> Route</b></caption>
                    <tr>
                        <th></th>
                        <?php echo ($route!='Unsigned')?'<th>Stop</th>':'';?>
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
                            echo ($route!='Unsigned')?"<td>".$family['STOP']."</td>":'';
                            echo "<td>".$family['Famname']."</td>";
                            echo "<td align=\"center\">$l</td>";
                            echo "<td>".$family['Address']." ".$family['City']."</td>";
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
                    for($i=0;$i<=4;$i++)
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
                                $textroute='Mall Towers';
                                break;
                            case 4:
                                $textroute='Unassigned';
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
            </form><br /><br />
            <?php
        }

        ?>
    </body>
</html>