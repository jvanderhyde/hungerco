<!DOCTYPE HTML>
<?php 
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    include_once 'displayfunctions.php';
    verifyuser(array("Officer"));

    $numskip = getNumSkip();
    $skippers = getSkippers();
?>
<html>
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Cafeteria Hunger Coalition Information</title> 
        <meta name="author" content="BCCS">
        <link rel="stylesheet" type="text/css" href="reset.css">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head> 
    <body id="skip"> 
        <div id="page-container">
            <?php officermenu(); ?>        
            <div id="content">
                <div class="offset">
                    <h1>The current number of skippers is <?php echo $numskip ?></h1>
                    <br/>   
                    <table border="1">
                    <tr>
                    <th>Name</th>
                    <th>Student ID</th>
                    </tr>
                    <?php 
                    foreach ($skippers as $student) 
                    {
                        echo "<tr>";
                        echo "<td>".$student['fname']." ".$student['lname']."</td>";
                        echo "<td>".$student['id']."</td>";
                        echo "<td>".  isSkipper($student['id'])."</td>";
                        echo "</tr>";
                    }
                    ?>
                    </table>
                </div>
<!--
                <form name="download" action="skiplistdownload.php" method="POST">
                    <input type="submit" value="Download Skipper List">
                </form>-->
            </div>
            <?php footer();  ?>
        </div>
    </body>
</html>
