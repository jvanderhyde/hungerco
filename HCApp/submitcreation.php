<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $fName=$_POST['fName'];
        $minit=$_POST['minit'];
        $lName=$_POST['lName'];
        $id=$_POST['id'];
        $phone=$_POST['phone'];
        $email=$_POST['email'];
        $password1=$_POST['password1'];
        $password2=$_POST['password2'];
        $succeess=null;
        $idExist=null;//check by using SQL at Database with $id.
        
        if(!$fName||!$lName||!$id||!$phone||!$email||!$password1||!$password2){
            echo"<h1>Please fill all blank spaces except middle initial.</h1>";
        }
        elseif($idExist){
            echo"<h1>This student ID has already been registered.</h1>";
        }
        elseif(strcmp($password1,$password2)!=0){
            echo"<h1>Your passwords do not equal.</h1>";
        }
        else{
            echo"<h1>Your acount creation is completed.</h1>";
            $succeess=true;
        }
        
        if($succeess){
        ?>
        <form name="finishcreation" action="stlogin.php" method="POST">
            <input type="submit" value="Next">
        </form>
        <?php
        }
        else{
        ?>
        <form name="failcreation" action="createaccount.php" method="POST">
            <input type="hidden" name="enteredNameF"
                   <?php
                   echo"value=$fName";
                   ?>
                   >
            <input type="hidden" name="enteredNameM"
                   <?php
                   echo"value=$minit";
                   ?>
                   >
            <input type="hidden" name="enteredNameL"
                   <?php
                   echo"value=$lName";
                   ?>
                   >
            <input type="hidden" name="enteredId"
                   <?php
                   echo"value=$id";
                   ?>
                   >
            <input type="hidden" name="enteredPhone"
                   <?php
                   echo"value=$phone";
                   ?>
                   >
            <input type="hidden" name="enteredEmail"
                   <?php
                   echo"value=$email";
                   ?>
                   >
            <input type="submit" value="Back">
        </form>
        <?php
        }
        ?>
    </body>
</html>
