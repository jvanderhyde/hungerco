<?php
 session_start();
 if(!session_is_registered("studentid")){
     header("location:stlogin.php");
 }
 else if(!isset($_POST['year'])){
     header("location:stinfo.php");
 }
 ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $year=isset($_POST['year'])?$_POST['year']:"";
        $month=isset($_POST['month'])?$_POST['month']:"";
        makeLinks($year, $month);
        
        getConnectionWithDatabase();
        updateVolunteerValueOrNot();
        $resource = getVolunteerOppotunity($year, $month);
        $joinedopp=getJoinedOpportunityNumber();
        mysql_close();
        
        require_once("CalendarClass.php");
        $obj_cdr = &  new CalendarClass();
        if(isset($resource)){
            $obj_cdr->setVolunteerOpportunity($joinedopp, $resource,"./volopp.php");
        }
        echo $obj_cdr->getCalendar($year, $month);
        ?>

        <form name="back" action="stinfo.php" method="POST">
            <input type="submit" value="Back">
        </form>
        <?php
        function makeLinks($year, $month){
            ?>
            <a href="#" onclick="document.previousmonth.submit();return false;" > ＜Previous month</a>
            <a href="#" onclick="document.thismonth.submit();return false;" > This month</a>
            <a href="#" onclick="document.nextmonth.submit();return false;" > Next month＞</a>
            
            <form name="previousmonth" action="./volopp.php" method="POST">
                <input type="hidden" name="year" value=<?php echo $month==1?$year-1:$year;?>>
                <input type="hidden" name="month" value=<?php echo $month==1?12:$month-1;?>>
            </form>
            <form name="thismonth" action="./volopp.php" method="POST">
                <input type="hidden" name="year" value=<?php echo date("Y");?>>
                <input type="hidden" name="month" value=<?php echo date("m");?>>
            </form>
            <form name="nextmonth" action="./volopp.php" method="POST">
                <input type="hidden" name="year" value=<?php echo $month==12?$year+1:$year;?>>
                <input type="hidden" name="month" value=<?php echo $month==12?1:$month+1;?>>
            </form><?php
        }
        
        function getConnectionWithDatabase(){
            mysql_connect('localhost:3306', "hungerco", "intensiveness")
                    or die("cannot connect");
            mysql_select_db("HUNGERCO")or die("cannot select DB");
        }
        
        function updateVolunteerValueOrNot(){
            if(isset($_POST['oppnum'])){
                $id=$_SESSION["studentid"];
                $voppnum=$_POST['oppnum'];
                $query="INSERT INTO volunteers VALUES ('$id', $voppnum)";
                mysql_query($query);
            }
        }
        
        function getVolunteerOppotunity($year, $month){
            $ym=sprintf("%04d%02d", $year, $month);
            $sql="SELECT * FROM vol_opps WHERE DATE_FORMAT(Date,'%Y%m')=$ym";
            return mysql_query($sql);
        }
        
        function getJoinedOpportunityNumber(){
            $id=$_SESSION["studentid"];
            $sql="SELECT * FROM volunteers WHERE Volid='$id'";
            $result=mysql_query($sql);
            $numResult=mysql_numrows($result);
            $oppnumarray=array();
            for($i=0; $i<$numResult; $i++){
                $oppnum=mysql_result($result,$i,"Voppnum");
                array_push($oppnumarray,$oppnum);
            }
            return $oppnumarray;
        }
        ?>
    </body>
</html>