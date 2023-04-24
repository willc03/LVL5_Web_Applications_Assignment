<h1>User Management</h1>
<br>
<div class="manage_usr">
    <div class="introduction">
        <p>This facility will allow you to edit the details of or delete user accounts.</p>
        <?php if (session()->has('privilegeLevel') && session()->get('privilegeLevel') == 6) { ?>
            <p>As a level 6 user, you are allowed to promote other users to staff-level accounts.</p>
        <?php } elseif (session()->has('privilegeLevel') && session()->get('privilegeLevel') == 5) { ?>
            <p>As you are a level 5 user, you can not make other accounts staff accounts.</p>
        <?php } ?>
    </div>
    <br>
    <div class="initial_interaction" id="initial_interaction">
        <?php
        helper('form'); // Load the form helper
        echo form_label('Name:', 'name')
           . form_input('name', '', ['id'=>'username_input_el']);
        ?>
        <script>
            var availableTags = [];
            $.ajax({
                url: '<?php echo site_url('/api/members/get'); ?>',
                method: 'GET',
                success: function(response) {
                    availableTags = JSON.parse(response);
                    $( "#username_input_el" ).autocomplete({
                        source: availableTags,
                        select: function( event, ui ) {
                            // Hide this section of the form
                            document.getElementById('initial_interaction').style.display = 'none';
                            // Display the next segment of the form
                            $.ajax({
                                url: '<?php echo site_url('/api/admin/advancedmemberget/'); ?>' + ui.item.value,
                                method: 'GET',
                                success: function(response) {
                                    response = JSON.parse(response);
                                    document.getElementById('uid').value = response.UserId;
                                    document.getElementById('fname').value = response.Firstname;
                                    document.getElementById('lname').value = response.Lastname;
                                    document.getElementById('email').value = response.Email;
                                    const addrItems = response.Address.split(', ');
                                    document.getElementById('ad1').value = addrItems[0];
                                    document.getElementById('ad2').value = addrItems[1];
                                    document.getElementById('town').value = addrItems[2];
                                    document.getElementById('county').value = addrItems[3];
                                    document.getElementById('pcode').value = addrItems[4];
                                    let dateStr = response.DateOfBirth;
                                    let parts = dateStr.split("-");
                                    let formattedDate = `${parts[2]}/${parts[1]}/${parts[0]}`;
                                    document.getElementById('dob').value = formattedDate;
                                    const select = document.querySelector('#u_lvl');
                                    select.value = response.PrivilegeLevel;
                                    document.getElementById('main_interaction').style.display = 'block';
                                }
                            });
                        }
                    });
                }
            });
        </script>
    </div>
    <div class="main_interaction" id="main_interaction" style="display: none;">
        <?php
        $accountTypes = ['1'=>'Visitor', '2'=>'Junior Member', '3'=>'Social Member', '4'=>'Full Member'];
        if (session()->has('privilegeLevel') && session()->get('privilegeLevel') == 6)
        {
            $accountTypes['5'] = 'Staff';
        } else
        {
            $accountTypes['5'] = 'N/A';
        }
        $accountTypes['6'] = 'N/A';
        echo form_open(site_url('/admin/users'), ['id'=>'detailForm'])
            . form_input(['type'=>'hidden','name'=>'uid','id'=>'uid', 'value'=>'null'])
            . form_label('First name: ', 'fname')
            . form_input('fname', '', ['required'=>'', 'id'=>'fname'])
            . form_label('Last name: ', 'lname')
            . form_input('lname', '', ['required'=>'', 'id'=>'lname'])
            . form_label('Date of birth: ', 'dob')
            . form_input('dob', '', ['required'=>'', 'id'=>'dob']) . '<br>'
            . form_label('Address line 1:', 'ad1')
            . form_input('ad1', '', ['required'=>'', 'id'=>'ad1'])
            . form_label('Address line 2:', 'ad2')
            . form_input('ad2', '', ['required'=>'', 'id'=>'ad2'])
            . form_label('Town:', 'town')
            . form_input('town', '', ['required'=>'', 'id'=>'town'])
            . form_label('County:', 'county')
            . form_input('county', '', ['required'=>'', 'id'=>'county'])
            . form_label('Postcode:', 'pcode')
            . form_input('pcode', '', ['required'=>'', 'id'=>'pcode']) . '<br>'
            . form_label('Email:', 'email')
            . form_input('email', '', ['required'=>'', 'id'=>'email'], 'email')
            . form_label('User access level:', 'u_lvl')
            . form_dropdown('u_lvl', $accountTypes, '', ['required'=>'', 'id'=>'u_lvl'])
            . form_close();
        ?>
        <script>
                $( "#dob" ).datepicker({
                    dateFormat: "dd/mm/yy"
                });
        </script>
        <div class="submitsection">
            <script>
                function onCancel()
                {
                    document.getElementById('username_input_el').value = '';
                    document.getElementById('initial_interaction').style.display = 'block';
                    document.getElementById('main_interaction').style.display = 'none';
                }
                function onSubmit()
                {
                    document.getElementById('detailForm').submit();
                }
            </script>
            <br>
            <div style="display: flex; justify-content: space-around; width: 50%; margin: 0 auto;">
                <button onclick="onCancel()">Cancel</button>
                <button onclick="onSubmit()">Save Changes</button>
            </div>
        </div>
    </div>
</div>