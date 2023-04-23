<?php if (isset($_GET["error"]) && $_GET["error"] == "booking_conflict") {?>
    <div class="message_box error">
        <h2>Error: Booking Conflict</h2>
        <p>A booking already exists at this date and time!</p>
    </div>
<?php } elseif (isset($_GET["error"]) && $_GET["error"] == "insufficient_data") { ?>
    <div class="message_box error">
        <h2>Error: Data missing</h2>
        <p>Invalid time selected! Please try again.</p>
    </div>
<?php } elseif (isset($_GET["error"]) && ($_GET["error"] == "booking_not_found" || $_GET["error"] == "unknown_deletion_error")) { ?>
    <div class="message_box error">
        <h2>Error: Booking not found</h2>
        <p>The action couldn't be completed as the booking couldn't be found in the system!</p>
    </div>
<?php } elseif (isset($_GET["error"]) && $_GET["error"] == "invalid_selection") { ?>
    <div class="message_box error">
        <h2>Error: Couldn't delete booking</h2>
        <p>Only the creator of a booking can delete it.</p>
    </div>
<?php } elseif (isset($_GET["error"]) && $_GET["error"] == "booking_unsuccessful") { ?>
    <div class="message_box error">
        <h2>Error: Booking unsuccessful</h2>
        <p>An unspecified booking error has occurred. Please contact an administrator.</p>
    </div>
<?php } elseif (isset($_GET["error"]) && $_GET["error"] == "edit_failed") { ?>
    <div class="message_box error">
        <h2>Error: Edit unsuccessful</h2>
        <p>An unspecified editing error has occurred. Please contact an administrator.</p>
    </div>
<?php } elseif (isset($_GET["message"]) && $_GET["message"] == "booking_deleted") { ?>
    <div class="message_box success">
        <h2>Booking Deleted</h2>
        <p>Your booking has been removed from the system.</p>
    </div>
<?php } elseif (isset($_GET["message"]) && $_GET["message"] == "booking_successful") { ?>
    <div class="message_box success">
        <h2>Booking Successful</h2>
        <p>Your booking has been added to the time sheet.</p>
    </div>
<?php } elseif (isset($_GET["message"]) && $_GET["message"] == "edit_successful") { ?>
    <div class="message_box success">
        <h2>Booking Edit Successful</h2>
        <p>Your booking edit was successful.</p>
    </div>
<?php } ?>

<?php
helper('form');

$GolfManager = model("GolfManagement");
$date = isset($_GET['date']) ? date($_GET['date']) : date('Y-m-d');
// Validation to ensure the target date is within 4 weeks of the current date
$date = $date < date('Y-m-d', strtotime(date('Y-m-d') . ' -4 weeks')) ? date('Y-m-d', strtotime(date('Y-m-d') . ' -4 weeks')) : $date;
$date = $date > date('Y-m-d', strtotime(date('Y-m-d') . ' +4 weeks')) ? date('Y-m-d', strtotime(date('Y-m-d') . ' +4 weeks')) : $date;
?>

<div id="deletion_overlay">
    <div id="content">
        <h2>You are about to delete a booking.</h2>
        <p>Are you sure you wish to delete this booking?</p>
        <p><span style="color: red;">This action cannot be reversed.</span></p>
        <div id="options">
            <form method="post" action="<?php echo site_url('/golf/booking/delete'); ?>">
                <input type="hidden" id="deleteId" name="deleteId">
                <input type="submit" value="Yes">
            </form>
            <button onclick="document.getElementById('deletion_overlay').style.display = 'none'">No</button>
        </div>
    </div>
</div>

<div id="booking_tee_sheet">
    <br>
    <div id="dateSelector">
        <?php
            // Create a calendar where the user can select a date from a date picker
            echo form_open(site_url('/golf'), ['method'=>'get', 'id'=>'ds_w_calendar']);
            echo form_input('date', date('Y-m-d', strtotime($date)), ['id'=>'date_picker', 'oninput'=>'document.getElementById("ds_w_calendar").submit();', 'min'=>date('Y-m-d', strtotime(date('Y-m-d') . ' -4 weeks')), 'max'=>date('Y-m-d', strtotime(date('Y-m-d') . ' +4 weeks'))], 'date');
            echo form_close();
            // Create a button to change to the previous date
            echo form_open(site_url('/golf'), ['method'=>'get', 'id'=>'date_selector_tee_sheet']);
            echo form_input('date', date('Y-m-d', strtotime($date . ' -1 day')), null, 'hidden');
            echo form_submit('submit', 'Previous Day');
            echo form_close();
        ?>
        <h2>Tee Sheet for <?php echo date('l jS F Y', strtotime($date)); ?></h2>
        <?php
            // Create a button to change to the next date
            echo form_open(site_url('/golf'), ['method'=>'get', 'id'=>'date_selector_tee_sheet']);
            echo form_input('date', date('Y-m-d', strtotime($date . ' +1 day')), null, 'hidden');
            echo form_submit('submit', 'Next Day');
            echo form_close();
            // Create a button to change to the current server date
            echo form_open(site_url('/golf'), ['method'=>'get', 'id'=>'date_selector_tee_sheet']);
            echo form_input('date', date('Y-m-d'), null, 'hidden');
            echo form_submit('submit', 'Today');
            echo form_close();
        ?>
    </div>
    <br>
    <div id="teeSheetBox" class="detailed">
        <table class="teeSheet">
            <tr>
                <th>Time</th>
                <th>Player 1</th>
                <th>Player 2</th>
                <th>Player 3</th>
                <th>Player 4</th>
            </tr>
            <?php
            $times = $GolfManager->GetTimesForDate($date);
            foreach ($times as $time)
            {
                $booking_details = $GolfManager->GetBookingAtTime($date, $time);
                ?>
                    <tr>
                        <td><?php echo '<p>'.$time.'</p>';

                        if (($booking_details["players"][0][1] ?? "") == "")
                        { ?>
                            <form id="btn_new_booking" method="get" action="<?php echo site_url('/golf/booking/create'); ?>">
                                <input type="hidden" name="time" value="<?php echo $time; ?>">
                                <input type="hidden" name="date" value="<?php echo $date; ?>">
                                <input type="submit" value="+">
                            </form>
                        <?php } else { // Allow the user to see edit and delete buttons if they are an admin or the user who created the booking
                            if ( (session()->has('privilegeLevel') && session()->get('privilegeLevel') >= 5) || $booking_details["players"][0][0] == session()->get('userId') ) // If they're staff
                            { ?>
                                <a id="btn_edit_booking" href="<?php echo site_url('/golf/booking/' . $booking_details["id"]); ?>">EDIT</a>
                                <button id="btn_delete_booking" onclick="document.getElementById('deletion_overlay').style.display = 'flex'; document.getElementById('deleteId').setAttribute('value', <?php echo $booking_details['id']; ?>)">DELETE</button>
                            <?php }
                        }
                        ?></td>
                        <td><?php echo $booking_details["players"][0][1] ?? "" ?></td>
                        <td><?php echo $booking_details["players"][1][1] ?? "" ?></td>
                        <td><?php echo $booking_details["players"][2][1] ?? "" ?></td>
                        <td><?php echo $booking_details["players"][3][1] ?? "" ?></td>
                    </tr>
            <?php } ?>
        </table>
    </div>
</div>