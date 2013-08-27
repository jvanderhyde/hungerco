var map = null;
      var directionsManager;
      var directionsErrorEventObj;
      var directionsUpdatedEventObj; 
       
      function getMap()
      {
          map = new Microsoft.Maps.Map(document.getElementById('myMap'), {credentials: 'AlcUmuxDP1RO53A3d6Dkh3RTUIq6PhsUVNs4Tc_O8rR-9nBKIJPx93quglChDaEB'});
      }
      
      function createDirectionsManager()
      {
          var displayMessage;
          if (!directionsManager) 
          {
              directionsManager = new Microsoft.Maps.Directions.DirectionsManager(map);
              displayMessage = 'Directions Module loaded\n';
              displayMessage += 'Directions Manager loaded';
          }
          alert(displayMessage);
          directionsManager.resetDirections();
          directionsErrorEventObj = Microsoft.Maps.Events.addHandler(directionsManager, 'directionsError', function(arg) { alert(arg.message) });
          directionsUpdatedEventObj = Microsoft.Maps.Events.addHandler(directionsManager, 'directionsUpdated', function() { alert('Directions updated') });
      }
      
      function createDrivingRoute()
      {
        if (!directionsManager) { createDirectionsManager(); }
        directionsManager.resetDirections();
        // Set Route Mode to driving 
        directionsManager.setRequestOptions({ routeMode: Microsoft.Maps.Directions.RouteMode.driving });
        var seattleWaypoint = new Microsoft.Maps.Directions.Waypoint({ address: '1017 N. 10th St. Atchison, KS' });
        directionsManager.addWaypoint(seattleWaypoint);
        var tacomaWaypoint = new Microsoft.Maps.Directions.Waypoint({ address: '1125 L St. Atchison, KS' });
        directionsManager.addWaypoint(tacomaWaypoint);
        alert('Calculating directions...');
        directionsManager.calculateDirections();
      }

      function createDirections() {
        if (!directionsManager)
        {
          Microsoft.Maps.loadModule('Microsoft.Maps.Directions', { callback: createDrivingRoute });
        }
        else
        {
          createDrivingRoute();
        }
       }
