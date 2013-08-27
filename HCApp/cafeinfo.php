<!DOCTYPE HTML>
<?php 
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    include_once 'displayfunctions.php';
    verifyuser(array("Cafeteria"));

    $numskip = getNumSkip();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>"Cafeteria Hunger Coalition Information</title> 
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
                <br/>
                <h1>The current number of skippers is <?php echo $numskip ?></h1>
                <br/>
                <form name="logout" action="logout.php" method="POST">
                    <input type="submit" value="Logout">
                </form>
                <br/>
            </div>
            <?php footer();  ?>
        </div>
    </body>
</html>