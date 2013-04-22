<!DOCTYPE HTML>
<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    include_once 'displayfunctions.php';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Hunger Coalition - Home Page</title>
        <meta name="author" content="BCCS">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head>
    
    <body id="home">
        <div id="page-container">
            <?php mainmenu(); ?> 
            <div id="innerwrap">
                <div id="content">Content</div>
                <div id="sidebar">
                        <ul>
                            <li><a href='stlogin.php'><span>Student Login</span></a></li>
                            <li><a href='stflogin.php'><span>Staff Login</span></a></li>
                        </ul>
                </div>
            </div>
            <?php footer(); ?>
        </div>
    </body>
</html>
