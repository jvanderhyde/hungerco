<!DOCTYPE HTML>
<html>
    <head>
        <title>Create an Account</title>
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head>
    <body>
        <?php
            include 'functions.php';
            include 'dbfunctions.php';
            $formInfo['fName'] = assignPostData('fName');
            $formInfo['minit'] = assignPostData('minit');
            $formInfo['lName'] = assignPostData('lName');
            $formInfo['phone'] = assignPostData('phone');
            $formInfo['id']    = assignPostData('id');
            $formInfo['email'] = assignPostData('email');
            $formInfo['pass1'] = assignPostData('pass1');
            $formInfo['pass2'] = assignPostData('pass2');
            
            foreach($formInfo as $value)
            {
                $value = protectInjection($value);
            }
            
            if($_POST['action']=="Submit")
            {
                $formvalid = chkCrtAcctVldty($formInfo);
                if(!$formvalid['flag'])
                {
                    echo $formvalid['message'];
                }
                else
                {
                    $acctMade = makeAccount($formInfo);
                    if(!$acctMade['flag'])
                    {
                        echo $acctMade['message'];
                    }
                    else
                    {
                        session_start();
                        $_SESSION['user']="Student";
                        header("location:stinfo.php");
                    }
                }
                
            }
            else if($_POST['action']=="Cancel")
            {
                header("location:stlogin.php");
            }
        ?>
        
        <h1>Create an Account</h1>
        <form id="form" name="createaccount" action="createAccount.php" method="POST">
            Name<br />
                <input type="text" size="20" name="fName" 
                value=
                    <?php if(isset($_POST['fName']))
                            echo $formInfo['fName'];
                        else
                            echo "First"
                    ?> 
                required>
                <input type="text" size="1" maxlength="1" name="minit" 
                value=
                    <?php if(isset($_POST['minit']))
                            echo $formInfo['minit'];
                        else
                            echo "M";
                    ?>
                >
                <input type="text" size="20" name="lName" 
                value=
                    <?php if(isset($_POST['lName']))
                            echo $formInfo['lName'];
                        else
                            echo "Last";
                    ?>
                required>
            Student ID*<br />
                <input type="text" size="40" name="id" value=
                    <?php echo $formInfo['minit'];?> 
                required><br/><br/>
            Phone<br />
                <input type="text" size="40" name="phone" value=
                    <?php echo $formInfo['minit'];?>
                ><br/><br/>
            E-mail address<br />
                <input type="text" size="40" name="email" value=
                    <?php echo $formInfo['minit'];?>
                ><br/><br/>
            Password*<br />
                <input type="password" size="40" name="pass1" required><br/><br/>
            Re-enter Password*<br />
                <input type="password" size="40" name="pass2" required>
            <br/><br/>
            *Required Field
            <input type="submit" value="Submit">
            <input type="submit" value="Cancel">
        </form>
        
    </body>
</html>

<?php


?>
