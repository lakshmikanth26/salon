<div class="clearfix"></div>
<?= '</div></div></div></div></div>'; ?>
<div class="clearfix"></div>
<footer><a href="#" id="toTop" class="blue"
           style="position: fixed; bottom: 30px; right: 30px; font-size: 30px; display: none;"><i
            class="fa fa-chevron-circle-up"></i></a>

    <p style="text-align:center;">&copy; <?= date('Y') . " " . $Settings->site_name; ?> (v<?= $Settings->version; ?>
        ) <?php if ($_SERVER["REMOTE_ADDR"] == '127.0.0.1') {
            echo ' - Page rendered in <strong>{elapsed_time}</strong> seconds';
        } ?></p>
</footer>
<?= '</div>'; ?>
<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div class="modal fade in" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true"></div>
<div id="modal-loading" style="display: none;">
    <div class="blackbg"></div>
    <div class="loader"></div>
</div>
<div id="ajaxCall"><i class="fa fa-spinner fa-pulse"></i></div>
<?php unset($Settings->setting_id, $Settings->smtp_user, $Settings->smtp_pass, $Settings->smtp_port, $Settings->update, $Settings->reg_ver, $Settings->allow_reg, $Settings->default_email, $Settings->mmode, $Settings->timezone, $Settings->restrict_calendar, $Settings->restrict_user, $Settings->auto_reg, $Settings->reg_notification, $Settings->protocol, $Settings->mailpath, $Settings->smtp_crypto, $Settings->corn, $Settings->customer_group, $Settings->envato_username, $Settings->purchase_code); ?>
<script type="text/javascript">
var dt_lang = <?=$dt_lang?>, dp_lang = <?=$dp_lang?>, site = <?=json_encode(array('base_url' => base_url(), 'settings' => $Settings, 'dateFormats' => $dateFormats))?>;
var lang = {paid: '<?=lang('paid');?>', pending: '<?=lang('pending');?>', completed: '<?=lang('completed');?>', ordered: '<?=lang('ordered');?>', received: '<?=lang('received');?>', partial: '<?=lang('partial');?>', sent: '<?=lang('sent');?>', r_u_sure: '<?=lang('r_u_sure');?>', due: '<?=lang('due');?>', transferring: '<?=lang('transferring');?>', active: '<?=lang('active');?>', inactive: '<?=lang('inactive');?>', unexpected_value: '<?=lang('unexpected_value');?>', select_above: '<?=lang('select_above');?>'};
</script>
<?php
$s2_lang_file = read_file('./assets/config_dumps/s2_lang.js');
foreach (lang('select2_lang') as $s2_key => $s2_line) {
    $s2_data[$s2_key] = str_replace(array('{', '}'), array('"+', '+"'), $s2_line);
}
$s2_file_date = $this->parser->parse_string($s2_lang_file, $s2_data, true);
?>
<script type="text/javascript" src="<?= $assets ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/jquery.dataTables.dtFilter.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/select2.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/jquery.calculator.min.js"></script>

<script type="text/javascript" src="<?= $assets ?>js/core.js"></script>

<script type="text/javascript" src="<?= $assets ?>js/perfect-scrollbar.min.js"></script>


    <!-- ================== PAGE LEVEL COMPONENT SCRIPTS ==================-->
    
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


<link rel="stylesheet" href="<?= $assets ?>bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<script src="<?= $assets ?>bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>

<script type="text/javascript" charset="UTF-8">var r_u_sure = "<?=lang('r_u_sure')?>";
    <?=$s2_file_date?>
    $.extend(true, $.fn.dataTable.defaults, {"oLanguage":<?=$dt_lang?>});
    $.fn.datetimepicker.dates['sma'] = <?=$dp_lang?>;
    $(window).load(function () {
        $('.mm_<?=$m?>').addClass('active');
        $('.mm_<?=$m?>').find("ul").first().slideToggle();
        $('#<?=$m?>_<?=$v?>').addClass('active');
        $('.mm_<?=$m?> a .chevron').removeClass("closed").addClass("opened");
    });
