<html>
   <head>
      <title>Add/Insert a WayPoint Route</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>
      <script src="testjs.js" type="text/javascript" charset="utf-8"></script>
   </head>
 <body onload="getMap();">
      <div id='myMap' style="position:relative; width:400px; height:400px;"></div>
      <div>
         <input type="button" value="InsertWaypoint" onclick="createDirections();" />
      </div>
      <form name="home" action="officerhome.php" method="POST">
            <input type="submit" value="Back to Home Page">
        </form>
   </body>
</html>
