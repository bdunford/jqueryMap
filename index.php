<html>   
    <head>
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
                        
                        //make a randomizer here
                    }
                    
                    function dropPin(id, latlong, content, clickable, icon) {
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
                    
                    function addBoundsChangedEvent() {
                        google.maps.event.addListener(map.get('map'), 'bounds_changed', function() {
                                    clearTimeout(timeout);
                                    timeout = setTimeout(function(){addLocations();}, 750);
                                });
                    }

                    $('#map_canvas').gmap({'zoom': 10, 'disableDefaultUI':true, 'minZoom': 1, 'callback': function() {
						
                            map = this;
                            
                            if (!specificLocation)
                            {
                                setCurrentLocation(new google.maps.LatLng('39.500000','-98.350000'), function(status){
                                   if (status != 'OK') 
                                   {
                                       map.get('map').setZoom(5);  
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
                });
            })(jQuery);
        </script>
    </head>
    <body>
        <h1>My Map</h1>
        <div id="phone-frame">
            <div id="map-controls">
                
            </div>
            <div id="map_canvas">
            </div>    
            <div id="map-location">
                
            </div>
        </div>
    </body>
    <footer>
    </footer>
</html>