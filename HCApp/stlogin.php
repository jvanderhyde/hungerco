<!DOCTYPE HTML>
<?php
    include_once 'functions.php';
    include_once 'dbfunctions.php';
    include_once 'displayfunctions.php';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Student login</title>
        <meta name="author" content="BCCS" />
        <link rel="stylesheet" type="text/css" href="reset.css">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head>
    <body>
        <div id="page-container">
            <?php mainmenu(); ?>
            <div id="content">Content</div>
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
                    <h2>Student login</h2>
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
                    </form>  
                </div>
            </div>
            <?php footer(); ?>
        </div>
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
        if(is_numeric($formInfo['id']) && existsInDatabase2("students","Id",$formInfo['id'],"Studpass","'".$formInfo['pass']."'"))
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
