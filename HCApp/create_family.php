<!DOCTYPE HTML>
<?php
include_once 'functions.php';
include_once 'dbfunctions.php';
verifyuser(array("Officer"));
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Add A Family</title>
    </head>
    <body>
        <?php
        //Stores information from a previous post (if any) to 
        //associative array $formInfo
        $formInfo = getPostInfo();

        //Cleans all submitted information
        foreach($formInfo as $value)
            $value = protectInjection($value);
        
        if(isset($_POST['button']))
            {
                //If the previous action was submit, creates a family acount
                if($_POST['button']=="Submit")
                    submitCreateFamily($formInfo);

                //If the previous action was cancel, goes back to family page
                if($_POST['button']=="Cancel")
                    header("location:families.php");
            }
        ?>
        
        
        
        <h1>Add A Family</h1>
        <form id="form" name="createfamily" action="create_family.php" method="POST">
            Name*<br />
                <input type="text" size="40" name="famName" 
                value=
                    <?php echo isset($_POST['famName'])?$formInfo['famName']:"\"\"";?> 
                ><br /><br />
            Number of lunches<br />
                <input type="number" size="40" name="numLunch" value=
                    <?php echo isset($_POST['numLunch'])?$formInfo['numLunch']:"\"\"";?>
                ><br/><br/>
            Address*<br />
                <input type="text" size="40" name="address" value=
                    <?php echo isset($_POST['address'])?$formInfo['address']:"\"\"";?>
                ><br/><br/>
            City*<br />
                <input type="text" size="40" name="city" value=
                    <?php echo isset($_POST['city'])?$formInfo['city']:"\"\"";?>
                ><br/><br/>
            Phone Number<br />
                <input type="text" size="40" name="famPhone" value=
                    <?php echo isset($_POST['famPhone'])?$formInfo['famPhone']:"\"\"";?>
                ><br/><br/>
            Notes<br />
                <input type="text" size="40" name="notes" value=
                    <?php echo isset($_POST['notes'])?$formInfo['notes']:"\"\"";?>
                ><br/><br/>
            <p id="note"> *Required Field </p>
            <input type="submit" name="button" value="Submit" >
            <input type="submit" name="button" value="Cancel" >
        </form>
        
        
        <?php
        function getPostInfo()
        {
            $formInfo['famName'] = assignPostData('famName');
            $formInfo['numLunch'] = assignPostData('numLunch');
            $formInfo['address'] = assignPostData('address');
            $formInfo['city'] = assignPostData('city');
            $formInfo['famPhone']    = assignPostData('famPhone');
            $formInfo['notes'] = assignPostData('notes');

            return $formInfo;
        }
        
        function submitCreateFamily($formInfo)
        {
            //Ensures information entered properly
            $formValid = chkCrtAcctVldtyFamily($formInfo);

            if(chkErr($formValid))
            {
                //Creates account and verifies creation was successful
                $acctMade = makeFamily($formInfo);
                if(chkErr($acctMade))
                {
                    header("location:families.php");
                }
            }
        }
        
        function chkCrtAcctVldtyFamily($formInfo)
        {
            if(!$formInfo['famName']||!$formInfo['address']||!$formInfo['city'])
            {
                $isvalid['message'] = "Please fill Family, Address, and City.";
                $isvalid['flag'] = false;
                return $isvalid;
            }
            elseif(existsInDatabase2("families","Address","'{$formInfo['address']}'","City","'{$formInfo['city']}'"))
            {
                $isvalid['message'] = "This address and city have already been registered.";
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
    </body>
</html>