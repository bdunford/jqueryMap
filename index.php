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
    
                $(document).ready(function(){
        
                    //Gonna turn this into a class.  
                    var specificLocation; //= new google.maps.LatLng('39.606772','-84.139151');
                    var timeout; 
                    var map;
                    var initialzoom = 12;
                    var minzoom = 8;
                    var geocoder = new google.maps.Geocoder();
                    
                    
                    
                        
                    function addLocations() {
                        var bounds = map.get('map').getBounds();
                        console.log('Adding Locations');
                        getLocations(bounds, function(data) {
                            $.each(data, function(k, v) { 
                                dropPin(v.id,new google.maps.LatLng(v.lat,v.lng),v.name,true);
                            });
                            
                        });
                    }
                    
                    
                    function getLocations(bounds, callback)
                    {
                        var ne = bounds.getNorthEast();
                        var sw = bounds.getSouthWest();
                        var url = 'Locations.php?nelat=' + ne.lat() + '&nelng=' + ne.lng() + '&swlat=' + sw.lat() + '&swlng=' + sw.lng() 
                        console.log(url);
                         $.ajax({url: url, success: function(data) {
                            callback(data);
                         }, error: function(x,h,e){
                            console.log(e);
                         }});
                    }
                    
                    function dropPin(id, latlong, content, clickable, icon) {
                        mk = map.get('markers')[id];
                        if (id == 0)
                        {
                          if (mk) 
                          {
                           mk.setMap(null);        
                          }
                        } else {
                            
                            if (mk) 
                            {
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
                                if (status == google.maps.GeocoderStatus.OK) {
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
                                   if (status != google.maps.GeocoderStatus.OK) 
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
                            if (status == google.maps.GeocoderStatus.OK)
                            {
                                setZoom(initialzoom);
                            }
                        }); 
                       
                    }); 
                    
                    $('#btnEloc').live("click", function(){
                        var addr = $('#address').val();
                        geocoder.geocode( { 'address': addr }, function(results, status) {
                           if (status == google.maps.GeocoderStatus.OK) {
                               setLocationAndCenter(results[0].geometry.location);
                               setZoom(initialzoom);
                           } 
                        });
                       
                    });
                    
                    
                    
                });
            })(jQuery);
        </script>
    </head>
    <body>
      <div id="map-container">  
       <div id="map_canvas">
       </div>     
        <div id="map-controls">
                <button id="btnCloc" type="button">O</button> 
                <input id="address" type="text" />
                <button id="btnEloc" type="button">&rsaquo;</button>
            </div>
      </div>  
    </body>
    <footer>
    </footer>
</html>