</script>

    <!-- Add event -->

        <div class="modal fade" id="modal_new_event" tabindex="-1" role="dialog" aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="exampleModalLabel1">Add Appointment</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body">

                        <form class="form-event" action="javascript:;">
                            <div class="form-group row">

                                <div class="col-md-12">
                                    <span class="control-label">Date : </span><span class="control-label" id="add_event_start_date_label"></span>
                                </div>
                            </div>
                            <div class="form-group row" style="display: none;">

                                <label for="editTitle" class="col-md-2 control-label">Title</label>

                                <div class="col-md-10">

                                    <input type="text" class="form-control new_event_title" required="required" id="new_event_title" name="new_event_title" placeholder="Event Name">

                                </div>

                            </div>

                            <div class="form-group row" style="display: none;">

                                <label for="allDay" class="col-md-2 control-label">All Day</label>

                                <div class="col-md-10">

                                    <div class="togglebutton m-t-5">

                                        <label>

                                            <input type="checkbox" class="js-switch1" id="allDay" checked />

                                        </label>

                                    </div>

                                </div>

                            </div>



                            <div class="form-group row" style="display:none;">

                                <label class="col-md-2 control-label">Start</label>

                                <div class="col-md-10">

                                    <div class="row">

                                        <div class="col p-0">

                                            <div class="form-group m-0">

                                                <div class="input-group">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-addon"><i class="icon dripicons-calendar"></i></span>

                                                    </div>

                                                    <input type="text" class="form-control a11datepicker" required="required" id="add_event_start_date" name="add_event_start_date" placeholder="Start Date">

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col">

                                            <div class="form-group row m-0">

                                                <div class="input-group">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-addon"><i class="icon dripicons-clock"></i></span>

                                                    </div>

                                                    <input type="text" class="form-control a12datepicker"  required="required" id="add_event_start_time" name="add_event_start_time" placeholder="Start Time">

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                            <div class="form-group row" style="display:none;">

                                <label  class="col-md-2 control-label">End</label>

                                <div class="col-md-10">

                                    <div class="row">

                                        <div class="col p-0">

                                            <div class="form-group m-0">

                                                <div class="input-group">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-addon"><i class="icon dripicons-calendar"></i></span>

                                                    </div>

                                                    <input type="text" class="form-control a21datepicker"  required="required" id="add_event_end_date" name="add_event_end_date" placeholder="End Date">

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col">

                                            <div class="form-group row m-0">

                                                <div class="input-group">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-addon"><i class="icon dripicons-clock"></i></span>

                                                    </div>

                                                    <input type="text" class="form-control a22datepicker"  required="required" id="add_event_end_time" name="add_event_end_time" placeholder="End Time">

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="form-group row">

                                <label for="location" class="col-md-4 control-label">Location</label>

                                <div class="col-md-8">

                                    <div class="togglebutton m-t-4">

                                            <select id="location" class="form-control select2" name="location"></select>
                                    
                                    </div>

                                </div>


                            </div>
                            <div class="form-group row">

                                <label for="service" class="col-md-4 control-label">Service</label>

                                <div class="col-md-8">

                                    <div class="togglebutton m-t-4">

                                            <select id="service" class="form-control select2" name="service"></select>
                                    
                                    </div>

                                </div>


                            </div>

                            <div class="form-group row">

                                <label for="staff" class="col-md-4 control-label">Staffs</label>

                                <div class="col-md-8">

                                    <div class="togglebutton m-t-4">

                                            <select id="staff" class="form-control select2" name="staff" onchange="selectSlots()"></select>
                                    
                                    </div>

                                </div>
                            </div>
                            <div class="form-group row">

                                <label for="booked_time" class="col-md-4 control-label">Slots</label>

                                <div class="col-md-8">

                                    <div class="togglebutton m-t-4">

                                            <select id="booked_time" class="form-control select2" name="booked_time"></select>
                                    
                                    </div>

                                </div>


                            </div>




                            
                            <div class="form-group row">

                                <label for="add_event_mobile_no" class="col-md-4 control-label">Mobile No</label>

                                <div class="col-md-8">

                                    <input type="text" class="form-control add_event_mobile_no" id="add_event_mobile_no"  required="required" name="add_event_mobile_no" placeholder="Mobile Number" value="<?php echo $this->session->userdata('user_identity'); ?>" autocomplete="false">

                                </div>

                            </div>

                            <div class="form-group row contact_details">

                                <label  class="col-md-2 control-label">Contact Details</label>

                                <div class="col-md-10">

                                    <div class="row">

                                        <div class="col-md-6">

                                            <div class="form-group m-0">

                                                <div class="input-group">

                                                    <input type="text" class="form-control"  required="required" id="add_event_name" name="add_event_name" placeholder="Name" autocomplete="false"  value="<?php echo $this->session->userdata('user_name'); ?>">

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group row m-0">

                                                <div class="input-group">

                                                    <input type="text" class="form-control"  id="add_event_email" name="add_event_email" placeholder="Email" autocomplete="false"  value="<?php echo $this->session->userdata('user_email'); ?>">

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <input type="hidden" id="new-event-start" />

                            <input type="hidden" id="new-event-end" />

                        </form>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>

                            <button type="submit" class="btn btn-primary" id="btn_add_event">Add Event</button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Edit event modal-->

        <div class="modal fade" id="modal_edit_event">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="exampleModalLabel2">Delete Appointment</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body">

                        <form class="edit-event__form">

                            <div class="form-group row" style="display: none;">

                                <label for="editTitle" class="col-md-2 control-label">Name</label>

                                <div class="col-md-10">

                                    <input type="text" class="form-control edit_event_title" id="editTitle" placeholder="Event Title">

                                </div>

                            </div>

                            <div class="form-group row" style="display: none;">

                                <label  class="col-md-2 control-label">Email</label>

                                <div class="col-md-4">

                                    <input type="text" class="form-control edit_event_email" id="edit_event_email" placeholder="Email">

                                </div>

                                <label  class="col-md-2 control-label">Mobile</label>

                                <div class="col-md-4">

                                    <input type="text" class="form-control edit_event_phone" id="edit_event_phone" placeholder="Mobile No">

                                </div>

                            </div>

                            <div class="form-group row" style="display: none;">

                                <label  class="col-md-2 control-label">Location</label>

                                <div class="col-md-4">

                                    <input type="text" class="form-control edit_event_location" readonly="readonly" id="edit_event_location" placeholder="Location">

                                </div>
                                <label  class="col-md-2 control-label">Service</label>

                                <div class="col-md-4">

                                    <input type="text" class="form-control edit_event_service" readonly="readonly" id="edit_event_service" placeholder="Service">

                                </div>


                            </div>
                            <div class="form-group row" style="display: none;">

                                <label  class="col-md-2 control-label">Staff</label>

                                <div class="col-md-10">

                                    <input type="text" class="form-control edit_event_staff" readonly="readonly" id="edit_event_staff" placeholder="Staff">

                                </div>


                            </div>
                            
                            <div class="form-group row" style="display: none;">

                                <label for="toggle-reschedule" class="col-md-6 control-label m-t-5">Re-schedule Appointment ?</label>

                                <div class="col-md-4">

                                    <div class="m-t-5">

                                            <input class="edit_reschedule" id="cb1" type="checkbox" name="edit_reschedule"><label class="tgl-btn" for="cb1"></label>
                                    
                                    </div>

                                </div>

                            </div>

                            <div class="form-group row reschedule-msg" style="display: none;">

                                <label class="col-md-12 control-label">Please Re-schedule Appointment by changing date and time</label>

                            </div>
                            

                            <div class="row" style="display: none;">

                                <label class="col-md-2 control-label">Start</label>

                                <div class="col-md-10">

                                    <div class="row">

                                        <div class="col-md-6">

                                            <div class="form-group m-0">

                                                    <input type="text" class="form-control datepicker edit_event_start_date" id="event_start_date" placeholder="Start Date">

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group m-0">

                                                    <input type="text" class="form-control datepicker edit_event_start_time" id="event_start_time" placeholder="Start Time">

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="row" style="display: none;">

                                <label  class="col-md-2 control-label">End</label>

                                <div class="col-md-10">

                                    <div class="row">

                                        <div class="col-md-6">

                                            <div class="form-group m-0">

                                                    
                                                    <input type="text" class="form-control datepicker edit_event_end_date" id="event_end_date" placeholder="End Date">

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group m-0">


                                                    
                                                    <input type="text" class="form-control datepicker edit_event_end_time" id="event_end_time" placeholder="End Time">


                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="form-group row" style="display: none;">

                                <label for="toggle-allDay" class="col-md-2 control-label">All Day</label>

                                <div class="col-md-10">

                                    <div class="togglebutton1 m-t-5">

                                        <label>

                                            <input type="checkbox" class="js-switch1" id="toggle-allDay" />

                                        </label>

                                    </div>

                                </div>

                            </div>

                            

                            <div class="form-group row" style="display: none;">

                                <label  class="col-md-2 control-label">Decision</label>

                                <div class="col-md-10">

                                    <div class="form-group m-t-5">

                                        <div class="event-tag event-tag-edit">


                                            <span class="brand-success">

                                                <input type="radio" value="1" name="event_tag" id="event-tag1" class="qt-fc-event-success">

                                                <i></i>

                                            </span><label>Approved</label>


                                            <span class="brand-warning">

                                                <input type="radio" value="0" name="event_tag" id="event-tag0" class="qt-fc-event-warning">

                                                <i></i>

                                            </span><label>

                                            Visited</label>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="form-group row" style="display: none;">

                                <label for="textArea" class="col-md-3 control-label">Desctiption</label>

                                <div class="col-md-9">
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            $('.edit_event_description').redactor('destroy');


                                        })
                                    </script>
                                    <textarea style="display: block !important" name="edit_event_description" rows="3" class="form-control edit_event_description" id="textArea" placeholder="Event Desctiption">
                                    </textarea>    
                                </div>

                            </div>

                            <input type="hidden" class="edit_event_id">
                            <input type="hidden" class="edit_customer_id">

                        </form>

                    </div>

                    <div class="modal-footer">

                        <div id="error">
                        </div>
                            

                        <button type="button" class="btn btn-danger btn-flat" data-calendar="delete">Delete</button>

                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancel</button>

                        <button type="button" class="btn btn-primary" data-calendar="update" style="display: none;">Update</button>

                    </div>

                </div>

                <!-- modal-content -->

            </div>

        </div>  
        

<script type="text/javascript">
    
    function selectSlots() {

        var staff = $('#staff').val();
        
        var selected_date = $('#add_event_start_date').val();

        $.get('<?php echo base_url('appointment/get_slots'); ?>',
        {
            id: staff, selected:selected_date
        },

        function (data) {

            $('#booked_time').html(data);

        });
    }
</script>

<style type="text/css">
    
</style>


 <link rel="stylesheet" href="<?= $assets ?>sweetalert2/dist/sweetalert2.min.css">

<script src="<?= $assets ?>sweetalert2/dist/sweetalert2.all.min.js"></script>





   
</body>
</html>
