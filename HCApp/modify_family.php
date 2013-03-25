<!DOCTYPE HTML>
<?php
include_once 'functions.php';
include_once 'dbfunctions.php';
verifyuser(array("Officer"));
if(!isset($_POST['origAddress']))
    header("location:families.php");
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Modify A Family</title>
    </head>
    <body>
        <?php
        //Stores information from a previous post (if any) to 
        //associative array $formInfo
        $formInfo = getPostInfo();
        
        //Cleans all submitted information
        foreach($formInfo as $value)
            $value = protectInjection($value);
        
        //Get original information
        $origInfo = getFamilyInfo($_POST['origAddress'],$_POST['origCity']);

        
        if(isset($_POST['button']))
            {
                //If the previous action was submit, creates a family acount
                if($_POST['button']=="Submit")
                    submitModifyFamily($formInfo,$origInfo);

                //If the previous action was cancel, goes back to family page
                if($_POST['button']=="Cancel")
                    header("location:families.php");
            }
        ?>
        
        
        
        <h1>Modify A Family</h1>
        <form id="form" name="modifyfamily" action="modify_family.php" method="POST">
            Name*<br />
                <?php echo $origInfo['Famname'];?>
                <input type="text" size="40" name="famName" value=
                       "<?php echo isset($_POST['button'])?$formInfo['famName']:$origInfo['Famname'];?>"
                    ><br /><br />
            Number of lunches<br />
                <?php echo $origInfo['NumLunch'];?>
                <input type="number" size="40" name="numLunch" value=
                    <?php echo isset($_POST['button'])?$formInfo['numLunch']:$origInfo['NumLunch'];?>
                ><br/><br/>
            Address*<br />
                <?php echo $origInfo['Address'];?>
                <input type="text" size="40" name="address" value=
                       "<?php echo isset($_POST['button'])?$formInfo['address']:$origInfo['Address'];?>"
                    ><br/><br/>
            City*<br />
                <?php echo $origInfo['City'];?>
                <input type="text" size="40" name="city" value=
                       "<?php echo isset($_POST['button'])?$formInfo['city']:$origInfo['City'];?>"
                       ><br/><br/>
            Phone Number<br />
                <?php echo $origInfo['Famphone'];?>
                <input type="text" size="40" name="famPhone" value=
                       "<?php echo isset($_POST['button'])?$formInfo['famPhone']:$origInfo['Famphone'];?>"
                       ><br/><br/>
            Notes<br />
                <?php echo $origInfo['Notes'];?>
                <input type="text" size="40" name="notes" value=
                       "<?php echo isset($_POST['button'])?$formInfo['notes']:$origInfo['Notes'];?>"
                       ><br/><br/>
            <p id="note"> *Required Field </p>
            <input type="hidden" name="origAddress" value="<?php echo $_POST['origAddress'];?>">
            <input type="hidden" name="origCity" value="<?php echo $_POST['origCity'];?>">
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
        
        function submitModifyFamily($formInfo,$origInfo)
        {
            //Ensures information entered properly
            $formValid = chkModAcctVldtyFamily($formInfo,$origInfo);

            if(chkErr($formValid))
            {
                //Creates account and verifies creation was successful
                $acctMade = modifyFamily($formInfo,$origInfo);
                if(chkErr($acctMade))
                {
                    header("location:families.php");
                }
            }
        }
        
        function chkModAcctVldtyFamily($formInfo, $origInfo)
        {
            if(!$formInfo['famName']||!$formInfo['address']||!$formInfo['city'])
            {
                $isvalid['message'] = "Please fill Family, Address, and City.";
                $isvalid['flag'] = false;
                return $isvalid;
            }
            elseif(checkAddressChange($formInfo,$origInfo)
                    &&
                   existsInDatabase2("families","Address","'{$formInfo['address']}'","City","'{$formInfo['city']}'"))
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
        
        function checkAddressChange($formInfo,$origInfo)
        {
            return ($formInfo['address']!=$origInfo['Address']||$formInfo['city']!=$origInfo['City']);
        }
        ?>
    </body>
</html>