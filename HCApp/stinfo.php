<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Student Information</title>
    </head>
    <body>
        <h1>Student Information</h1>
        <?php
        $id=$_POST['studentID'];
        $passward=$_POST['studentPass'];
        ?>
        <?php
        echo "<h4>ID</h4><b>$id</b><br /><h4>Passward</h4><b>$passward</b><br />";
        ?>
        
        
    </body>
</html>
