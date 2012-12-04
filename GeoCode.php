<?php
//
?>
<html>
    <head>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
(function ($) {
    
    $(window).load(function(){
        
        var geocoder = new google.maps.Geocoder();
        
        
        $.getJSON('./json/data.json', function(data) {
          
           $.each(data, function(k, v) {
             
                geocoder.geocode( { 'address': v.addr }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                       var qry = "update stores set Latitude='" + results[0].geometry.location.lat() + "', Longitude ='" + results[0].geometry.location.lng() + "' where id = '" + v.id + "'<br />";
                       $('body').append(qry);
                    }            
                });
           });
        });                   
    });   
})(jQuery);    
</script>
</head>
<body>
    
</body>
</html>