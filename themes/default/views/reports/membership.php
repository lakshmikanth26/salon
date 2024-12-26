<?php
$v = "";
if ($this->input->post('start_date')) {
    $v .= "&start_date=" . $this->input->post('start_date');
}
if ($this->input->post('end_date')) {
    $v .= "&end_date=" . $this->input->post('end_date');
}
?>
<script>
    function reloadPage() {
        document.getElementById('start_date').value = '';
        document.getElementById('end_date').value = '';
        window.location.reload();
    }
    $(document).ready(function () {

        function formatDate(data) {
            if (!data) return '';
            const date = new Date(data);
            if (isNaN(date.getTime())) return data;
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        var oTable = $('#MembershipRData').dataTable({
            "aaSorting": [[2, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('reports/getMembershipReport/?v=1'.$v) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [
                null, //sale_id
                {"mRender": formatDate}, // sold date
                null, // name
                null, // number
                null, // plan
                {"mRender": formatDate}, // end date
            ]
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 0, filter_default_label: "[<?= lang('Sale_Id');?>]", filter_type: "text", data: []},
            {column_number: 1, filter_default_label: "[<?= lang('Sold_Date');?>]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?= lang('Customer_Name');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?= lang('Phone');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?= lang('Member_Plan');?>]", filter_type: "text", data: []},
            {column_number: 5, filter_default_label: "[<?= lang('Validity');?>]", filter_type: "text", data: []},
        ], "footer");

        // Sl | Date(sold Date) | Customer | customer number | member plan(product name) | validity (expiry date)
    });
</script>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-users"></i><?= lang('membership_report'); ?> <?php
            if ($this->input->post('start_date')) {
                echo "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
            }
            ?></h2>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="#" id="pdf" class="tip" title="<?= lang('download_pdf') ?>"><i
                            class="icon fa fa-file-pdf-o"></i></a></li>
                <li class="dropdown"><a href="<?= site_url('reports/getMembershipReport/0/1')?>" id="xls" class="tip" title="<?= lang('download_xls') ?>"><i
                            class="icon fa fa-file-excel-o"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('customize_report'); ?></p>

                <div id="form">
                    <?php echo form_open("reports/membership"); ?>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("start_date", "start_date"); ?>
                                <?php echo form_input('start_date', (isset($_POST['start_date']) ? $_POST['start_date'] : ""), 'class="form-control date" id="start_date"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("end_date", "end_date"); ?>
                                <?php echo form_input('end_date', (isset($_POST['end_date']) ? $_POST['end_date'] : ""), 'class="form-control date" id="end_date"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:49px;display:flex;gap:8px;">
                        <div class="controls">
                            <?php echo form_submit('submit_report', lang("submit"), 'class="btn btn-primary"'); ?> 
                        </div>
                        <div class="controls">
                           <button class="btn btn-danger" onclick="reloadPage()">Reset</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>

                <div class="table-responsive">
                    <table id="MembershipRData"
                           class="table table-striped table-bordered table-condensed table-hover reports-table"
                           style="margin-bottom:5px;">
                        <thead>
                        <tr class="active">
                            <th><?= lang("Sale_Id"); ?></th>
                            <th><?= lang("Sold_Date"); ?></th>
                            <th><?= lang("Customer_Name"); ?></th>
                            <th><?= lang("Phone"); ?></th>
                            <th><?= lang("Member_Plan"); ?></th>
                            <th><?= lang("Validity"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="8" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                        </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
