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
            private $fName,$minit,$lName,$id,$phone,$email,$password1,
                    $password2,$message,$usernameD,$passwordD,$database;
            function __construct(){
                $this->fName=$_POST['fName'];
                $this->minit=$_POST['minit'];
                $this->lName=$_POST['lName'];
                $this->id=$_POST['id'];
                $this->phone=$_POST['phone'];
                $this->email=$_POST['email'];
                $this->password1=$_POST['password1'];
                $this->password2=$_POST['password2'];
                $this->usernameD="hungerco";
                $this->passwordD="intensiveness";
                $this->database="HUNGERCO";
                mysql_connect('localhost:3306',$this->usernameD,$this->passwordD);
                @mysql_select_db($this->database) or die( "Unable to select database");
            }
            
            function protectInjection(){
                $this->fName=stripslashes($this->fName);
                $this->minit=stripslashes($this->minit);
                $this->lName=stripslashes($this->lName);
                $this->id=stripslashes($this->id);
                $this->phone=stripslashes($this->phone);
                $this->email=stripslashes($this->email);
                $this->password1=stripslashes($this->password1);
                $this->password2=stripslashes($this->password2);
                $this->fName=mysql_real_escape_string($this->fName);
                $this->minit=mysql_real_escape_string($this->minit);
                $this->lName=mysql_real_escape_string($this->lName);
                $this->id=mysql_real_escape_string($this->id);
                $this->phone=mysql_real_escape_string($this->phone);
                $this->email=mysql_real_escape_string($this->email);
                $this->password1=mysql_real_escape_string($this->password1);
                $this->password2=mysql_real_escape_string($this->password2);
            }
            
            function createOrBack(){
                $this->protectInjection();
                if($this->checkValidity()){
                    $this->makeAccount();
                }
                else{
                    $this->backToEnter();
                }
                mysql_close();
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
                $query="SELECT * FROM students WHERE Id=$this->id";
                $result=mysql_query($query);
                $num=mysql_numrows($result);
                
                if($num==1){
                    return true;
                }
                else{
                    return false;
                }
            }
            function makeAccount(){
                $minit2="";
                $phone2="";
                $email2="";
                if($this->minit){
                    $minit2 = $this->minit;
                }
                else{
                    $minit2 = 'null';
                }
                if($this->phone){
                    $phone2 = $this->phone;
                }
                else{
                    $phone2 = 'null';
                }
                if($this->email){
                    $email2 = $this->email;
                }
                else{
                    $email2 = 'null';
                }
                
                $query="INSERT INTO students VALUES ('$this->fName',
                    $minit2,'$this->lName','$this->id','$this->password1',0,$phone2,$email2)";
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
            }
            
            function backToEnter(){
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
