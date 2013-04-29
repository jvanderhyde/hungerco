<!DOCTYPE HTML>
<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    include_once 'displayfunctions.php';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Contact Hunger Coalition</title>
        <meta name="author" content="BCCS">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head>
    
    <body id="contact">
        <div id="page-container">
            <?php mainmenu(); ?>
            <div id="content" >
                <h1 class="indentcontent">Contact Us</h1>
                <form class="indentcontent" id="form" name="contactus" action="submitcontact.php" method="POST">
                    Name<br />
                        <input type="text" size="40" name="name"><br/>
                    Email Address<br />
                        <input type="text" size="40" name="address"><br/>
                    Phone<br />
                        <input type="text" size="40" name="phone"><br/>
                    Message<br />
                        <textarea name='descrip' rows='15' cols='40'>Type message here.
                        </textarea>
                    <br/>
                    <input type="submit" value="Submit">
                </form>
                <br/>
            </div>
<!--            <div id="sidebar">Sidebar</div>-->
            <?php footer(); ?>   
        </div>
    </body>
</html>
