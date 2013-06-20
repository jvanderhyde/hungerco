<!DOCTYPE HTML>
<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    include_once 'displayfunctions.php';
    verifyuser(array("It"));

    $numskip = getNumSkip();
    $skippers = getSkippers();
?>
<html>
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Information for IT</title>
        <meta name="author" content="BCCS">
        <link rel="stylesheet" type="text/css" href="reset.css">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head> 
<body> 
    <div id="page-container">
        <header>
            <img src='images/hclogo.jpg'>    
        </header>
        <div id="content">
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
                echo "</tr>";
            }
            ?>
            </table>

<!--            <form name="download" action="skiplistdownload.php" method="POST">
                <input type="submit" value="Download Skipper List">
            </form>-->

            <form name="logout" action="logout.php" method="POST">
                <input type="submit" value="Logout">
            </form>
        </div>
        <?php footer();  ?>
    </div>
</body>
</html>