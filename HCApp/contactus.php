<!DOCTYPE HTML>
<html>
    <head>
        <title>Contact Hunger Coalition</title>
    </head>
    <body>
        <h1>Contact Us</h1>
        <form id="form" name="contactus" action="submitcontact.php" method="POST">
            Name<br />
                <input type="text" size="40" name="name"><br/>
            Address<br />
                <input type="text" size="40" name="address"><br/>
            Phone<br />
                <input type="text" size="40" name="phone"><br/>
            Message<br />
                <textarea name='descrip' rows='15' cols='40'>
                Type message here.
                </textarea>
            <br/><br/>
            <input type="submit" value="Submit">
        </form>
        <form name="cancel" action="index.php" method="POST">
            <input type="submit" value="Cancel">
        </form>
    </body>
</html>
