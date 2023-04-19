<div id="fgcMap"></div>
<script>
    function initialise() {
        var mapProp = {
            center:new google.maps.LatLng(54.106531461438195, -3.257412809651328),
            zoom:17,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };
        var map=new google.maps.Map(document.getElementById("fgcMap"),mapProp);
    }
    addEventListener('load', initialise);
</script>
