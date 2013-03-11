<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>submit contact</title>
    </head>
    <body>
        <?php
        $message = 'Name：' . $_POST['name'] . "\nAddress：" . $_POST['address']
                . "\nPhone：" . $_POST['phone'] . "\nDescription：" . $_POST['descrip'];
        
        //We need new mail address for H.C.Officer to handle this mail form part.
        
        if (mail("H.C.Officer@mail", "contact mail",$message, "From: H.C.Officer@mail")) {
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
