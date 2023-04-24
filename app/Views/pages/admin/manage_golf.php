<?php
    $GolfManager = model("GolfManagement");
?>
<style>
    body {
        color: var(--primary-white);
    }
</style>


<h1>Golf Management</h1>
<br>
<div class="introduction">
    <p>This facility will allow you to manage the times at which users are able to book golf on days you set.</p>
    <p>Please note that the default times cannot be removed. Days which don't have times set will use these times.</p>
    <br>
    <p>To override an existing time period, add another instance covering the desired range.</p>
</div>
<br>
<h2>Current allowed times</h2>
<br>
<?php $todayTimes = $GolfManager->GetTimeSettingsOnDate(date('Y-m-d')); ?>
<table class="teeSheet" style="width: 50%">
    <tr>
        <th>Setting</th>
        <th>Value</th>
    </tr>
    <tr>
        <td>Beginning Date</td>
        <td><?php echo $todayTimes[1] == '1970-01-01' ? 'DEFAULT' : $todayTimes[1] ?></td>
    </tr>
    <tr>
        <td>End Date</td>
        <td><?php echo $todayTimes[2] == '1970-01-01' ? 'DEFAULT' : $todayTimes[2] ?></td>
    </tr>
    <tr>
        <td>Earliest set time</td>
        <td><?php echo $todayTimes[0][0]; ?></td>
    </tr>
    <tr>
        <td>Latest time available</td>
        <td><?php echo $todayTimes[0][count($todayTimes[0])-1]; ?></td>
    </tr>
    <tr>
        <td>Delay between times (HH:MM:SS)</td>
        <td><?php echo $todayTimes[3]; ?></td>
    </tr>
</table>
<br>
<div class="button_row">
    <?php
    helper('form');
    if ($todayTimes[1] != '1970-01-01') {
        echo form_open('/admin/golf/removetimeset')
            . csrf_field()
            . form_submit(['value'=>'Remove today\'s time constraints'])
            . form_hidden('timeid', $todayTimes[4])
            . form_close();
    }
    echo form_submit(['value'=>'Add time override', 'onclick'=>"document.getElementById('form_content').style.display = 'block';"])
    ?>
</div>
<br>
<div class="form_content" id="form_content" style="display: none">
    <h3 style="text-align: center">Add a new time override</h3>
    <br>
    <?php
        echo form_open('/admin/golf/addtimeset') .
            csrf_field() .
            form_label("Start Date:") .
            form_input('startDate', date('Y-m-d'), ['id'=>'startDate', 'required'=>'']) . "<br>" .
            form_label("End Date:") .
            form_input('endDate', date('Y-m-d'), ['id'=>'endDate', 'required'=>'']) . "<br>" .
            form_label("Start Time:") .
            form_dropdown('stime', $GolfManager->GetAllTimes(), "", ['id'=>'stime', 'required'=>'']) . "<br>" .
            form_label("End Time:") .
            form_dropdown('etime', $GolfManager->GetAllTimes(), "", ['id'=>'etime', 'required'=>'']) . "<br>" .
            form_label("Time Increment:") .
            form_dropdown('timeinc', $GolfManager->GetAllIncrements(), "", ['id'=>'timeinc', 'required'=>'']) . "<br>" .
            form_submit("submit", "Add new times");
    ?>
    <script>
        $( function() {
            var dateFormat = "yy-mm-dd",
                from = $( "#startDate" )
                    .datepicker({
                        changeMonth: true,
                        numberOfMonths: 1
                    })
                    .on( "change", function() {
                        to.datepicker( "option", "minDate", getDate( this ) );
                    }),
                to = $( "#endDate" ).datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1
                })
                    .on( "change", function() {
                        from.datepicker( "option", "maxDate", getDate( this ) );
                    });

            function getDate( element ) {
                var date;
                try {
                    date = $.datepicker.parseDate( dateFormat, element.value );
                } catch( error ) {
                    date = null;
                }

                return date;
            }
        });
    </script>
</div>
<br>
<h2>Tee Sheet Overview</h2>
<br>
<div id="teeSheetBox" class="overview" style="width: 70%;">
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