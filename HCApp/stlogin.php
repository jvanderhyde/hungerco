<!DOCTYPE HTML>
<?php 
    session_start();
    if(isset($_SESSION['user']))
        unset($_SESSION['user']);
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Student login</title>
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head>
    <body>
        <?php
            include 'functions.php';
            include 'dbfunctions.php';
            
            //Stores information from a previous post (if any) to 
            //associative array $formInfo
            $formInfo = getPostInfo();
            
            //Cleans all submitted information
            foreach($formInfo as $value)
                $value = protectInjection($value);
            
            //If the previous action was submit, verify login
            if($_POST['action']=="Login")
                verifyLogin($formInfo);
            
            //If the previous action was cancel, goes back to index page
            else if($_POST['action']=="Cancel")
                header("location:index.php");
        ?>
        <h1>Student login</h1>
        <form id="form" name="stlogin" action="stlogin.php" method="POST">
            Student ID<br />
                <input type="text" size="40" name="studentID" value=
                    <?php echo $formInfo['id'];?>
                required><br />
            Password<br />
                <input type="password" size="40" name="studentPass"><br/>
            <input type="submit" value="Login">            
            <input type="submit" value="Cancel">
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
        if(existsInDatabase2("student","Id",$formInfo['id'],"Studpass",$formInfo['pass']))
        {
            regSess("Student", "stinfo.php");
        }
        else
        {
            $message = "Incorrect Username/Password Combination";
        }
    }
?>
