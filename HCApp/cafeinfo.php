<!DOCTYPE HTML>
<html>
    <head> 
        <title>"Cafeteria Hunger Coalition Information</title> 
    </head> 
    <body> 
        <?php 
            include 'functions.php';
            verifyuser("Cafeteria");

            $numskip = getNumSkip();
        ?>

        <h1>The current number of skippers is <?php echo $numskip ?></h1>
        <form name="logout" action="logout.php" method="POST">
            <input type="submit" value="Logout">
        </form>
    </body>
</html>