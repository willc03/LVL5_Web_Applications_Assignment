<h1>Members Portal</h1>

<div class="q" style="display: flex; width: 50%; justify-content: space-around">
    <a class="stripped" href="<?php echo site_url("/members/bar/"); ?>" style="padding: 10px;">Go to bar</a>
    <a class="stripped" href="<?php echo site_url("/golf/"); ?>" style="padding: 10px;">Book golf</a>
</div>

<div id="tee_sheet_overview" style="margin-top: 25px">
    <h2 style="margin-bottom: 5px;">Tee Sheet Overview</h2>
    <div id="teeSheetBox" class="overview">
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
                    <td><?php echo $booking_details["players"][0][1] ?? "" ?></td>
                    <td><?php echo $booking_details["players"][1][1] ?? "" ?></td>
                    <td><?php echo $booking_details["players"][2][1] ?? "" ?></td>
                    <td><?php echo $booking_details["players"][3][1] ?? "" ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>