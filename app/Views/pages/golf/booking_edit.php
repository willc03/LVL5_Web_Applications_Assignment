<h1>Edit Booking</h1>
<br>

<?php // Output a message detailing why the user is allowed to edit the booking ?>
<p class="reason"><i>
<?php if ($userOwnsBooking && $userIsStaffMember) { ?>
    You are allowed to edit this booking because you own the booking and are a staff member.
<?php } elseif ($userOwnsBooking) { ?>
    You are allowed to edit this booking because you own this booking.
<?php } elseif ($userIsStaffMember) { ?>
    You are allowed to edit this booking because you are a member of staff.
<?php } ?>
</i></p>

<br>
<h3 class="existing_details_title">Existing details</h3>
<br>
<div class="existing_details">
    <div class="date">
        <h4>Date: </h4>
        <p><?php echo date('D, d M Y', strtotime($bookingInfo['date'])); ?></p>
    </div>
    <div class="time">
        <h4>Time: </h4>
        <p><?php echo $bookingInfo['time']; ?></p>
    </div>
    <div class="players">
        <h4>Players: </h4>
        <?php foreach ($bookingInfo['players'] as $player) { ?>
            <p><?php echo $player[1]; ?></p>
        <?php } ?>
    </div>
</div>
<br>
<div class="existing_details">
    <div class="date">
        <button class="date_toggle" id="date_edit">Edit</button>
    </div>
    <div class="time">
        <button class="time_toggle" id="time_edit">Edit</button>
    </div>
    <div class="players">
        <button class="players_toggle" id="players_edit">Edit</button>
    </div>
</div>

<br>

