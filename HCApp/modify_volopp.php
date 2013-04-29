<!DOCTYPE HTML>
<?php
include_once 'functions.php';
include_once 'dbfunctions.php';
include_once 'displayfunctions.php';
verifyuser(array("Officer"));
if(!isset($_POST['oppnum']))
{
    header("location:index.php");
}
$oppnum=$_POST['oppnum'];
$volopp=getVolunteerOppotunityInformation($oppnum);

$date=$volopp["Date"];
$oppname=$volopp["Oppname"];
$description=$volopp["Description"];
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Modify <?php echo $oppname;?></title>
        <meta name="author" content="BCCS">
        <link rel="stylesheet" type="text/css" href="reset.css">
        <link rel="stylesheet" type="text/css" href="hcstylesheet.css">
    </head>
    <body>
        <div id="page-container">
            <?php officermenu(); ?>        
            <div id="content">
                <div class="offset">
                    <h1><?php echo $date;?></h1>
                    <br/>
                    <?php
                    //Stores information from a previous post (if any) to 
                    //associative array $formInfo
                    $formInfo = getPostInfo();

                    //Cleans all submitted information
                    foreach($formInfo as $value)
                        $value = protectInjection($value);

                    if(isset($_POST['button'])&&$_POST['button']=="Apply")
                    {
                        //If the previous action was submit, verify applying
                        verifyApply($formInfo,$oppnum);
                    }
                    ?>
                    <form id="form" name="applytomodify" action="modify_volopp.php" method="POST">
                        Name<br />
                            <input type="text" size="40" name="new_oppname" value="<?php echo isset($oppname)?$oppname:"";?>"><br />
                        Description<br />
                            <textarea name='new_description' rows='15' cols='40'><?php echo isset($description)?$description:"";?></textarea><br />
                        <input type="hidden" name="oppnum" value=<?php echo $oppnum;?>>
                        <input type="submit" name="button" value="Apply">            
                    </form>
                    <form name="cancel" action="officer_volopp_info.php" method="POST">
                        <input type="hidden" name="oppnum" value=<?php echo $oppnum;?>>
                        <input type="submit" value="Cancel">
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
        $formInfo['oppname'] = assignPostData('new_oppname');
        $formInfo['description'] = assignPostData('new_description');
        
        return $formInfo;
    }
    
    function verifyApply($formInfo,$oppnum)
    {
        modifyVolunteerOpportunity($formInfo,$oppnum);
        $_SESSION['oppnum']=$oppnum;
        header("location:officer_volopp_info.php");
    }
?>