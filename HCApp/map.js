var rendererOptions =
{
draggable: true,
preserveViewport:false
};
var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);

var directionsService = new google.maps.DirectionsService();
var map;

var start = "1020 N 2nd Street, Atchison";
var middlePoints=new Array();
for(var i=0; i<middleAddresses.length ; i++)
{
    middlePoints.push({location: middleAddresses[i],stopover:true });
}

function initialize()
{
     directionDisplay = new google.maps.DirectionsRenderer();
        var latlng = new google.maps.LatLng(39.568448,-95.121946);
        var opts = {
            zoom: 15,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), opts);
        directionsDisplay.setMap(map);
        google.maps.event.addListener(directionsDisplay, 'directions_changed', function()
        {
        });

        calcRoute();
    
}
function calcRoute()
{
    var request ={
                origin: start,
                destination: end,
                travelMode: google.maps.DirectionsTravelMode.DRIVING,
                unitSystem: google.maps.DirectionsUnitSystem.IMPERIAL,
                optimizeWaypoints: false,
                avoidHighways: false,
                avoidTolls: false 
                };
                
    request['waypoints']= middlePoints;
    directionsService.route(request, function(response, status) 
	{
		if (status == google.maps.DirectionsStatus.OK) 
		{
		directionsDisplay.setDirections(response);
		}
	});
}

window.onload=initialize;