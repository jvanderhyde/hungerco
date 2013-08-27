<!DOCTYPE HTML>
<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    include_once 'displayfunctions.php';
    verifyuser(array("Officer"));
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Modify an Account</title>
        <meta name="author" content="BCCS" />
        <link rel="stylesheet" type="text/css" href="reset.css">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">  
    </head>
    <body>
        <div id="page-container">
            <?php officermenu(); ?>        
            <div id="content">
                <div class="offset">
                    <?php
                        if(isset($_SESSION["stid"]))
                        {
                            $id = $_SESSION["stid"];
                        }
                        else
                        {
                            header("location:staccounts.php");
                        }

                        //Stores information from a previous post (if any) to 
                        //associative array $formInfo
                        $formInfo = getPostInfo();

                        //Cleans all submitted information
                        foreach($formInfo as $value)
                            $value = protectInjection($value);

                        if(isset($_POST['button']))
                        {
                            //If the previous action was submit, creates an account
                            if($_POST['button']=="Modify")
                                submitModify($formInfo);

                            //If the previous action was cancel, goes back to student login page
                            if($_POST['button']=="Cancel")
                                header("location:st_account_info.php");
                        }

                        $stinfo = getStudentInfo($id);


                    ?>

                    <h1>Modify the Account of ID:<?php echo $id; ?></h1>
                    <br/>
                    <form id="form" name="modifyaccount" action="modify_staccount.php" method="POST">
                        Name(First*, Middle, Last*)<br />
                            <input type="text" size="20" name="fName" 
                            value=
                                <?php if(isset($_POST['fName']))
                                        echo $formInfo['fName'];
                                    else
                                        echo $stinfo['fName'];
                                ?> 
                            >
                            <input type="text" size="1" maxlength="1" name="minit" 
                            value=
                                <?php if(isset($_POST['minit']))
                                        echo $formInfo['minit'];
                                    else
                                        echo isset($stinfo['minit'])?$stinfo['minit']:"";
                                ?>
                            >
                            <input type="text" size="20" name="lName" 
                            value=
                                <?php if(isset($_POST['lName']))
                                        echo $formInfo['lName'];
                                    else
                                        echo $stinfo['lName'];
                                ?>
                            ><br /><br />

                        Phone<br />
                            <input type="text" size="40" name="phone" value=
                                <?php if(isset($_POST['phone']))
                                        echo $formInfo['phone'];
                                    else
                                        echo isset($stinfo['phone'])?$stinfo['phone']:"";
                                ?>
                            ><br/><br/>
                        E-mail address<br />
                            <input type="text" size="40" name="email" value=
                                <?php if(isset($_POST['email']))
                                        echo $formInfo['email'];
                                    else
                                        echo isset($stinfo['email'])?$stinfo['email']:"";
                                ?>
                            ><br/><br/>
                        Password*<br />
                            <input type="text" size="40" name="pass" value=
                                <?php if(isset($_POST['pass']))
                                        echo $formInfo['pass'];
                                    else
                                        echo $stinfo['pass'];
                                ?>
                            ><br/><br/>
                        <p id="note"> *Required Field </p>
                        <input type="submit" name="button" value="Modify" >
                        <input type="submit" name="button" value="Cancel" >
                    </form>
                </div>
            </div>
            <?php footer();  ?>
        </div>
    </body>
</html>

<?php
    function getPostInfo()
    {
        $formInfo['fName'] = assignPostData('fName');
        $formInfo['minit'] = assignPostData('minit');
        $formInfo['lName'] = assignPostData('lName');
        $formInfo['phone'] = assignPostData('phone');
        $formInfo['email'] = assignPostData('email');
        $formInfo['pass'] = assignPostData('pass');
        
        return $formInfo;
    }

    function submitModify($formInfo)
    {
        //Ensures information entered properly
        $formValid = chkCrtAcctVldty($formInfo);
        
        if(chkErr($formValid))
        {
            //Creates account and verifies creation was successful
            $acctMade = modifyAccount($formInfo,$_SESSION['stid']);
            if(chkErr($acctMade))
            {
                header("location:st_account_info.php");
            }
        }
    }
    
    function chkCrtAcctVldty($formInfo)
    {
        if(!$formInfo['fName']||!$formInfo['lName']||!$formInfo['pass'])
        {
            $isvalid['message'] = "Please fill all blank spaces required";
            $isvalid['flag'] = false;
            return $isvalid;
        }
        else
        {
            $isvalid['flag'] = true;
            return $isvalid;
        }
    }  
?>
