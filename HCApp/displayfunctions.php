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
                <li><a class='nav-about' href='aboutus.php'>About Us</a></li>
                <li><a class='nav-contact' href='contactus.php'>Contact</a></li>
            </ul>
        </nav>
        </header>";
}
function footer()
{
    echo"<div id=\"footer\">Copyright &copy; Benedictine College Computer Science Department</div>";
}

function studmenu($id)
{
    $name = getStudName($id);
    echo "<header>
            <img src='hclogo.jpg'>
            <div id='welcome'>Welcome $name</div>
            <nav>
                <ul>
                    <li class='nav-home'><a href='stinfo.php'>Home</a></li>
                    <li class='nav-vol'><a href='volopp.php'>Volunteer</a></li>
                    <li><a href='logout.php'>Logout</a></li>
                </ul>
            </nav>
        </header>";
}

function volmenu()
{
    echo "<header>
            <nav>
                <ul>
                    <li class='nav-home'><a href='stinfo.php'>Home</a></li>
                    <li class='nav-vol'><a href='volopp.php'>Volunteer</a></li>
                    <li><a href='logout.php'>Logout</a></li>
                </ul>
            </nav>
        </header>
        <br />";
}

function officermenu()
{
    echo "
        <header>
        <img src='hclogo.jpg'>
        <nav>
            <ul>
                <li><a class='nav-home' href='officerhome.php'>Home</a></li>
                <li><a class='nav-acct' href='staccounts.php'>Student Accounts</a></li>
                <li><a class='nav-skip' href='skippers.php'>Skip-a-Meal Info</a></li>
                <li><a class='nav-vol' href='officer_volopps.php'>Volunteers</a></li>
                <li><a class='nav-route' href='families.php'>Routes</a></li>
                <li><a class='nav-map' href='routes.php'>Maps</a></li>
                <li><a href='logout.php'>Logout</a></li>
            </ul>
        </nav>
        </header>";
}

?>
