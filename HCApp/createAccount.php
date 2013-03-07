<!DOCTYPE HTML>
<html>
    <head>
        <title>Create an Account</title>
    </head>
    <body>
        <?php
            assignPostData('enteredNameF');
            assignPostData('enteredNameM');
            assignPostData('enteredNameL');
            assignPostData('enteredPhone');
            assignPostData('enteredId');
            assignPostData('enteredEmail');
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
                               value=<?php echo $enteredNameF;?> required>
                    </td>
                </tr>
                <tr>
                    <td>Middle Initial:</td>
                    <td>
                        <input type="text" size="1" maxlength="1" 
                               name="minit" value=<?php echo $enteredNameM;?>>
                    </td>
                </tr>
                <tr>
                    <td>Last name*:</td>
                    <td>
                        <input type="text" size="20" name="lName" 
                               value=<?php echo $enteredNameL;?> required>
                    </td>
                </tr>
            </table><br />
            <font size="4"><b>Student ID*</b></font><br />
            <input type="text" size="40" name="id" value=<?php echo $enteredId;?> required><br/><br/>
            <font size="4"><b>Phone</b></font><br />
            <input type="text" size="40" name="phone" value=<?php echo $enteredPhone;?> ><br/><br/>
            <font size="4"><b>E-mail address</b></font><br />
            <input type="text" size="40" name="email" value=<?php echo $enteredEmail;?> ><br/><br/>
            <font size="4"><b>Password*</b></font><br />
            <input type="password" size="40" name="password1" required><br/><br/>
            <font size="4"><b>Re-enter Password*</b></font><br />
            <input type="password" size="40" name="password2" required>
            <br/><br/>
            <input type="submit" value="Create">
        </form>
        
        <form name="cancel" action="stlogin.php" method="POST">
            <input type="submit" value="Cancel">
        </form>
    </body>
</html>
