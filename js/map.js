(function($) {
    
    $(document).ready(function(){
        
        var specificLocation;
        var timeout; 
        var map;
        var initialzoom = 12;
        var minzoom = 8;
        var geocoder = new google.maps.Geocoder();
                
        function addLocations() {
            var bounds = map.get('map').getBounds();
            getLocations(bounds, function(data) {
                $.each(data, function(k, v) { 
                    dropPin(v.id,new google.maps.LatLng(v.lat,v.lng),v,true,null,function(marker,data){
                        //wire up click event here 
                        console.log(data);
                        console.log(marker);
                    });
                });
                            
            });
        }
                    
        function getLocations(bounds, callback)
        {
            var ne = bounds.getNorthEast();
            var sw = bounds.getSouthWest();
            var url = 'Locations.php?nelat=' + ne.lat() + '&nelng=' + ne.lng() + '&swlat=' + sw.lat() + '&swlng=' + sw.lng() 
            $.ajax({
                url: url, 
                success: function(data) {
                    callback(data);
                }
            });
        }
                    
        function dropPin(id, latlong, content, clickable, icon, onclick) {
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
            map.addMarker({
                'id': id, 
                'position': latlong, 
                'icon': icon, 
                'clickable' : clickable
            }).click(function(){
                if (onclick) {
                    onclick(this, content);   
                }
            });
        }
                    
        function setLocationAndCenter(location, callback) {
            map.get('map').setCenter(location);
            dropPin('0',location,'Your Location',false,'./images/current-location.png' );
            if (callback)
            {
                callback(location);
            }
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
                timeout = setTimeout(function(){
                    addLocations();
                }, 750);
            });
        }

        $('#map_canvas').gmap({
            'zoom': initialzoom, 
            'disableDefaultUI':true, 
            'minZoom': minzoom, 
            'callback': function() {
						
                map = this;
                            
                if (!specificLocation)
                {
                    setCurrentLocation(new google
                        .maps.LatLng('39.500000','-98.350000'), function(status){
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
            }
        });
                    
                    
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
            geocoder.geocode( {
                'address': addr
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    setLocationAndCenter(results[0].geometry.location, function(){
                        setZoom(initialzoom);
                    });
                } 
            });
                       
        });
    });
})(jQuery);