<div class="editing_area" id="editing_area" style="display: none">
    <div id="date_toggle" style="display: none">
        <h4>Editing: Date</h4>
        <br>
        <p>Please note that dates chosen must be between 4 weeks of the current date.</p>
        <br>
        <input id="datebox" type="text" onchange="
            document.getElementById('newDate').setAttribute('value', this.value);
            onInputValueChanged('date');
        " value="<?php echo date('d/m/Y', strtotime($bookingInfo['date'])); ?>">
        <script>
            $( function() {
                $( "#datebox" ).datepicker({
                    dateFormat: "dd/mm/yy",
                    minDate: '-4w',
                    maxDate: '+4w',
                    defaultDate: "<?php echo date('d/m/Y', strtotime($bookingInfo['date'])); ?>"
                });
            } );
        </script>
    </div>
    <div id="time_toggle" style="display: none">
        <h4>Editing: Time</h4>
        <br>
        <p>Please note that any greyed-out times are already taken by other bookings.</p>
        <br>
        <select id="timebox" onchange="
            document.getElementById('newTime').setAttribute('value', this.value);
            onInputValueChanged();
        ">
            <option disabled selected>Please select a time</option>
            <?php foreach ($times_on_day as $default_time) { ?>
                <option <?php if ($default_time[1]) { echo 'disabled'; }  ?>><?php echo $default_time[0]; ?></option>
            <?php } ?>
        </select>
    </div>
    <div id="players_toggle" style="display: none">
        <h4>Editing: Players</h4>
        <br>
        <div class="additional_player" id="plr_2_section">
            <div class="info_container">
                <h3>Player 2: </h3>
                <p id="plr_2_selection" style="display: <?php echo isset($bookingInfo['players'][1][1]) ? 'block' : 'none' ?>"><?php echo $bookingInfo['players'][1][1] ?? ""; ?></p>
                <button class="add_btn" id="plr2_add" onclick="document.getElementById('plr_2').style.display = 'block'; onInputValueChanged();" style="display: <?php echo (count($bookingInfo['players']) < 2) ? 'block' : 'none' ?>">+</button>
                <button class="del_btn" id="plr2_del" onclick="document.getElementById('plr_2_selection').style.display = 'none'; document.getElementById('plr2_add').style.display = 'block'; this.style.display = 'none'; document.getElementById('newPlr2').value = 'rem'; onInputValueChanged();" style="display: <?php echo (count($bookingInfo['players']) >= 2) ? 'block' : 'none' ?>">-</button>
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
                                        document.getElementById('newPlr2').setAttribute('value', ui.item.value);
                                        document.getElementById('plr_2_selection').innerHTML = ui.item.label;
                                        document.getElementById('plr_2_selection').style.display = 'block';
                                        document.getElementById('plr2_del').style.display = 'block';

                                        document.getElementById('plr2_add').style.display = 'none';
                                        document.getElementById('plr_2_name').style.display = 'none';

                                        document.getElementById('plr_3_section').style.display = 'block';
                                        onInputValueChanged();
                                    }
                                });
                            }
                        });
                    });
                </script>
                <input type="text" id="plr_2_name">
            </div>
        </div>
        <div class="additional_player" id="plr_3_section" style="display: <?php echo (count($bookingInfo['players']) >= 2 ? 'block' : 'none') ?>;">
            <div class="info_container">
                <h3>Player 3: </h3>
                <p id="plr_3_selection" style="display: <?php echo isset($bookingInfo['players'][2][1]) ? 'block' : 'none' ?>"><?php echo $bookingInfo['players'][2][1] ?? ""; ?></p>
                <button class="add_btn" id="plr3_add" onclick="document.getElementById('plr_3').style.display = 'block'; onInputValueChanged();" style="display: <?php echo (count($bookingInfo['players']) < 3) ? 'block' : 'none' ?>">+</button>
                <button class="del_btn" id="plr3_del" onclick="document.getElementById('plr_3_selection').style.display = 'none'; document.getElementById('plr3_add').style.display = 'block'; this.style.display = 'none'; document.getElementById('newPlr3').value = 'rem'; onInputValueChanged();" style="display: <?php echo (count($bookingInfo['players']) >= 3) ? 'block' : 'none' ?>">-</button>
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
                                        document.getElementById('newPlr3').setAttribute('value', ui.item.value)
                                        document.getElementById('plr_3_selection').innerHTML = ui.item.label;
                                        document.getElementById('plr_3_selection').style.display = 'block';
                                        document.getElementById('plr3_del').style.display = 'block';

                                        document.getElementById('plr3_add').style.display = 'none';
                                        document.getElementById('plr_3_name').style.display = 'none';

                                        document.getElementById('plr_4_section').style.display = 'block';
                                        onInputValueChanged();
                                    }
                                });
                            }
                        });
                    });
                </script>
                <input type="text" id="plr_3_name">
            </div>
        </div>
        <div class="additional_player" id="plr_4_section" style="display: <?php echo (count($bookingInfo['players']) >= 3 ? 'block' : 'none') ?>;">
            <div class="info_container">
                <h3>Player 4: </h3>
                <p id="plr_4_selection" style="display: <?php echo isset($bookingInfo['players'][3][1]) ? 'block' : 'none' ?>"><?php echo $bookingInfo['players'][3][1] ?? ""; ?></p>
                <button class="add_btn" id="plr4_add" onclick="document.getElementById('plr_4').style.display = 'block'; onInputValueChanged();" style="display: <?php echo (count($bookingInfo['players']) < 4) ? 'block' : 'none' ?>">+</button>
                <button class="del_btn" id="plr4_del" onclick="document.getElementById('plr_4_selection').style.display = 'none'; document.getElementById('plr4_add').style.display = 'block'; this.style.display = 'none'; document.getElementById('newPlr4').value = 'rem'; onInputValueChanged();" style="display: <?php echo (count($bookingInfo['players']) >= 4) ? 'block' : 'none' ?>">-</button>
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
                                        document.getElementById('newPlr4').setAttribute('value', ui.item.value)
                                        document.getElementById('plr_4_selection').innerHTML = ui.item.label;
                                        document.getElementById('plr_4_selection').style.display = 'block';
                                        document.getElementById('plr4_del').style.display = 'block';

                                        document.getElementById('plr4_add').style.display = 'none';
                                        document.getElementById('plr_4_name').style.display = 'none';
                                        onInputValueChanged();
                                    }
                                });
                            }
                        });
                    });
                </script>
                <input type="text" id="plr_4_name">
            </div>
        </div>
        <br>
    </div>
    <script>
        const buttons = [
            ['date_edit', document.getElementById('date_toggle')],
            ['time_edit', document.getElementById('time_toggle')],
            ['players_edit', document.getElementById('players_toggle')]
        ];

        buttons.forEach(([button, object]) => {
            document.getElementById(button).addEventListener('click', () => {
                buttons.forEach(([_, obj]) => obj.style.display = 'none');

                document.getElementById('editing_area').style.display = 'block';
                object.style.display = 'flex';
            });
        });
    </script>
</div>

<br>
<p id="error_message" style="display: none; color: red;"></p>
<br>
<h3 class="existing_details_title" id="new_title" style="display: none">New Details</h3>
<br>
<div class="existing_details" id="new_details" style="display: none">
    <div class="date">
        <h4>Date: </h4>
        <p id="nd_date"><?php echo date('d/m/Y', strtotime($bookingInfo['date'])); ?></p>
    </div>
    <div class="time">
        <h4>Time: </h4>
        <p id="nd_time"><?php echo $bookingInfo['time']; ?></p>
    </div>
    <div class="players">
        <h4>Players: </h4>
        <div id="nd_players">
            <?php foreach ($bookingInfo['players'] as $player) { ?>
                <p><?php echo $player[1]; ?></p>
            <?php } ?>
        </div>
    </div>
