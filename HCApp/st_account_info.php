<?php
        include_once 'functions.php';
        include_once 'dbfunctions.php';
        verifyuser(array("Officer"));
        if(isset($_SESSION["stid"]))
        {
            $id = $_SESSION["stid"];
        }
        else
        {
            header("location:staccounts.php");
        }
?>
<html>
    <head> 
        <title>Student Account Information</title>
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head> 
    <body>
        
        
        
        <h1>Student Accounts</h1>
        

        <form name="home" action="staccounts.php" method="POST">
             <input type="submit" value="Back">
        </form>

    </body>
</html>