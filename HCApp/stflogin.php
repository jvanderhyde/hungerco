<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Staff login</title>
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
        
        <h1>Staff login</h1>
        <h1><br /><?php echo message; ?></h1>
        <form id="form" name="stlogin" action="stflogin.php" method="POST">
            Username<br />
                <input type="text" size="40" name="staffName" value=
                       <?php echo $formInfo['user'];?>
                required>
            Password<br />
                <input type="password" size="40" name="staffPass" required><br/><br/>
            <input type="submit" value="Login">
            <input type="submit" value="Cancel">
        </form>
        
    </body>
</html>

<?php
    function getPostInfo()
    {
        $formInfo['user'] = assignPostData('staffName');
        $formInfo['pass'] = assignPostData('staffPass');
        
        return $formInfo;
    }
    
    function verifyLogin($formInfo)
    {
        if(existsInDatabase2("staff","Staffname",$formInfo['user'],"Staffpass",$formInfo['pass']))
        {
            switch($formInfo['user'])
            {
                case "Cafeteria":
                    regSess("Cafe","cafeinfo.php");
                    break;
                case "IT":
                    regSess("It","itinfo.php");
                    break;
                case "Officer":
                    regSess("Officer","officerhome.php");
                    break;
                default:
                    $message = "User not currently supported";
                    header("location:stflogin.php");
            }
        }
        else
        {
            $message = "Incorrect Username/Password Combination";
        }
    }
?>
