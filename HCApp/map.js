var rendererOptions =
{
draggable: true,
preserveViewport:false
};
var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);

var directionsService = new google.maps.DirectionsService();
var map;



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
    var start = "1020 N 2nd Street, Atchison";
    var end = "800 L Street, Atchison";
    var request ={
        origin: start,
        destination: end,
        waypoints:[
	{
	location: "1125 L St., Atchison",
	stopover:true
	}, 
	{
	location: "513 N. 10th, Atchison",
	stopover:true
	}, 
	{
	location: "1120 Laramie, Atchison",
	stopover:true
	}
	],
        travelMode: google.maps.DirectionsTravelMode.DRIVING,
	unitSystem: google.maps.DirectionsUnitSystem.IMPERIAL,
	optimizeWaypoints: true,
	avoidHighways: false,
	avoidTolls: false 
        };
  
    
    directionsService.route(request, function(response, status) 
	{
		if (status == google.maps.DirectionsStatus.OK) 
		{
		directionsDisplay.setDirections(response);
		}
	});
}



