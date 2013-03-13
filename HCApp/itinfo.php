<!DOCTYPE HTML>
<html>
<head> 
<title></title> 
</head> 
<body> 
    
    <?php
        include_once 'functions.php';
        include_once 'dbfunctions.php';
        verifyuser(array("It"));

        $numskip = getNumSkip();
        $skippers = getSkippers();
    ?>

    <h1>The current number of skippers is <?php echo $numskip ?></h1>
    
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
    
    <form name="download" action="skiplistdownload.php" method="POST">
        <input type="submit" value="Download Skipper List">
    </form>
    
    <form name="logout" action="logout.php" method="POST">
        <input type="submit" value="Logout">
    </form>
    
</body>
</html>