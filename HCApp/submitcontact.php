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
        
        //We need mail sending program.
        
        if (mail("hungercoalition@benedictine.edu", "contact mail",$message, "From: hungercoalition@benedictine.edu")) {
            echo'Thank you for submit';
        }
        else {
            echo "Error happend.<br />Please retry later.";
        }
        ?>
        <form name="next" action="index.php" method="POST">
            <input type="submit" value="Next">
        </form>


    </body>
</html>
