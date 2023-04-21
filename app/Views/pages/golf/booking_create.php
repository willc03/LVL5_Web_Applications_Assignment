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
            <p id="plr_2_selection" style="display: none;"></p>
            <button class="add_btn" id="plr2_add" onclick="document.getElementById('plr_2').style.display = 'block';">+</button>

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
                                source: availableTags,
                                select: function( event, ui ) {
                                    document.getElementById('plr_2_id').setAttribute('value', ui.item.value)
                                    document.getElementById('plr_2_selection').innerHTML = ui.item.label;
                                    document.getElementById('plr_2_selection').style.display = 'block';

                                    document.getElementById('plr2_add').style.display = 'none';
                                    document.getElementById('plr_2_name').style.display = 'none';

                                    document.getElementById('plr_3_section').style.display = 'block';
                                }
                            });
                        }
                    });
                });
            </script>
            <input type="text" id="plr_2_name">
        </div>
    </div>
    <br>
    <div class="additional_player" id="plr_3_section" style="display: none;">
        <div class="info_container">
            <h3>Player 3: </h3>
            <p id="plr_3_selection" style="display: none;"></p>
            <button class="add_btn" id="plr3_add" onclick="document.getElementById('plr_3').style.display = 'block';">+</button>

        </div>
        <div class="detail_container" id="plr_3" style="display: none">
            <script>
                $( function() {
                    var availableTags = [];
                    $.ajax({
                        url: '<?php echo site_url('/api/members/get'); ?>',
                        method: 'GET',
                        success: function(response) {
                            // Create the autocomplete field using the response from the AJAX request
                            availableTags = JSON.parse(response);
                            $( "#plr_3_name" ).autocomplete({
                                source: availableTags,
                                select: function( event, ui ) {
                                    document.getElementById('plr_3_id').setAttribute('value', ui.item.value)
                                    document.getElementById('plr_3_selection').innerHTML = ui.item.label;
                                    document.getElementById('plr_3_selection').style.display = 'block';

                                    document.getElementById('plr3_add').style.display = 'none';
                                    document.getElementById('plr_3_name').style.display = 'none';

                                    document.getElementById('plr_4_section').style.display = 'block';
                                }
                            });
                        }
                    });
                });
            </script>
            <input type="text" id="plr_3_name">
        </div>
    </div>
    <br>
    <div class="additional_player" id="plr_4_section" style="display: none;">
        <div class="info_container">
            <h3>Player 4: </h3>
            <p id="plr_4_selection" style="display: none;"></p>
            <button class="add_btn" id="plr4_add" onclick="document.getElementById('plr_4').style.display = 'block';">+</button>

        </div>
        <div class="detail_container" id="plr_4" style="display: none">
            <script>
                $( function() {
                    var availableTags = [];
                    $.ajax({
                        url: '<?php echo site_url('/api/members/get'); ?>',
                        method: 'GET',
                        success: function(response) {
                            // Create the autocomplete field using the response from the AJAX request
                            availableTags = JSON.parse(response);
                            $( "#plr_4_name" ).autocomplete({
                                source: availableTags,
                                select: function( event, ui ) {
                                    document.getElementById('plr_4_id').setAttribute('value', ui.item.value)
                                    document.getElementById('plr_4_selection').innerHTML = ui.item.label;
                                    document.getElementById('plr_4_selection').style.display = 'block';

                                    document.getElementById('plr4_add').style.display = 'none';
                                    document.getElementById('plr_4_name').style.display = 'none';
                                }
                            });
                        }
                    });
                });
            </script>
            <input type="text" id="plr_4_name">
        </div>
    </div>

    <form method="post" action="<?php site_url('/golf/booking/create') ?>">

        <input type="hidden" name="date" value="<?php echo $_GET['date']; ?>">
        <input type="hidden" name="time" value="<?php echo $_GET['time']; ?>">
        <input type="hidden" name="plr_2_id" value="-1" id="plr_2_id">
        <input type="hidden" name="plr_3_id" value="-1" id="plr_3_id">
        <input type="hidden" name="plr_4_id" value="-1" id="plr_4_id">

        <input type="submit">
    </form>
</div>