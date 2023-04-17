<h1>Members Portal</h1>

<div id="tee_sheet_overview">
    <h2>Tee Sheet Overview</h2>
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
            $GolfManager = model("GolfManagement");
            $times = $GolfManager->GetTimesForDate(date('Y-m-d'));
            foreach ($times as $time)
            {
                $booking_details = $GolfManager->GetBookingAtTime(date('Ymd'), $time);
                ?>
                <tr>
                    <td><?php echo $time; ?></td>
                    <td><?php echo $booking_details["players"][0] ?? "" ?></td>
                    <td><?php echo $booking_details["players"][1] ?? "" ?></td>
                    <td><?php echo $booking_details["players"][2] ?? "" ?></td>
                    <td><?php echo $booking_details["players"][3] ?? "" ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>