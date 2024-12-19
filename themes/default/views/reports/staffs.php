<?php
$v = "";
    $v .= "&start=" . urlencode($start);
    $v .= "&end=" . urlencode($end);

?>
<script>$(document).ready(function () {
        CURI = '<?= site_url('reports/staffs'); ?>';
    });</script>
<script>
    $(document).ready(function () {
        var oTable = $('#StaffData').dataTable({
            "aaSorting": [[0, "asc"], [1, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": -1,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('reports/getStaffs?v=1' . $v) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [null, null, null, null, {
                "mRender": decimalFormat,
                "bSearchable": false
            },{"mRender": currencyFormat, "bSearchable": false},{"mRender": currencyFormat, "bSearchable": false}, {"mRender": currencyFormat, "bSearchable": false}, {"mRender": currencyFormat, "bSearchable": false}, {"mRender": currencyFormat, "bSearchable": false}],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var gtotal = 0, tsmem = 0, ts = 0,non_member=0,member=0,net_amount=0;discount=0;
                for (var i = 0; i < aaData.length; i++) {
                    ts += parseFloat(aaData[aiDisplay[i]][3]);
                    tsmem += parseFloat(aaData[aiDisplay[i]][4]);
                    non_member += parseFloat(aaData[aiDisplay[i]][5]);
                    member += parseFloat(aaData[aiDisplay[i]][6]);
                    discount += parseFloat(aaData[aiDisplay[i]][7]);
                    net_amount += parseFloat(aaData[aiDisplay[i]][8]);
                    gtotal += parseFloat(aaData[aiDisplay[i]][9]);
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[3].innerHTML = currencyFormat(parseFloat(ts));
                nCells[4].innerHTML = currencyFormat(parseFloat(tsmem));
                nCells[9].innerHTML = currencyFormat(parseFloat(gtotal));
                nCells[5].innerHTML = currencyFormat(parseFloat(non_member));
                nCells[7].innerHTML = currencyFormat(parseFloat(discount));
                nCells[8].innerHTML = currencyFormat(parseFloat(net_amount));
                nCells[6].innerHTML = currencyFormat(parseFloat(member));
            }
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 0, filter_default_label: "[<?=lang('name');?>]", filter_type: "text", data: []},
            {column_number: 1, filter_default_label: "[<?=lang('phone');?>]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('email_address');?>]", filter_type: "text", data: []},
        ], "footer");
    });
</script>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-users"></i><?= lang('staffs'); ?></h2>
        <div class="box-icon">
            <div class="form-group choose-date hidden-xs">
                <div class="controls">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text"
                               value="<?= ($start ? $this->sma->hrld($start) : '') . ' - ' . ($end ? $this->sma->hrld($end) : ''); ?>"
                               id="daterange" class="form-control">
                        <span class="input-group-addon"><i class="fa fa-chevron-down"></i></span>
                    </div>
                </div>
            </div>
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

                <p class="introtext"><?= lang('view_report_staff'); ?></p>

                <div class="table-responsive">
                    <table id="StaffData" cellpadding="0" cellspacing="0" border="0"
                           class="table table-bordered table-condensed table-hover table-striped reports-table">
                        <thead>
                        <tr class="primary">
                            <th><?= lang("name"); ?></th>
                            <th><?= lang("phone"); ?></th>
                            <th><?= lang("email_address"); ?></th>
                            <th><?= lang("total_billes"); ?></th>
                            <th><?= lang("new_membership_sold"); ?></th>
                            <th><?= lang("Non_member"); ?></th>
                            <th><?= lang("member"); ?></th>
                            <th><?= lang("discount"); ?></th>
                            
                            <th><?= lang("net_amount"); ?></th>
                            <th><?= lang("gross_amount"); ?></th>
                           
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="9" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                        </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th></th>
                            <th></th>
                            <th></th>
                           <th><?= lang("total_billes"); ?></th>
                            <th><?= lang("total_membership_sold"); ?></th>
                            <th><?= lang("Non_member"); ?></th>
                            <th><?= lang("member"); ?></th>
                            <th><?= lang("discount"); ?></th>
                            
                            <th><?= lang("net_amount"); ?></th>
                            <th><?= lang("gross_amount"); ?></th>
                           
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
            window.location.href = "<?=site_url('reports/getStaffs/pdf')?>/?start="+ encodeURIComponent('<?=$start?>') + "&end=" + encodeURIComponent('<?=$end?>');
            return false;
        });
        $('#xls').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('reports/getStaffs/0/xls')?>/?start="+ encodeURIComponent('<?=$start?>') + "&end=" + encodeURIComponent('<?=$end?>');
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