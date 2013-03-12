<!DOCTYPE HTML>
<html>
    <head> 
        <title>"Cafeteria Hunger Coalition Information</title> 
    </head> 
    <body> 
        <?php 
            include_once 'functions.php';
            include_once 'dbfunctions.php';
            verifyuser(array("Officer"));

            $numskip = getNumSkip();
        ?>

        <h1>The current number of skippers is <?php echo $numskip ?></h1>

    <form name="download" action="skiplistdownload.php" method="POST">
        <input type="submit" value="Download Skipper List">
    </form>
    
    <form name="home" action="officerhome.php" method="POST">
        <input type="submit" value="Back to Home Page">
    </form>
    
    <form name="logout" action="logout.php" method="POST">
        <input type="submit" value="Logout">
    </form>
    
</body>
</html>
