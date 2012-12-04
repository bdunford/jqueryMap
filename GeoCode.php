<?php





?>
<html>
    <head>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
(function ($) {
    
    $(window).load(function(){
        
        var geocoder = new google.maps.Geocoder();

    
        $.ajax({url: 'Addresses.php',
            error: function(x,h,r) {console.log(r)},
            success: function(data) {
           $.each(data, function(k, v) {
   
                geocoder.geocode( { 'address': v.address }, function(results, status) {
                    var lat;
                    var lng; 
                    if (status == google.maps.GeocoderStatus.OK) {
                        lat = results[0].geometry.location.lat();
                        lng = results[0].geometry.location.lng();
                    } else {
                        lat = 'err';
                        lng = 'err';
                    }
                    
                    $.ajax({url: 'Addresses.php?id=' + v.id + '&lat=' + lat + '&lng=' + lng, success: function(data) {
                            $('body').append(v.address + ' ' + lat + ' ' + lng + ' ' + data + '<br />');
                    }});
                });
             
           });
        }});                   
    });   
})(jQuery);    
</script>
</head>
<body>
    
</body>
</html>