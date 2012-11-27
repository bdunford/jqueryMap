<html>   
<head>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="./js/jquery.ui.map.js"></script>
<link type="text/css" rel="stylesheet" href="./css/screen.css"></link>
<script type="text/javascript" >
(function($) {
    $(window).load(function(){
        
        
        /*
        $('#map_canvas').gmap({'zoom': 5, 'disableDefaultUI': true }).bind('init', function(ev, map) {
	       $('#map_canvas').gmap('addMarker', {'position': '39.606772,-84.139151', 'bounds': true}).click(function() {
		      $('#map_canvas').gmap('openInfoWindow', {'content': 'Hello World!'}, this);
	        });
        });
          */        
                    var currLocation = '39.606772,-84.139151';
        
   
					$('#map_canvas').gmap({'center': currLocation, 'zoom': 15, 'disableDefaultUI':true, 'callback': function() {
						var self = this;
                                               
						self.addMarker({'id': 'current-location','position': this.get('map').getCenter() }).click(function() {
							self.openInfoWindow({ 'content': 'Your Location' }, this);
						});	
                        
                        var clientPosition = new google.maps.LatLng('39.606772','-84.139151' );
                        
                        self.addShape('Circle', { 
                            'strokeWeight': 0, 
                            'fillColor': "#008595", 
                            'fillOpacity': 0.25, 
                            'center': clientPosition, 
                            'radius': 15, 
                            'clickable': false 
                        });
                        
                        self.addMarker({'position': '39.603772,-84.133151'}).click(function(){self.openInfoWindow({ 'content': 'Store 1' }, this)});
                        self.addMarker({'position': '39.604772,-84.133151'}).click(function(){self.openInfoWindow({ 'content': 'Store 2' }, this)});
                        self.addMarker({'position': '39.605772,-84.133151'}).click(function(){self.openInfoWindow({ 'content': 'Store 3' }, this)});
                        self.addMarker({'position': '39.602772,-84.133151'}).click(function(){self.openInfoWindow({ 'content': 'Store 4' }, this)});
                        
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