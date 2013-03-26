<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Student login</title>
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
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
            
            if(isset($_POST['button']))
            {
                //If the previous action was submit, verify login
                if($_POST['button']=="Login")
                    $message = verifyLogin($formInfo);

                //If the previous action was cancel, goes back to index page
                else if($_POST['button']=="Cancel")
                    header("location:index.php");
            }
                 
        ?>
        <h1>Student login</h1>
        <p id="message">
        <?php if(isset($message)) echo $message; ?>
        </p>
        <form id="form" name="stlogin" action="stlogin.php" method="POST">
            Student ID<br />
                <input type="text" size="40" name="studentID" value=
                    <?php echo $formInfo['id'];?>
                ><br />
            Password<br />
                <input type="password" size="40" name="studentPass"><br/>
            <input type="submit" name="button" value="Login">            
            <input type="submit" name="button" value="Cancel">
        </form>
        <br/><br/>
        <form name="createAccount" action="createaccount.php" method="POST">
            <input type="submit" value="Create an Account">
        </form>        
        
    </body>
</html>

<?php
    function getPostInfo()
    {
        $formInfo['id'] = assignPostData('studentID');
        $formInfo['pass'] = assignPostData('studentPass');
        
        return $formInfo;
    }
    
    function verifyLogin($formInfo)
    {
        if(existsInDatabase2("students","Id",$formInfo['id'],"Studpass","'".$formInfo['pass']."'"))
        {
            session_start();
            $_SESSION['studentid']=$formInfo['id'];
            regUser("Student", "stinfo.php");
        }
        else
        {
            return $message = "Incorrect Username/Password Combination";
        }
    }
?>
