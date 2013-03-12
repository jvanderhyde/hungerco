<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Staff login</title>
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
        
        <h1>Staff login</h1>
        <p id="message">
        <?php if(isset($message)) echo $message; ?>
        </p>
        <form id="form" name="stlogin" action="stflogin.php" method="POST">
            Username<br />
                <input type="text" size="40" name="staffName" value=
                       <?php echo $formInfo['user'];?>
                ><br />
            Password<br />
                <input type="password" size="40" name="staffPass" required><br/><br/>
            <input type="submit" name="button" value="Login">
            <input type="submit" name="button" value="Cancel">
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
        if(existsInDatabase2("staff","Staffname","'".$formInfo['user']."'","Staffpass","'".$formInfo['pass']."'"))
        {
            switch($formInfo['user'])
            {
                case "Cafeteria":
                    regUser("Cafeteria","cafeinfo.php");
                    break;
                case "IT":
                    regUser("It","itinfo.php");
                    break;
                case "HCOfficer":
                    regUser("Officer","officerhome.php");
                    break;
                default:
                    $message = "User not currently supported";
            }
        }
        else
        {
            $message = "Incorrect Username/Password Combination";
        }
        return $message;
    }
?>
