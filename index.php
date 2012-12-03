<html>   
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script type="text/javascript" src="./js/jquery.ui.map.full.min.js"></script>
        <script type="text/javascript" src="./js/jquery.ui.map.extensions.js"></script>


        <link type="text/css" rel="stylesheet" href="./css/screen.css"></link>
        <script type="text/javascript" >
            (function($) {
    
                $(window).load(function(){
        
                    //Gonna turn this into a class.  
                    var specificLocation; //= new google.maps.LatLng('39.606772','-84.139151');
                    var timeout; 
                    var map;
                    var initialzoom = 12;
                    var minzoom = 5;
                    
                    
                    
                        
                    function addLocations() {
                        var bounds = map.get('map').getBounds();
                        
                        getLocations(bounds);
                        
                        dropPin('1',new google.maps.LatLng('39.601772','-84.133151'),'Store 1',true);
                        dropPin('2',new google.maps.LatLng('39.602772','-84.133151'),'Store 2',true);
                        dropPin('3',new google.maps.LatLng('39.603772','-84.133151'),'Store 3',true);
                        dropPin('4',new google.maps.LatLng('39.604772','-84.133151'),'Store 4',true);
                        dropPin('5',new google.maps.LatLng('44.754772','-78.083151'),'Store 4',true);
                    }
                    
                    
                    function getLocations(bounds)
                    {
                        var ne = bounds.getNorthEast();
                        var sw = bounds.getSouthWest();
                        console.log(ne.lat());
                        console.log(ne.lng());
                        console.log(sw.lat());
                        console.log(sw.lng());
                        console.log(map);
                        
                        //make a randomizer here
                    }
                    
                    function dropPin(id, latlong, content, clickable, icon) {
                        mk = map.get('markers')[id];
                        if (id == 0)
                        {
                          if (mk) 
                          {
                           console.log("marker deleted");
                           mk.setMap(null);        
                          }
                        } else {
                            
                            if (mk) 
                            {
                                console.log("marker not added");
                                return;
                            }
                        }
                        
                        map.addMarker({'id': id, 'position': latlong, 'icon': icon, 'clickable' : clickable}).click(function(){map.openInfoWindow({ 'content': content }, this)});
                    }
                    
                    function setLocationAndCenter(location) {
                          map.get('map').setCenter(location);
                          dropPin('0',location,'Your Location',false,'./images/current-location.png' );
                    }
                    
                    function setCurrentLocation(defaultLocation, callback)
                    {
                         map.getCurrentPosition(function(position, status) {
                                if (status == "OK") {
                                    setLocationAndCenter(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
                                } 
                                else if (defaultLocation) 
                                {
                                    setLocationAndCenter(defaultLocation);
                                }
                                if (callback) {
                                    callback(status)
                                }
                           });   
                    }
                    
                    
                    function setZoom(z)
                    {
                         map.get('map').setZoom(z); 
                    }
                    
                    function addBoundsChangedEvent() {
                        google.maps.event.addListener(map.get('map'), 'bounds_changed', function() {
                                    clearTimeout(timeout);
                                    timeout = setTimeout(function(){addLocations();}, 750);
                                });
                    }

                    $('#map_canvas').gmap({'zoom': initialzoom, 'disableDefaultUI':true, 'minZoom': minzoom, 'callback': function() {
						
                            map = this;
                            
                            if (!specificLocation)
                            {
                                setCurrentLocation(new google.maps.LatLng('39.500000','-98.350000'), function(status){
                                   if (status != 'OK') 
                                   {
                                       setZoom(minzoom);  
                                   }
                                   addBoundsChangedEvent();
                                });
                            }
                            else 
                            {
                                setLocationAndCenter(specificLocation);
                                addBoundsChangedEvent();
                            }
                            
                           
                    }});
                    
                    
                    $('#btnCloc').live("click", function(){ 
                        setCurrentLocation(null, function(status){
                            if (status == 'OK')
                            {
                                setZoom(initialzoom);
                            }
                        }); 
                       
                    }); 
                    
                    $('#btnEloc').live("click", function(){
                       console.log($('#address').val());
                       
                    });
                    
                    
                    
                });
            })(jQuery);
        </script>
    </head>
    <body>    
       <div id="map_canvas">
       </div>     
        <div id="map-controls">
                <button id="btnCloc" type="button">O</button> 
                <input id="address" type="text" />
                <button id="btnEloc" type="button">&rsaquo;</button>
            </div>
    </body>
    <footer>
    </footer>
</html>