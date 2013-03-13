<!DOCTYPE HTML>
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
            
            //Stores information from a previous post (if any) to 
            //associative array $formInfo
            $formInfo = getPostInfo();
            
            //Cleans all submitted information
            foreach($formInfo as $value)
                $value = protectInjection($value);
            
            //If the previous action was submit, creates an account
            if(isset($_POST['action'])&&$_POST['action']=="Submit")
                submitCreate($formInfo);
            
            //If the previous action was cancel, goes back to student login page
            else if(isset($_POST['action'])&&$_POST['action']=="Cancel")
                header("location:stlogin.php");
            
        ?>
        
        <h1>Create an Account</h1>
        <form id="form" name="createaccount" action="createAccount.php" method="POST">
            Name<br />
                <input type="text" size="20" name="fName" 
                value=
                    <?php if(isset($_POST['fName']))
                            echo $formInfo['fName'];
                        else
                            echo "First*"
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
                            echo "Last*";
                    ?>
                required><br /><br />
            Student ID*<br />
                <input type="text" size="40" name="id" value=
                    <?php echo $formInfo['id'];?> 
                required><br/><br/>
            Phone<br />
                <input type="text" size="40" name="phone" value=
                    <?php echo $formInfo['phone'];?>
                ><br/><br/>
            E-mail address<br />
                <input type="text" size="40" name="email" value=
                    <?php echo $formInfo['email'];?>
                ><br/><br/>
            Password*<br />
                <input type="password" size="40" name="pass1" required><br/><br/>
            Re-enter Password*<br />
                <input type="password" size="40" name="pass2" required>
            <br/><br/>
            *Required Field
            <input type="submit" value="Submit" name="action">
            <input type="submit" value="Cancel" name="action">
        </form>
        
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
                regUser("Student","stinfo.php");
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
