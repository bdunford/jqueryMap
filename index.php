<html>   
<head>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="./js/jquery.ui.map.full.min.js"></script>


<link type="text/css" rel="stylesheet" href="./css/screen.css"></link>
<script type="text/javascript" >
(function($) {
    
    $(window).load(function(){
        
                    //Gonna turn this into a class.  
                    var currLocation = '39.606772,-84.139151';
                    var timeout 
                    var map
                        
                    function addLocations() {
                        var bounds = map.get('map').getBounds();
                        console.log(bounds);
                        
                        dropPin('1','39.601772','-84.133151','Store 1');
                        dropPin('2','39.602772','-84.133151','Store 2');
                        dropPin('3','39.603772','-84.133151','Store 3');
                        dropPin('4','39.604772','-84.133151','Store 4');
                    }
                    
                    
                    function getLocations(bounds)
                    {
                        
                    }
                    
                    function dropPin(id, geolat, geolong, content, icon) {
                        map.addMarker({'id': id, 'position': geolat + ',' + geolong, 'icon': icon}).click(function(){map.openInfoWindow({ 'content': content }, this)});
                    }
        
   
					$('#map_canvas').gmap({'center': currLocation, 'zoom': 15, 'disableDefaultUI':true, 'minZoom': 6, 'callback': function() {
						
                        map = this;
                                               
						map.addMarker({'id': 'current-location','position': map.get('map').getCenter(), 'bounds':false, 'icon': './images/current-location.png'}).click(function() {
							map.openInfoWindow({ 'content': 'Your Location' }, this);
						});	
                        
                        google.maps.event.addListener(map.get('map'), 'tilesloaded', function() {
                            clearTimeout(timeout);
                            timeout = setTimeout(function(){addLocations();}, 750);
                        });
                        
                     
					}});

        
    });
})(jQuery);
</script>
</head>
<body>
<h1>My Map</h1>
<div id="phone-frame">
  <div id="map_canvas">
</div>
</div>
</body>
<footer>
</footer>
</html>