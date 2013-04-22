<?php
include_once 'functions.php';
include_once 'dbfunctions.php';

function mainmenu()
{
    echo "
        <header>
        <img src='hclogo.jpg'>
        <nav>
            <ul>
                <li><a class='nav-home' href='index.php'>Home</a></li>
                <li><a class='nav-about' href='about.php'>About Us</a></li>
                <li><a class='nav-contact' href='contactus.php'>Contact</a></li>
            </ul>
        </nav>
        </header>
        <br />";
}
function footer()
{
    echo"<div id=\"footer\">Copyright &copy; Benedictine College Computer Science Department</div>";
}

function studmenu($title)
{
    echo "<h1>$title</h1>
            <div id ='main-nav'>
                <ul class='nav'>
                    <li class='hor'><a href='stinfo.php'>Home</a></li>
                    <li class='hor'><a href='volopp.php'>Volunteer</a></li>
                    <li class='hor'><a href='logout.php'>Logout</a></li>
                </ul>
            </div>";
}

?>
