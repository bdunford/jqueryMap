(function($) {
    
    $(document).ready(function(){
        
        //global
        var specificLocation;
        var timeout; 
        var map;
        var selected;
        var geocoder = new google.maps.Geocoder();
        
        //defaults
        var initialzoom = 12;
        var minzoom = 8;
        var currIcon = './images/current-location.png';
        var selIcon = './images/map-pin-selected.png';
        var defIcon = './images/map-pin-default.png';
        var locUrl = 'Locations.php'
                
        function addLocations() {
            var bounds = map.get('map').getBounds();
            getLocations(bounds, function(data) {
                $.each(data, function(k, v) { 
                    dropPin(v.id,new google.maps.LatLng(v.lat,v.lng),v,true,defIcon,function(marker,data){
                        var addr = '<p>' + data.name + '<br />' + data.address + '<br />' + data.city + ', ' + data.state + ' ' + data.zip + '</p>';
                        var phn = $('<a>').attr({href: 'tel:' + (new String(data.phone)).replace(/[^0-9]/g, '')}).text(data.phone);
                        
                        $('#location').html(addr);
                        $('#location').append(phn);
                        
                        console.log(data);
                        console.log(marker)
                        
                        if (selected) {
                            selected.setIcon(defIcon);
                            selected.setZIndex(0);
                        }
                        marker.setIcon(selIcon);
                        marker.setZIndex(999);
                        selected = marker;
                    });
                });
                            
            });
        }
                    
        function getLocations(bounds, callback)
        {
            var ne = bounds.getNorthEast();
            var sw = bounds.getSouthWest();
            var url =  locUrl + '?nelat=' + ne.lat() + '&nelng=' + ne.lng() + '&swlat=' + sw.lat() + '&swlng=' + sw.lng() 
            $.ajax({
                url: url, 
                success: function(data) {
                    callback(data);
                }
            });
        }
                    
        function dropPin(id, latlong, content, clickable, icon, onclick) {
            var mk = map.get('markers')[id];
            
            if (mk) 
            {
                if (id == 0) {
                   mk.setMap(null);  
                } else {
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
            dropPin('0',location,'Your Location',false,currIcon );
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

        $('#map').gmap({
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