</div>
<br>
<div class="booking_edit_submission">
    <a href="<?php echo site_url('/golf'); ?>">Cancel</a>
    <form method="post" action="<?php echo site_url("/golf/booking/$id"); ?>">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="date" id="newDate">
        <input type="hidden" name="time" id="newTime">
        <input type="hidden" name="plr2" id="newPlr2" value="<?php echo $bookingInfo['players'][1][0] ?? 'null' ?>">
        <input type="hidden" name="plr3" id="newPlr3" value="<?php echo $bookingInfo['players'][2][0] ?? 'null' ?>">
        <input type="hidden" name="plr4" id="newPlr4" value="<?php echo $bookingInfo['players'][3][0] ?? 'null' ?>">
        <input type="submit" value="Save Changes" id="submitbutton">
    </form>
</div>

<script>
    const currentDateObj = '<?php echo $bookingInfo['date'] ?>';
    const currentTimeObj = '<?php echo $bookingInfo['time'] ?>';
    const plrIdObjs = [document.getElementById('newPlr2'), document.getElementById('newPlr3'), document.getElementById('newPlr4')];

    function onInputValueChanged(change) {
        const newDetailsObj = document.getElementById('new_details');
        const newTitleObj = document.getElementById('new_title');
        const newDateObj = document.getElementById('newDate');
        const newTimeObj = document.getElementById('newTime');
        const errorObj = document.getElementById('error_message');
        const submitBtnObj = document.getElementById('submitbutton');
        const timeBoxObj = document.getElementById('timebox');
        const npPlayersObj = document.getElementById('nd_players');

        newDetailsObj.style.display = 'flex';
        newTitleObj.style.display = 'block';

        const data = {
            date: currentDateObj,
            time: currentTimeObj
        };

        if (newDateObj.value.length === 10) {
            data.date = newDateObj.value;
            document.getElementById('nd_date').innerHTML = newDateObj.value;
        }

        if (newTimeObj.value) {
            data.time = newTimeObj.value;
            document.getElementById('nd_time').innerHTML = newTimeObj.value;
        }

        while (npPlayersObj.firstChild) {
            npPlayersObj.removeChild(npPlayersObj.lastChild);
        }
        npPlayersObj.innerHTML += "<p><?php echo $bookingInfo['players'][0][1]; ?></p>";
        for (let i = 0; i < plrIdObjs.length; i++)
        {
            if (plrIdObjs[i].value == "null" || plrIdObjs[i].value == 'rem')
            {
                continue;
            }
            $.ajax({
                url: '<?php echo site_url('/api/member/get/id/');?>' + plrIdObjs[i].value,
                method: 'GET',
                success: function (response) {
                    response = JSON.parse(response);
                    npPlayersObj.innerHTML += `<p>${response.Lastname + ', ' + response.Firstname}</p>`;
                }
            });
        }


        $.ajax({
            url: '<?php echo site_url('/api/bookings/get'); ?>',
            method: 'GET',
            data,
            success: function (response) {
                if (change === 'date') {
                    $.ajax({
                        url: '<?php echo site_url('/api/bookings/times/getavailable'); ?>',
                        method: 'GET',
                        data,
                        success: function (times) {
                            times = JSON.parse(times);
                            timeBoxObj.innerHTML = '';
                            timeBoxObj.innerHTML += `<option selected disabled>Please select a time</option>`;
                            for (let i = 0; i < times.length; i++) {
                                const optionObj = document.createElement('option');
                                optionObj.value = times[i][0];
                                optionObj.disabled = times[i][1] === 1;
                                optionObj.innerText = times[i][0];
                                timeBoxObj.appendChild(optionObj);
                            }
                        }
                    });
                }

                const originalDate = document.getElementById('nd_date').innerHTML;
                const dateParts = originalDate.split('/');
                const formattedDate = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0];
                console.log(formattedDate);
                console.log(<?php echo $bookingInfo['date']; ?>)

                if (response.length > 2 && formattedDate != '<?php echo $bookingInfo['date']; ?>') {
                    errorObj.style.display = 'block';
                    errorObj.innerHTML = 'Booking conflict: a booking already exists at the new date and time. Try selecting another time or date.';
                    submitBtnObj.disabled = true;
                } else {
                    errorObj.style.display = 'none';
                    errorObj.innerHTML = '';
                    submitBtnObj.disabled = false;
                }
            }
        });
    }
</script>