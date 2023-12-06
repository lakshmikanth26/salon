<?php
$v = "";
$v .= "&day=" .$day;
$v .= "&month=" .$month;
$v .= "&year=" . $year;
if ($this->input->post('warehouse')) {
    $v .= "&warehouse=" . $this->input->post('warehouse');
}
if ($this->input->post('invoice_type')) {
    $v .= "&invoice_type=" . $this->input->post('invoice_type');
}
if ($this->input->post('staff')) {
    $v .= "&staff=" . $this->input->post('staff');
}

?>

<script>
    $(document).ready(function () {
        var oTable = $('#SlRData').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('reports/getDailySalesListReport/?v=1' . $v) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{"mRender": fld}, null,null, null,null, null, {
                "bSearchable": false,
                "mRender": pqFormat
            }, {"mRender": currencyFormat},{"mRender": currencyFormat},null,null,null,null,null,null,null, {"mRender": currencyFormat}, {"mRender": currencyFormat}, {"mRender": row_status}],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var gtotal = 0, paid = 0, balance = 0, paid_by_cash = 0, paid_by_cc = 0, paid_by_bajaj = 0, paid_by_neft = 0, paid_by_paytm = 0, paid_by_cheque = 0;
                for (var i = 0; i < aaData.length; i++) {
                    gtotal += parseFloat(aaData[aiDisplay[i]][7]);
                    paid_by_cash += parseFloat(aaData[aiDisplay[i]][9]);
                    paid_by_cc += parseFloat(aaData[aiDisplay[i]][10]); 
                    paid_by_bajaj += parseFloat(aaData[aiDisplay[i]][11]);
                    paid_by_neft += parseFloat(aaData[aiDisplay[i]][12]);
                    paid_by_paytm += parseFloat(aaData[aiDisplay[i]][13]);
                    paid_by_cheque += parseFloat(aaData[aiDisplay[i]][14]);
                    paid += parseFloat(aaData[aiDisplay[i]][15]);
                    balance += parseFloat(aaData[aiDisplay[i]][16]);
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[7].innerHTML = currencyFormat(parseFloat(gtotal));
                nCells[9].innerHTML = currencyFormat(parseFloat(paid_by_cash));
                nCells[10].innerHTML = currencyFormat(parseFloat(paid_by_cc));
                nCells[11].innerHTML = currencyFormat(parseFloat(paid_by_bajaj));
                nCells[12].innerHTML = currencyFormat(parseFloat(paid_by_neft));
                nCells[13].innerHTML = currencyFormat(parseFloat(paid_by_paytm));
                nCells[14].innerHTML = currencyFormat(parseFloat(paid_by_cheque));
                nCells[15].innerHTML = currencyFormat(parseFloat(paid));
                nCells[16].innerHTML = currencyFormat(parseFloat(balance));
                      
            }
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 0, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
            {column_number: 1, filter_default_label: "[<?=lang('reference_no');?>]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('warehouse');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('biller');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('biller');?>]", filter_type: "text", data: []},
            {column_number: 5, filter_default_label: "[<?=lang('customer');?>]", filter_type: "text", data: []},
            {column_number: 17, filter_default_label: "[<?=lang('payment_status');?>]", filter_type: "text", data: []},
        ], "footer");
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#form').hide();
        <?php if ($this->input->post('customer')) { ?>
        $('#customer').val(<?= $this->input->post('customer') ?>).select2({
            minimumInputLength: 1,
            data: [],
            initSelection: function (element, callback) {
                $.ajax({
                    type: "get", async: false,
                    url: site.base_url + "customers/suggestions/" + $(element).val(),
                    dataType: "json",
                    success: function (data) {
                        callback(data.results[0]);
                    }
                });
            },
            ajax: {
                url: site.base_url + "customers/suggestions",
                dataType: 'json',
                quietMillis: 15,
                data: function (term, page) {
                    return {
                        term: term,
                        limit: 10
                    };
                },
                results: function (data, page) {
                    if (data.results != null) {
                        return {results: data.results};
                    } else {
                        return {results: [{id: '', text: 'No Match Found'}]};
                    }
                }
            }
        });

        $('#customer').val(<?= $this->input->post('customer') ?>);
        <?php } ?>
        $('.toggle_down').click(function () {
            $("#form").slideDown();
            return false;
        });
        $('.toggle_up').click(function () {
            $("#form").slideUp();
            return false;
        });
    });
</script>


