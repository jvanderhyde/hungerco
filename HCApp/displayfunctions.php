<?php
include_once 'functions.php';
include_once 'dbfunctions.php';

function mainmenu($title)
{
    echo "<div id ='main-nav'>
                <h1>$title</h1>
                <ul class='nav'>
                    <li class='hor'><a href='index.php'>Home</a></li>
                    <li class='hor'><a href='about.php'>About Us</a></li>
                    <li class='hor'><a href='contactus.php'>Contact</a></li>
                </ul>
            </div>";
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
