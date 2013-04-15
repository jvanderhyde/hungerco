<!DOCTYPE HTML>
<?php
include_once 'functions.php';
include_once 'dbfunctions.php';
verifyuser(array("Officer"));
if(!isset($_POST['date']))
{
    header("location:index.php");
}
$date=$_POST['date'];
$year=date('Y',strtotime($date));
$month=date('m',strtotime($date));
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Create Volunteer Opportunity</title>
    </head>
    <body>
        <h1><?php echo $date;?></h1>
        <?php
        //Stores information from a previous post (if any) to 
        //associative array $formInfo
        $formInfo = getPostInfo();

        //Cleans all submitted information
        foreach($formInfo as $value)
            $value = protectInjection($value);

        if(isset($_POST['button'])&&$_POST['button']=="Create")
        {
            //If the previous action was submit, verify applying
            verifyCreate($formInfo,$date);
        }
        ?>
        <form id="form" name="createvolopp" action="create_volopp.php" method="POST">
            Name<br />
                <input type="text" size="40" maxlength="15" name="new_oppname"><br />
            Description<br />
                <textarea name='new_description' rows='15' cols='40'></textarea><br />
            <input type="hidden" name="date" value=<?php echo $date;?>>
            <input type="submit" name="button" value="Create">            
        </form>
        <form name="cancel" action="officer_volopps.php" method="POST">
            <input type="hidden" name="year" value=<?php echo $year;?>>
            <input type="hidden" name="month" value=<?php echo $month;?>>
            <input type="submit" value="Cancel">
        </form>
    </body>
</html>
<?php
    function getPostInfo()
    {
        $formInfo['oppname'] = assignPostData('new_oppname');
        $formInfo['description'] = assignPostData('new_description');
        
        return $formInfo;
    }
    
    function verifyCreate($formInfo,$date)
    {
        makeVolunteerOpportunity($formInfo,$date);
        $_SESSION['date']=$date;
        header("location:officer_volopps.php");
    }
?>