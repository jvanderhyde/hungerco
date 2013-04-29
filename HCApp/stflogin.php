<!DOCTYPE HTML>
<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    include_once 'displayfunctions.php';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Staff login</title>
        <meta name="author" content="BCCS" />
        <link rel="stylesheet" type="text/css" href="reset.css">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head>
    <body>
        <div id="page-container">
            <?php mainmenu(); ?>
            <div id="content"></div>
            <div id="sidebar">
                <?php
                    //Stores information from a previous post (if any) to 
                    //associative array $formInfo
                    $formInfo = getPostInfo();

                    //Cleans all submitted information
                    foreach($formInfo as $value)
                        $value = protectInjection($value);

                    if(isset($_POST['button'])&&$_POST['button']=="Login")
                    {
                        //If the previous action was submit, verify login
                        $message = verifyLogin($formInfo);
                    }
                ?>
                <div class="offset">
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
                    </form>
                </div>
            </div>
            <div id="footer">Footer</div>
        </div>
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
