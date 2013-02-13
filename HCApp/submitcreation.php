<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $a = new StudentAccountCreation();
        $a->createOrBack();
            
        //Class and functions
        class StudentAccountCreation{
            private $fName,$minit,$lName,$id,$phone,$email,$password1,$password2,$message;
            function __construct(){
                $this->fName=$_POST['fName'];
                $this->minit=$_POST['minit'];
                $this->lName=$_POST['lName'];
                $this->id=$_POST['id'];
                $this->phone=$_POST['phone'];
                $this->email=$_POST['email'];
                $this->password1=$_POST['password1'];
                $this->password2=$_POST['password2'];
            }
            
            function protectInjection(){
                $this->fName=$_POST['fName'];
                $this->minit=$_POST['minit'];
                $this->lName=$_POST['lName'];
                $this->id=$_POST['id'];
                $this->phone=$_POST['phone'];
                $this->email=$_POST['email'];
                $this->password1=$_POST['password1'];
                $this->password2=$_POST['password2'];
            }
            
            function createOrBack(){
                if($this->checkValidity()){
                    $this->makeAccount();
                }
                else{
                    $this->backToEnter();
                }
            }
            
            function checkValidity(){
                if(!$this->fName||!$this->lName||!$this->id||!$this->password1||!$this->password2){
                    $this->message = "<h1>Please fill all blank spaces required</h1>";
                    return false;
                }
                elseif($this->idExistInDatabase()){
                    $this->message = "<h1>This student ID has already been registered.</h1>";
                    return false;
                }
                elseif(strcmp($this->password1,$this->password2)!=0){
                    $this->message = "<h1>Your passwords do not equal.</h1>";
                    return false;
                }
                else{
                    return true;
                }
            }
            
            function idExistInDatabase(){
                $username="hungerco";
                $password="intensiveness";
                $database="HUNGERCO";
                mysql_connect('localhost:3306',$username,$password);
                @mysql_select_db($database) or die( "Unable to select database");
                $query="SELECT * FROM students WHERE Id=$this->id";
                $result=mysql_query($query);
                $num=mysql_numrows($result);
                mysql_close();
                if($num==1){
                    return true;
                }
                else{
                    return false;
                }
            }
            function makeAccount(){
                if(!$this->minit){
                    $this->minit = 'null';
                }
                if(!$this->phone){
                    $this->phone = 'null';
                }
                if(!$this->email){
                    $this->email = 'null';
                }
                $username="hungerco";
                $password="intensiveness";
                $database="HUNGERCO";
                mysql_connect('localhost:3306',$username,$password);
                @mysql_select_db($database) or die( "Unable to select database");
                $query="INSERT INTO students VALUES ('$this->fName',
                    $this->minit,'$this->lName','$this->id','$this->password1',0,$this->phone,$this->email)";
                if(!mysql_query($query)){
                    $this->message = "<h1>Creation error!</h1>";
                    $this->backToEnter();
                }
                else{
                    echo"<h1>Your acount creation is completed.</h1>
                         <form name=\"finishcreation\" action=\"stlogin.php\" method=\"POST\">
                             <input type=\"submit\" value=\"Next\">
                         </form>";
                }
                mysql_close();
            }
            
            function backToEnter(){//nullかどうかのifも
                echo $this->message;
                echo"<form name=\"failcreation\" action=\"createaccount.php\" method=\"POST\">
                        <input type=\"hidden\" name=\"enteredNameF\" value=$this->fName>
                        <input type=\"hidden\" name=\"enteredNameM\" value=$this->minit>
                        <input type=\"hidden\" name=\"enteredNameL\" value=$this->lName>
                        <input type=\"hidden\" name=\"enteredId\" value=$this->id>
                        <input type=\"hidden\" name=\"enteredPhone\" value=$this->phone>
                        <input type=\"hidden\" name=\"enteredEmail\" value=$this->email>
                        <input type=\"submit\" value=\"Back\">
                    </form>";
            }
        }
        
        ?>
    </body>
</html>
