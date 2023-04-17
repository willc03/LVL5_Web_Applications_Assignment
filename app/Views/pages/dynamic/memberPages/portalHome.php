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
            $start_time = strtotime('7:00 AM');
            $end_time = strtotime('7:00 PM');

            $current_time = $start_time;

            $um = model("GolfManagement");
            $times = $um->GetTimesForDate(date('Y-m-d'));
            foreach ($times as $time)
            { ?>
                <tr>
                    <td><?php echo $time; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>