<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-heart"></i><?= lang('daily_sales_report'); ?> </h2>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="#" class="toggle_up tip" title="<?= lang('hide_form') ?>"><i
                            class="icon fa fa-toggle-up"></i></a></li>
                <li class="dropdown"><a href="#" class="toggle_down tip" title="<?= lang('show_form') ?>"><i
                            class="icon fa fa-toggle-down"></i></a></li>
            </ul>
        </div>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="#" id="pdf" class="tip" title="<?= lang('download_pdf') ?>"><i
                            class="icon fa fa-file-pdf-o"></i></a></li>
                <li class="dropdown"><a href="#" id="xls" class="tip" title="<?= lang('download_xls') ?>"><i
                            class="icon fa fa-file-excel-o"></i></a></li>
                <li class="dropdown"><a href="#" id="image" class="tip" title="<?= lang('save_image') ?>"><i
                            class="icon fa fa-file-picture-o"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('customize_report'); ?></p>

                <div id="form">  

                    <?php echo form_open("reports/daily_sales_list/".$year."/".$month."/".$day); ?>
                    <div class="row">
                        <?php if ($this->Owner || $this->Admin) {
                        ?>
        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="warehouse"><?= lang("warehouse"); ?></label>
                                <?php
                                $wh[""] = "All";
                                foreach ($warehouses as $warehouse) {
                                    $wh[$warehouse->id] = $warehouse->name;
                                }
                                echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ""), 'class="form-control" id="warehouse" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("warehouse") . '"');
                                ?>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="warehouse"><?= lang("staff"); ?></label>
                                <?php
                                $st[""] = "All";
                                foreach ($staffs as $staff) {
                                    $st[$staff->id] = $staff->name;
                                }
                                echo form_dropdown('staff', $st, (isset($_POST['staff']) ? $_POST['staff'] : ""), 'class="form-control" id="staff" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("staff") . '"');
                                ?>
                            </div>
                        </div>
                        
        
                        <div class="col-sm-4">
                            <div class="form-group">
                                    <?= lang("invoice_types", "slinvoice_types"); ?>
                                    <?php
                                    $ino[''] = 'All';
                                    foreach ($invoice_types as $invoice_type) {
                                        $ino[$invoice_type->id] = $invoice_type->name;
                                    }
                                    echo form_dropdown('invoice_type', $ino, (isset($_POST['invoice_type']) ? $_POST['invoice_type'] : ""), 'id="slinvoice_type" class="form-control input-tip select" data-placeholder="' . lang("select") . ' ' . lang("invoice_types") . '" style="width:100%;" ');
                                    ?>
                                </div>
                            
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div
                            class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>

                <div class="clearfix"></div>

                <div class="table-responsive">
                    <table id="SlRData"
                           class="table table-bordered table-hover table-striped table-condensed reports-table">
                        <thead>
                        <tr>
                            <th><?= lang("date"); ?></th>
                            <th><?= lang("reference_no"); ?></th>
                            <th><?= lang("warehouse"); ?></th>
                            <th><?= lang("biller"); ?></th>
                            <th><?= lang("staff"); ?></th>
                            <th><?= lang("customer"); ?></th>
                            <th><?= lang("product_qty"); ?></th>
                            <th><?= lang("grand_total"); ?></th>
                            <th><?= lang("net_total");?></th>
                            <th><?= lang("paid_by"); ?></th> 
                            <th><?= lang("cash"); ?></th>
                            <th><?= lang("cc"); ?></th>
                            <th><?= lang("bajaj"); ?></th>
                            <th><?= lang("neft"); ?></th>
                            <th><?= lang("paytm"); ?></th>
                            <th><?= lang("cheque"); ?></th>
                            <th><?= lang("total_paid"); ?></th>
                            <th><?= lang("balance"); ?></th>
                            <th><?= lang("payment_status"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="16" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
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
                            <th><?= lang("product_qty"); ?></th>
                            <th><?= lang("grand_total"); ?></th>
                            <th><?= lang("paid_by"); ?></th>
                            <th><?= lang("cash"); ?></th>
                            <th><?= lang("cc"); ?></th>
                            <th><?= lang("bajaj"); ?></th>
                            <th><?= lang("neft"); ?></th>
                            <th><?= lang("paytm"); ?></th>
                            <th><?= lang("cheque"); ?></th>
                            <th><?= lang("total_paid"); ?></th>
                            <th><?= lang("balance"); ?></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#pdf').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('reports/getDailySalesListReport/pdf/?v=1'.$v)?>";
            return false;
        });
        $('#xls').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('reports/getDailySalesListReport/0/xls/?v=1'.$v)?>";
            return false;
        });
        $('#image').click(function (event) {
            event.preventDefault();
            html2canvas($('.box'), {
                onrendered: function (canvas) {
                    var img = canvas.toDataURL()
                    window.open(img);
                }
            });
            return false;
        });
    });
</script>