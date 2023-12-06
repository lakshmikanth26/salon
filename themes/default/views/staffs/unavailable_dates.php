
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-users"></i><?= lang('staffs'); ?> - <?= $staff->name ?></h2>

    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('3 months unavailable dates'); ?></p>
                    <input type="hidden" name="id" class="form-control" id="id" value="<?= $staff->id ?>"/>
                       <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                <div class="table-responsive">
                     
                     <div id="show-next-month" data-toggle="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?= $assets ?>availability-calendar/assets/dateTimePicker.css">

    
<script type="text/javascript" src="<?= $assets ?>availability-calendar/scripts/components/jquery.min.js"></script>
    
<script type="text/javascript" src="<?= $assets ?>availability-calendar/scripts/dateTimePicker.min.js"></script>
    
    <style type="text/css">
        .datetimepicker > div {
            display: block;
        }
    </style>

<script type="text/javascript">
$(document).ready(function()
{
  var id = $("#id").val();
  
  $('#show-next-month').calendar({
    
    num_next_month: 2,
    num_prev_month: 0,
    adapter: site.base_url +'staffs/get_staffs_unavailable_dates/'+id,
    onSelectDate: function(date, month, year)
    {
        var cal = this;
        
        var selected_date = [year, month, date].join('-');
        var status = 'false';
        $.ajax(
        {
            type: 'post',

            url: site.base_url +'staffs/update_unavailable_dates',

            dataType: "json",

            data: {id:id,selected_date:selected_date},

            success: function(response)
            {
            cal.update();
            }

        });
        
    }
  });
});


</script>
	

