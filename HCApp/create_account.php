<!DOCTYPE HTML>
<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    include_once 'displayfunctions.php';
?>
<html>
    <head>
        <title>Create an Account</title>
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php
            include_once 'functions.php';
            include_once 'dbfunctions.php';
            verifyuser(array("Officer"));
            
            //Stores information from a previous post (if any) to 
            //associative array $formInfo
            $formInfo = getPostInfo();
            
            //Cleans all submitted information
            foreach($formInfo as $value)
                $value = protectInjection($value);
            
            if(isset($_POST['button']))
            {
                //If the previous action was submit, creates an account
                if($_POST['button']=="Submit")
                    submitCreate($formInfo);

                //If the previous action was cancel, goes back to student login page
                if($_POST['button']=="Cancel")
                    header("location:staccounts.php");
            }
                   
        ?>
        
        <h1>Create an Account</h1>
        <form id="form" name="createaccount" action="create_account.php" method="POST">
            Name<br />
                <input type="text" size="20" name="fName" 
                value=
                    <?php if(isset($_POST['fName']))
                            echo $formInfo['fName'];
                        else
                            echo "First*"
                    ?> 
                >
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
                            echo "Last*";
                    ?>
                ><br /><br />
            Student ID*<br />
                <input type="text" size="40" name="id" value=
                    <?php echo $formInfo['id'];?> 
                ><br/><br/>
            Phone<br />
                <input type="text" size="40" name="phone" value=
                    <?php echo $formInfo['phone'];?>
                ><br/><br/>
            E-mail address<br />
                <input type="text" size="40" name="email" value=
                    <?php echo $formInfo['email'];?>
                ><br/><br/>
            Password*<br />
                <input type="password" size="40" name="pass1" ><br/><br/>
            Re-enter Password*<br />
                <input type="password" size="40" name="pass2" >
            <br/><br/>
            <p id="note"> *Required Field </p>
            <input type="submit" name="button" value="Submit" >
            <input type="submit" name="button" value="Cancel" >
        </form>
        
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
        $formInfo['id']    = assignPostData('id');
        $formInfo['email'] = assignPostData('email');
        $formInfo['pass1'] = assignPostData('pass1');
        $formInfo['pass2'] = assignPostData('pass2');
        
        return $formInfo;
    }

    function submitCreate($formInfo)
    {
        //Ensures information entered properly
        $formValid = chkCrtAcctVldty($formInfo);
        
        if(chkErr($formValid))
        {
            //Creates account and verifies creation was successful
            $acctMade = makeAccount($formInfo);
            if(chkErr($acctMade))
            {
                
                //logout();
                session_start();
                $_SESSION['stid']=$formInfo['id'];
                //regUser("Student","stinfo.php");
                header("location:st_account_info.php");
                
            }
        }
    }
    
    function chkCrtAcctVldty($formInfo)
    {
        if(!$formInfo['fName']||!$formInfo['lName']||!$formInfo['id']
                ||!$formInfo['pass1']||!$formInfo['pass2'])
        {
            $isvalid['message'] = "Please fill all blank spaces required";
            $isvalid['flag'] = false;
            return $isvalid;
        }
        elseif(strlen($formInfo['id'])!=6)
        {
            $isvalid['message'] = "Please fill 6 numbers for student ID";
            $isvalid['flag'] = false;
            return $isvalid;
        }
        elseif(existsInDatabase1("students","Id",$formInfo['id']))
        {
            $isvalid['message'] = "This student ID has already been registered.";
            $isvalid['flag'] = false;
            return $isvalid;
        }
        elseif(strcmp($formInfo['pass1'],$formInfo['pass2'])!=0)
        {
            $isvalid['message'] = "Your passwords do not equal.";
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
