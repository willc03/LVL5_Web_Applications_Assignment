<?php
$GolfManager = model("GolfManagement");
$date = isset($_GET['date']) ? date($_GET['date']) : date('Y-m-d');
?>

<div id="booking_tee_sheet">
    <br>
    <div id="dateSelector">
        <form id="date_selector_tee_sheet" method="get" action="<?php echo site_url('/golf'); ?>">
            <input type="submit" value="Previous Day">
            <input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($date . ' -1 day')); ?>">
        </form>
        <h2>Tee Sheet for <?php echo date('l jS F Y', strtotime($date)); ?></h2>
        <form id="date_selector_tee_sheet" method="get" action="<?php echo site_url('/golf'); ?>">
            <input type="submit" value="Next Day">
            <input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($date . ' +1 day')); ?>">
        </form>
    </div>
    <br>
    <div id="teeSheetBox">
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

                        if (($booking_details["players"][0] ?? "") == "")
                        { ?>
                            <form id="btn_new_booking" method="get" action="<?php echo site_url('/golf/booking/create'); ?>">
                                <input type="hidden" name="time" value="<?php echo $time; ?>">
                                <input type="hidden" name="date" value="<?php echo $date; ?>">
                                <input type="submit" value="+">
                            </form>
                        <?php }

                        ?></td>
                        <td><?php echo $booking_details["players"][0] ?? "" ?></td>
                        <td><?php echo $booking_details["players"][1] ?? "" ?></td>
                        <td><?php echo $booking_details["players"][2] ?? "" ?></td>
                        <td><?php echo $booking_details["players"][3] ?? "" ?></td>
                    </tr>
            <?php } ?>
        </table>
    </div>
</div>