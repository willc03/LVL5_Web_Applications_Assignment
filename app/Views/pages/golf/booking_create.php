<a class="return" href="<?php echo site_url('/golf?date=' . $_GET['date']); ?>">Back</a>
<h1>Create a booking</h1>
<div class="booking_details">
    <br>
    <h2>Booking Details</h2>
    <div class="info_container">
        <h3 class="title">Date:</h3>
        <p><?php echo date('D, d M Y', strtotime($_GET["date"])); ?></p>
    </div>
    <div class="info_container">
        <h3 class="title">Time:</h3>
        <p><?php echo $_GET["time"]; ?></p>
    </div>
    <br>
    <h2>Additional Players</h2>
    <div class="additional_player">
        <div class="info_container">
            <h3>Player 2: </h3>
            <button class="add_btn" onclick="document.getElementById('plr_2').style.display = 'block';">+</button>
        </div>
        <div class="detail_container" id="plr_2" style="display: none">
            <script>
                $( function() {
                    var availableTags = [];
                    $.ajax({
                        url: '<?php echo site_url('/api/members/get'); ?>',
                        method: 'GET',
                        success: function(response) {
                            // Create the autocomplete field using the response from the AJAX request
                            availableTags = JSON.parse(response);
                            $( "#plr_2_name" ).autocomplete({
                                source: availableTags
                            });
                        }
                    });
                });
            </script>
            <input type="text" id="plr_2_name">
        </div>
    </div>

    <form method="post" action="<?php site_url('/golf/booking/create') ?>">

    </form>
</div>