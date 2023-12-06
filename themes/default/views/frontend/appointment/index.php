

<script type="text/javascript">
var site = <?=json_encode(array('base_url' => base_url(), 'settings' => $Settings, 'dateFormats' => $dateFormats))?>;

</script>

<div class="box" style="margin-bottom: 15px;">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-bar-chart-o"></i><?= lang('appointments'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-md-12">
                <p class="introtext"><?php echo lang('appointment_heading'); ?></p>
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
    




<style type="text/css">body .fc {
  overflow:auto;
}</style>

<link rel="stylesheet" href="<?= $assets ?>bootstrap-datepicker/bootstrap-datepicker.min.css">
    
<script src="<?= $assets ?>bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="<?= $assets ?>fullcalendar/dist/old/fullcalendar.css">

<script src="<?= $assets ?>js/moment.min.js"></script>

<script src="<?= $assets ?>fullcalendar/dist/old/fullcalendar.min.js"></script>

<script src="<?= $assets ?>js/user_fullcalendar-init.js"></script>


    
<script type="text/javascript">


    $(document).ready(function(){


        var today = new Date();

        $('#time1').timepicker();

        $('#time2').timepicker();

        $('#time3').timepicker();

        $('#time4').timepicker();


        

        $('.a12datepicker').timepicker({
            timeFormat: 'h:mm p',
            minuteStep: 10
        });

        $('.a22datepicker').timepicker({
            timeFormat: 'h:mm p',
            minuteStep: 10
        });
        $('.a32datepicker').timepicker({
            timeFormat: 'h:mm p',
            minuteStep: 10
        });

        $('.a42datepicker').timepicker({
            timeFormat: 'h:mm p',
            minuteStep: 10
        });

        $('#time4').timepicker();
        $('#event_end_time').timepicker();
        $('#event_start_time').timepicker();
        
        $('#event_start_date').datepicker({

            format: 'dd-mm-yyyy',

            autoclose: true,

        });


        $('#event_end_date').datepicker({

            format: 'dd-mm-yyyy',

            autoclose: true,

        });
        $('.edit_event_start_date').change(function(){
            var start_date = $('#event_start_date').val();
            $('#event_end_date').val(start_date);
        });

        
        $('.a11datepicker').datepicker({

            format: 'dd-mm-yyyy',

            autoclose: true,

        });

        $('.a21datepicker').datepicker({

            format: 'dd-mm-yyyy',

            autoclose: true,

        });

        $("#add_event_mobile_no").focusout(function(){
            var mobile_no = $(this).val();
            $.get('<?php echo base_url('appointment/get_customer_details'); ?>',
            {
                phone: mobile_no
            },

            function (data) {

                var obj = JSON.parse(data);

                $('#add_event_name').val(obj.name);
                $('#add_event_email').val(obj.email);
                $('#new_event_title').val(obj.name);
                $('.contact_details').css('display','flex');
                

            });


        });

        

    });
</script>