<script>
    $(document).ready(function () {
        function getQueryParam(param) {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }
        
        $.get('customers/getCustomerCount', function(data) {
            $('#maleCountElement').text(data.maleCount);
            $('#femaleCountElement').text(data.femaleCount);
            $('#memberCountElement').text(data.memberCount);
            $('#nonMemberCountElement').text(data.nonMemberCount);
            $('#totalCount').text(data.totalRecords);
        });

        var oTable = $('#CusData').dataTable({
            "aaSorting": [[1, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('customers/getCustomers') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                var group = getQueryParam('group');
                var expiresIn = getQueryParam('expiresIn');
                if (group) {
                    aoData.push({
                        "name": "group",
                        "value": group
                    });
                }
                if (expiresIn) {
                    aoData.push({
                        "name": "expiresIn",
                        "value": expiresIn
                    });
                }
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{
                "bSortable": false,
                "mRender": checkbox
            }, null, null, null, null, null,null, {"bSortable": false}]
        }).dtFilter([
            {column_number: 1, filter_default_label: "[<?=lang('name');?>]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('email');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('phone');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('customer_group');?>]", filter_type: "text", data: []},
            {column_number: 5, filter_default_label: "[<?=lang('city');?>]", filter_type: "text", data: []},
            {column_number: 6, filter_default_label: "[<?=lang('award_points');?>]", filter_type: "text", data: []},
        ], "footer");
    });
</script>
<?php if ($Owner) {
    echo form_open('customers/customer_actions', 'id="action-form"');
} ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-users"></i><?= lang('customers'); ?></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-tasks tip"
                                                                                  data-placement="left"
                                                                                  title="<?= lang("actions") ?>"></i></a>
                    <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li><a href="<?= site_url('customers/add'); ?>" data-toggle="modal" data-target="#myModal"
                               id="add"><i class="fa fa-plus-circle"></i> <?= lang("add_customer"); ?></a></li>
                        <li><a href="<?= site_url('customers/import_csv'); ?>" data-toggle="modal"
                               data-target="#myModal"><i class="fa fa-plus-circle"></i> <?= lang("import_by_csv"); ?>
                            </a></li>
                        <?php if ($Owner) { ?>
                            <li><a href="#" id="excel" data-action="export_excel"><i
                                        class="fa fa-file-excel-o"></i> <?= lang('export_to_excel') ?></a></li>
                            <li><a href="#" id="pdf" data-action="export_pdf"><i
                                        class="fa fa-file-pdf-o"></i> <?= lang('export_to_pdf') ?></a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="bpo" title="<b><?= $this->lang->line("delete_customers") ?></b>"
                                   data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger' id='delete' data-action='delete'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button>"
                                   data-html="true" data-placement="left"><i
                                        class="fa fa-trash-o"></i> <?= lang('delete_customers') ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                        <th scope="col">Total Male Customers : <span id="maleCountElement"></span></th>
                        <th scope="col">Total Female Customers : <span id="femaleCountElement"></span></th>
                        <th scope="col">Total Member Customers : <span id="memberCountElement"></span></th>
                        <th scope="col">Total Non-Member Customers : <span id="nonMemberCountElement"></span></th>
                        <th scope="col">Total Customers : <span id="totalCount"></span></th>
                        </tr>
                    </thead>
                </table>
                <p class="introtext" style="margin-top: -20px; margin-bottom: 20px; margin-left: 0px; margin-right: 0px;"><?= lang('list_results'); ?></p>
                
                <div class="table-responsive">
                    <table id="CusData" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr class="primary">
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkth" type="checkbox" name="check"/>
                            </th>
                            <th style="text-align: center;"><?= lang("name"); ?></th>
                            <th><?= lang("email_address"); ?></th>
                            <th><?= lang("phone"); ?></th>
                            <th><?= lang("customer_group"); ?></th>
                            <th><?= lang("city"); ?></th>
                            <th><?= lang("award_points"); ?></th>
                            <th><?= lang("actions"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="10" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                        </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th style="text-align: center;">
                                <input class="checkbox checkft" type="checkbox" name="check"/>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-center"><?= lang("actions"); ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($Owner) { ?>
    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
        <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
    </div>
    <?= form_close() ?>
<?php } ?>
<?php if ($action && $action == 'add') {
    echo '<script>$(document).ready(function(){$("#add").trigger("click");});</script>';
}
?>
<?php
    echo form_open('customers/customer_all_actions', 'id="action-form1"');
    ?>  
    <a href="#" id="export_all" data-action="export_all_excel"><i class="fa fa-file-excel-o"></i> <?= lang('export_all_excel') ?></a>
    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action1"/>
        <?= form_submit('performAction', 'performAction', 'id="action-form-submit1"') ?>
    </div>
    
    <?php echo form_close(); ?>


	

