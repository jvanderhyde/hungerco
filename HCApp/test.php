<!DOCTYPE HTML> 
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
 ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Families Information</title> 
        <meta name="author" content="BCCS">
        <link rel="stylesheet" type="text/css" href="reset.css">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head>
    <body id="route">
        <div id="page-container">
            <?php officermenu(); ?>
            <div id="content" >
                <div class="offset">
                    <h1>The Current Families</h1>
                    <br/>
                    <?php
                    familiesTable('North');
                    familiesTable('Middle');
                    familiesTable('South');
                    familiesTable('Unsigned');
                    ?>
                    <form name="add" action="create_family.php" method="POST">
                        <input type="submit" value="Add Family">
                    </form>
                    <br />
                </div>
            </div>
            <?php footer() ?>
        </div>
    </body>
</html>
<?php
function showVolunteerInformation($id)
{        
    $volopps = getPersonalVolOpps($id,true);
    if($volopps)
    {
        echo "<table  class='voltable' border='1'>
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th></th>
            </tr>";
        foreach ($volopps as $volopp) 
        {
            $date = $volopp['Date'];
            $name = $volopp['Oppname'];
            $num = $volopp['Oppnum'];
            echo "<tr>
                    <td>$date</td>
                    <td>$name</td>
                    <td>
                        <form name='unvolunteer' action='stinfo.php' method='POST'>
                            <input type='hidden' name='unvolunteer' value=$num>
                            <input type='submit' value='Unvolunteer'>
                        </form>
                    </td>
                </tr>";
        }
        echo "</table>";
    }
}
?>   
