<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Create an Account</title>
    </head>
    <body>
        <?php
        $enteredNameF=$_POST['enteredNameF'];
        $enteredNameM=$_POST['enteredNameM'];
        $enteredNameL=$_POST['enteredNameL'];
        $enteredPhone=$_POST['enteredPhone'];
        $enteredId=$_POST['enteredId'];
        $enteredEmail=$_POST['enteredEmail'];
        ?>
        <h1>Create an Account</h1>
        <font size="4"><b>*Indicates required field</b></font><br />
        <form name="createaccount" action="submitcreation.php" method="POST">
            <font size="4"><b>Name</b></font><br />
            <table border="0">
                <tr>
                    <td>First name*:</td>
                    <td>
                        <input type="text" size="20" name="fName"
                               <?php
                               if($enteredNameF){
                                   echo"value=$enteredNameF";
                               }
                               ?>
                               >
                    </td>
                </tr>
                <tr>
                    <td>Middle Initial:</td>
                    <td>
                        <input type="text" size="1" maxlength="1" name="minit"
                               <?php
                               if($enteredNameM){
                                   echo"value=$enteredNameM";
                               }
                               ?>
                               >
                    </td>
                </tr>
                <tr>
                    <td>Last name*:</td>
                    <td>
                        <input type="text" size="20" name="lName"
                               <?php
                               if($enteredNameL){
                                   echo"value=$enteredNameL";
                               }
                               ?>
                               >
                    </td>
                </tr>
            </table><br />
            <font size="4"><b>Student ID*</b></font><br />
            <input type="text" size="40" name="id"
                   <?php
                   if($enteredId){
                       echo"value=$enteredId";
                   }
                   ?>
                   ><br/><br/>
            <font size="4"><b>Phone</b></font><br />
            <input type="text" size="40" name="phone"
                   <?php
                   if($enteredPhone){
                       echo"value=$enteredPhone";
                   }
                   ?>
                   ><br/><br/>
            <font size="4"><b>E-mail address</b></font><br />
            <input type="text" size="40" name="email"
                   <?php
                   if($enteredEmail){
                       echo"value=$enteredEmail";
                   }
                   ?>
                   ><br/><br/>
            <font size="4"><b>Password*</b></font><br />
            <input type="password" size="40" name="password1"><br/><br/>
            <font size="4"><b>Re-enter Password*</b></font><br />
            <input type="password" size="40" name="password2">
            <br/><br/>
            <input type="submit" value="Create">
        </form>
        <form name="cancel" action="stlogin.php" method="POST">
            <input type="submit" value="Cancel">
        </form>
        
        
        
    </body>
</html>
