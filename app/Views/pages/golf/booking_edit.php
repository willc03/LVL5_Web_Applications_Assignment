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
            <?php foreach ($times_on_day as $default_time) { ?>
                <option <?php if ($default_time[1]) { echo 'disabled'; } ?>><?php echo $default_time[0]; ?></option>
            <?php } ?>
        </select>
    </div>
    <div id="players_toggle" style="display: none">
        <h4>Editing: Players</h4>
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
<div class="booking_edit_submission">
    <a href="<?php echo site_url('/golf'); ?>">Cancel</a>
    <form method="post" action="<?php echo site_url("/golf/booking/$id"); ?>">
        <input type="hidden" name="date" id="newDate">
        <input type="hidden" name="time" id="newTime">
        <input type="hidden" name="plr2" id="newPlr2">
        <input type="hidden" name="plr3" id="newPlr3">
        <input type="hidden" name="plr4" id="newPlr4">
        <input type="submit" value="Save Changes" id="submitbutton">
    </form>
</div>

<script>
    const currentDateObj = '<?php echo $bookingInfo['date'] ?>';
    const currentTimeObj = '<?php echo $bookingInfo['time'] ?>';

    function onInputValueChanged(change) {
        const newDetailsObj = document.getElementById('new_details');
        const newTitleObj = document.getElementById('new_title');
        const newDateObj = document.getElementById('newDate');
        const newTimeObj = document.getElementById('newTime');
        const errorObj = document.getElementById('error_message');
        const submitBtnObj = document.getElementById('submitbutton');
        const timeBoxObj = document.getElementById('timebox');

        newDetailsObj.style.display = 'flex';
        newTitleObj.style.display = 'block';

        const data = {
            date: currentDateObj,
            time: currentTimeObj
        };

        if (newDateObj.value.length === 10) {
            data.date = newDateObj.value;
        }

        if (newTimeObj.value) {
            data.time = newTimeObj.value;
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

                if (response.length > 2) {
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