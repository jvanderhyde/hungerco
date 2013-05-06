<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>submit contact</title>
    </head>
    <body>
        <?php
        $message = 'Name：' . $_POST['name'] . "\nAddress：" . $_POST['address']
                . "\nPhone：" . $_POST['phone'] . "\nDescription：" . $_POST['descrip'];
        
        
        
        if (mail("hungercoalition@benedictine.edu", "contact mail",$message, "From: hungercoalition@benedictine.edu")) {
            echo'Thank you for submiting';
        }
        else {
            echo "Unable to deliver message.<br />Please retry later.";
        }
        ?>
        <form name="next" action="index.php" method="POST">
            <input type="submit" value="Next">
        </form>


    </body>
</html>
