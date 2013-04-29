var m　= null;
var map;
var mapCredential = "AlcUmuxDP1RO53A3d6Dkh3RTUIq6PhsUVNs4Tc_O8rR-9nBKIJPx93quglChDaEB";
var directionsManager;
var newwaypoint;




function initialize()
{
    getMap();
}

function getMap() 
{   
    map = new Microsoft.Maps.Map(document.getElementById("map_canvas"),{
           credentials: mapCredential,
           center: new Microsoft.Maps.Location(39.568448,-95.121946),
           mapTypeId: Microsoft.Maps.MapTypeId.road,
           zoom: 15
       });
    createDirections();
}

function createDirectionsManager()
{
    if (!directionsManager) 
    {
        directionsManager = new Microsoft.Maps.Directions.DirectionsManager(map);
    }
    directionsManager.resetDirections();
}

function createDrivingRoute()
{
    if (!directionsManager) { createDirectionsManager(); }
    directionsManager.resetDirections();
    // Set Route Mode to driving 
    directionsManager.setRequestOptions({ routeMode: Microsoft.Maps.Directions.RouteMode.driving });
    newwaypoint = new Microsoft.Maps.Directions.Waypoint({ location: new Microsoft.Maps.Location(39.573577, -95.115190) });
    directionsManager.addWaypoint(newwaypoint);
    
    for(var i=0; i<middlePoints.length; i++)
    {
        newwaypoint = new Microsoft.Maps.Directions.Waypoint({ address: middlePoints[i] });
        directionsManager.addWaypoint(newwaypoint);
    }
    directionsManager.calculateDirections();
}

function createDirections() 
{
    if (!directionsManager)
    {
        Microsoft.Maps.loadModule('Microsoft.Maps.Directions', { callback: createDrivingRoute });
    }
    else
    {
        createDrivingRoute();
    }
}

window.onload=initialize;