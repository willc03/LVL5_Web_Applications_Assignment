<?php
helper('form');

$GolfManager = model("GolfManagement");
$date = isset($_GET['date']) ? date($_GET['date']) : date('Y-m-d');
?>

<div id="booking_tee_sheet">
    <br>
    <div id="dateSelector">
        <?php
            echo form_open(site_url('/golf'), ['method'=>'get', 'id'=>'ds_w_calendar']);
            echo form_input('date', date('Y-m-d', strtotime($date)), ['id'=>'date_picker', 'oninput'=>'document.getElementById("ds_w_calendar").submit();', 'min'=>date('Y-m-d', strtotime(date('Y-m-d') . ' -4 weeks')), 'max'=>date('Y-m-d', strtotime(date('Y-m-d') . ' +4 weeks'))], 'date');
            echo form_close();
            $prev_date = date('Y-m-d', strtotime($date . ' -1 day')) < date('Y-m-d', strtotime(date('Y-m-d') . ' -4 weeks')) ? date('Y-m-d', strtotime(date('Y-m-d') . ' -4 weeks')) : date('Y-m-d', strtotime($date . ' -1 day'));
            echo form_open(site_url('/golf'), ['method'=>'get', 'id'=>'date_selector_tee_sheet']);
            echo form_input('date', $prev_date, null, 'hidden');
            echo form_submit('submit', 'Previous Day');
            echo form_close();
        ?>
        <h2>Tee Sheet for <?php echo date('l jS F Y', strtotime($date)); ?></h2>
        <?php
        $next_date = date('Y-m-d', strtotime($date . ' +1 day')) > date('Y-m-d', strtotime(date('Y-m-d') . ' +4 weeks')) ? date('Y-m-d', strtotime(date('Y-m-d') . ' +4 weeks')) : date('Y-m-d', strtotime($date . ' +1 day'));
        echo form_open(site_url('/golf'), ['method'=>'get', 'id'=>'date_selector_tee_sheet']);
        echo form_input('date', $next_date, null, 'hidden');
        echo form_submit('submit', 'Next Day');
        echo form_close();
        ?>
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