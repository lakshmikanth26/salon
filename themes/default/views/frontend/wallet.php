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
        <h2 class="blue"><i class="fa-fw fa fa-heart"></i><?= lang('wallet_used_list'); ?> </h2>
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
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <div class="small-box padding1010 borange">
                                <h4 class="bold"><?= lang('wallet') ?></h4>
                                <i class="fa fa-star"></i>

                                <h3 class="bold"><?= '0.0' ?></h3>

                                <p class="bold"><?= 'Wallet Amount' ?> </p>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="small-box padding1010 bdarkGreen">
                                <h4 class="bold"><?= lang('spent_amount') ?></h4>
                                <i class="fa fa-heart"></i>

                                <h3 class="bold"><?= '0.0' ?></h3>

                                <p class="bold"><?= 'Spent Amount' ?> </p>

                            </div>
                        </div>
                    </div>
                </div>
                
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('customize_report'); ?></p>

                
                <div class="clearfix"></div>

                <div class="table-responsive">
                    <table id="SlRData"
                           class="table table-bordered table-hover table-striped table-condensed reports-table">
                        <thead>
                        <tr>
                            <th><?= lang("date"); ?></th>
                            <th><?= lang("reference_no"); ?></th>
                            <th><?= lang("biller"); ?></th>
                            <th><?= lang("grand_total"); ?></th>
                            <th><?= lang("wallet_amount"); ?></th>
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