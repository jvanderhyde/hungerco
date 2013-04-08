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
    
    <body>
        <div id="page-container">
            <?php mainmenu('Hunger Coalition'); ?>
            <div id="header">Header</div>
            <div id="content">Content</div>
            <div id="sidebar">
                <ul class="nav">
                    <li><a class="ver" href='stlogin.php'>Student Login</a></li>
                    <li><a class="ver" href='stflogin.php'>Staff Login</a></li>
                </ul>
            </div>
            <div id="footer">Footer</div>
        </div>
    </body>
</html>
