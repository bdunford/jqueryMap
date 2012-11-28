<html>   
<head>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="./js/jquery.ui.map.full.min.js"></script>


<link type="text/css" rel="stylesheet" href="./css/screen.css"></link>
<script type="text/javascript" >
(function($) {
    
    $(window).load(function(){
        
    
                    var currLocation = '39.606772,-84.139151';
                        
                    function Addmarkers(map) {
                        var bounds = map.get('map').getBounds();
                        console.log(bounds);
                        map.addMarker({'position': '39.603772,-84.133151'}).click(function(){map.openInfoWindow({ 'content': 'Store 1' }, this)});
                        map.addMarker({'position': '39.604772,-84.133151'}).click(function(){map.openInfoWindow({ 'content': 'Store 2' }, this)});
                        map.addMarker({'position': '39.605772,-84.133151'}).click(function(){map.openInfoWindow({ 'content': 'Store 3' }, this)});
                        map.addMarker({'position': '39.602772,-84.133151'}).click(function(){map.openInfoWindow({ 'content': 'Store 4' }, this)});
                        //map.addMarker({'position': map.get('map').getCenter()}).click(function(){map.openInfoWindow({ 'content': 'Store 4' }, this)});
                        
                    }
        
   
					$('#map_canvas').gmap({'center': currLocation, 'zoom': 15, 'disableDefaultUI':true, 'minZoom': 6, 'callback': function() {
						
                        var map_object = this;
                                               
						map_object.addMarker({'id': 'current-location','position': map_object.get('map').getCenter(), 'bounds':false, 'icon': './images/current-location.png'}).click(function() {
							map_object.openInfoWindow({ 'content': 'Your Location' }, this);
						});	
                        
                          
                        google.maps.event.addListener(this.get('map'), 'tilesloaded', function() {
                            Addmarkers(map_object);
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