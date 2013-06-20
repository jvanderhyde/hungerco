<?php
        include_once 'functions.php';
        include_once 'dbfunctions.php';
        include_once 'displayfunctions.php';
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
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Student Accounts</title>
        <meta name="author" content="BCCS">
        <link rel="stylesheet" type="text/css" href="reset.css">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head> 
    <body id="acct"> 
        <div id="page-container">
            <?php officermenu(); ?>        
            <div id="content">
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
                <br />
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
                </form>
                <br />
            </div>
            <div id="sidebar" ></div>
            <?php footer();  ?>
        </div>
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