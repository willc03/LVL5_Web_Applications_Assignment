<style>
    body {
        background-image: url("/assets/golf-bg-1.png");
        background-size: cover;
    }
</style>

<h1>About Us</h1>
<br>
<p style="width: 70%; text-align: justify">This fine links course runs parallel to the Irish Sea on the west coast of Walney Island, which is joined to the mainland at Barrow-in-Furness by the Jubilee Bridge. From the majestic peaks of the Lakeland hills to the sparkling waters of Morecambe Bay, panoramic views greet the eye on every tee.</p>
<br>
<p style="width: 70%; text-align: justify">Founded in 1872 by migrant Scottish workers from Dundee, as a 6-hole course on Biggar Bank the course was later extended to a 9-hole and then developed into a 18-hole course. The first clubhouse was an old deck cabin, from one of the old Clan liners, which was placed at Sandy Gap Lane. The erection of the bridge across Walney Channel in 1908, replacing the ferry, added to the attraction of the club for an ever-widening public and plans for a new Clubhouse were put in hand.</p>
<br>
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
