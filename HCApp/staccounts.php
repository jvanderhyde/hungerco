<?php
        include_once 'functions.php';
        include_once 'dbfunctions.php';
        verifyuser(array("Officer"));
        if(isset($_SESSION["stid"]))
        {
            unset($_SESSION["stid"]);
        }
        if(isset($_SESSION['delete']))
        {
            unset($_SESSION['delete']);
        }
        if(isset($_POST['button']) && $_POST['button']=='Delete')
        {
            deleteStaccount($_POST['delete_id']);
        }
?>
<html>
    <head> 
        <title>Student Accounts</title>
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head> 
    <body> 
        
        
        <h1>Student Accounts</h1>
        <?php
            //Stores information from a previous post (if any) and cleans
            $formid = protectInjection(assignPostData('stid'));
            
            
            //If the previous action was submit, verify view
            if(isset($_POST['button']) && $_POST['button']=='View')
                $message = verifyView($formid);
        ?>
        <p id="message">
        <?php if(isset($message)) echo $message; ?>
        </p>
        <form id="form" name="chooseaccount" action="staccounts.php" method="POST">
            Student ID<br />
                <input type="text" size="40" name="stid" value=
                    "<?php echo $formid;?>"
                >
            <input type="submit" name="button" value="View">
        </form>
        <br />
        <form name="createAccount" action="createaccount.php" method="POST">
            <input type="submit" value="Create an Account">
        </form><br />
        <form name="home" action="officerhome.php" method="POST">
            <input type="submit" value="Back to Home Page">
        </form>

    </body>
</html>

<?php
    function verifyView($formid)
    {
        if(!$formid)
        {
           return $message = "Please fill Student ID";
        }
        elseif(existsInDatabase1("students","Id",$formid))
        {
            session_start();
            $_SESSION["stid"] = $formid;
            header("location:st_account_info.php");
        }
        else
        {
            return $message = "Incorrect Student ID";
        }
    }
?>