<html>
<head> 
<title>Families Information</title> 
</head> 
<body>
    <?php
        include_once 'functions.php';
        include_once 'dbfunctions.php';
        verifyuser(array("Officer"));

        $families = getFamilies();
    ?>
    <h1>The current families</h1>

    <form name="add" action="create_family.php" method="POST">
        <input type="submit" value="Add Family">
    </form>
    
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Number of Lunches</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Notes</th>
            <th></th>
        </tr>
        <?php 
        foreach ($families as $family) 
        {
            $l=isset($family['NumLunch'])?$family['NumLunch']:"&nbsp;";
            $p=isset($family['Famphone'])?$family['Famphone']:"&nbsp;";
            $n=isset($family['Notes'])?$family['Notes']:"&nbsp;";
            echo "<tr>";
            echo "<td>".$family['Famname']."</td>";
            echo "<td>$l</td>";
            echo "<td>".$family['Address'].", ".$family['City']."</td>";
            echo "<td>$p</td>";
            echo "<td>$n</td>";
            ?>
            <td>
                <form name="modify" action="modify_family.php" method="POST">
                    <input type="hidden" name="origAddress" value="<?php echo $family['Address'];?>">
                    <input type="hidden" name="origCity" value="<?php echo $family['City'];?>">
                    <input type="submit" value="Modify">
                </form>
            </td>
            <?php
            echo "</tr>";
        }
        ?>
    </table>
    
    <form name="home" action="officerhome.php" method="POST">
        <input type="submit" value="Back to Home Page">
    </form>

</body>
</html>
