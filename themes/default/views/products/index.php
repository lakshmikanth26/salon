<?php
$v = "";

if ($this->input->post('gst')) {
    $v .= "&gst=" . $this->input->post('gst');
}
if ($this->input->post('category')) {
    $v .= "&category=" . $this->input->post('category');
}
if ($this->input->post('subcategory')) {
    $v .= "&subcategory=" . $this->input->post('subcategory');
}
?>



<style type="text/css" media="screen">
    #PRData td:nth-child(6), #PRData td:nth-child(7) {
        text-align: right;
    }
    <?php if($Owner || $Admin || $this->session->userdata('show_cost')) { ?>
    #PRData td:nth-child(8) {
        text-align: right;
    }
    <?php } ?>
</style>
<script>
    var oTable;
    $(document).ready(function () {
        oTable = $('#PRData').dataTable({
            "aaSorting": [[2, "asc"], [3, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('products/getProducts'.($warehouse_id ? '/'.$warehouse_id : '').'?v=1' . $v) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData[0];
                nRow.className = "product_link";
                //if(aData[7] > aData[9]){ nRow.className = "product_link warning"; } else { nRow.className = "product_link"; }
                return nRow;
            },
            "aoColumns": [
                {"bSortable": false, "mRender": checkbox}, {
                    "bSortable": false,
                    "mRender": img_hl
                }, null, null, null, <?php if($Owner || $Admin) { echo '{"mRender": currencyFormat}, {"mRender": currencyFormat},'; } else { if($this->session->userdata('show_cost')) { echo '{"mRender": currencyFormat},';  } if($this->session->userdata('show_price')) { echo '{"mRender": currencyFormat},';  } } ?> {"mRender": decimalFormat}, null, <?php if(!$warehouse_id || !$Settings->racks) { echo '{"bVisible": false},'; } else { echo '{"bSortable": true},'; } ?> {"mRender": decimalFormat}, {"bSortable": false}
            ]
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 2, filter_default_label: "[<?=lang('product_code');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('product_name');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('category');?>]", filter_type: "text", data: []},
            <?php $col = 4;
            if($Owner || $Admin) {
                echo '{column_number : 5, filter_default_label: "['.lang('product_cost').']", filter_type: "text", data: [] },';
                echo '{column_number : 6, filter_default_label: "['.lang('product_price').']", filter_type: "text", data: [] },';
                $col += 2;
            } else {
                if($this->session->userdata('show_cost')) { $col++; echo '{column_number : '.$col.', filter_default_label: "['.lang('product_cost').']", filter_type: "text", data: [] },'; }
                if($this->session->userdata('show_price')) { $col++; echo '{column_number : '.$col.', filter_default_label: "['.lang('product_price').']", filter_type: "text, data: []" },'; }
            }
            ?>
            {column_number: <?php $col++; echo $col; ?>, filter_default_label: "[<?=lang('quantity');?>]", filter_type: "text", data: []},
            {column_number: <?php $col++; echo $col; ?>, filter_default_label: "[<?=lang('product_unit');?>]", filter_type: "text", data: []},
            <?php if($warehouse_id && $Settings->racks) { $col++; echo '{column_number : '. $col.', filter_default_label: "['.lang('rack').']", filter_type: "text", data: [] },'; } ?>
            {column_number: <?php $col++; echo $col; ?>, filter_default_label: "[<?=lang('alert_quantity');?>]", filter_type: "text", data: []},
        ], "footer");


    $("#subcategory").select2("destroy").empty().attr("placeholder", "<?= lang('select_category_to_load') ?>").select2({
            placeholder: "<?= lang('select_category_to_load') ?>", data: [
                {id: '', text: '<?= lang('select_category_to_load') ?>'}
            ]
        });

    $('#product_type').change(function () {
            var v = '?product_type=' + $(this).val()
            $('#modal-loading').show();
            if (v) {
                $.ajax({
                    type: "get",
                    async: false,
                    url: "<?= site_url('products/getProducts') ?>" + v,
                    dataType: "json",
                    success: function (data) {
                        console.log(data)
                    },
                    error: function () {
                        bootbox.alert('<?= lang('ajax_error') ?>');
                        $('#modal-loading').hide();
                    }
                });
            }
            $('#modal-loading').hide();
    });

    $('#category').change(function () {
            var v = $(this).val();
            $('#modal-loading').show();
            if (v) {
                $.ajax({
                    type: "get",
                    async: false,
                    url: "<?= site_url('products/getSubCategories') ?>/" + v,
                    dataType: "json",
                    success: function (scdata) {
                        if (scdata != null) {
                            $("#subcategory").select2("destroy").empty().attr("placeholder", "<?= lang('select_subcategory') ?>").select2({
                                placeholder: "<?= lang('select_category_to_load') ?>",
                                data: scdata
                            });
                        }
                    },
                    error: function () {
                        bootbox.alert('<?= lang('ajax_error') ?>');
                        $('#modal-loading').hide();
                    }
                });
            } else {
                $("#subcategory").select2("destroy").empty().attr("placeholder", "<?= lang('select_category_to_load') ?>").select2({
                    placeholder: "<?= lang('select_category_to_load') ?>",
                    data: [{id: '', text: '<?= lang('select_category_to_load') ?>'}]
                });
            }
            $('#modal-loading').hide();
        });

    });
</script>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i
                class="fa-fw fa fa-barcode"></i><?= lang('products') . ' (' . ($warehouse_id ? $warehouse->name : lang('all_warehouses')) . ')'; ?>
        </h2>
    </div>    
<div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('list_results'); ?></p>

                <div id="form">

                    <?php echo form_open("products/index"); ?>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="category"><?= lang("category"); ?></label>
                                <?php
                                $cat[''] = "";
                                foreach ($categories as $category) {
                                    $cat[$category->id] = $category->name;
                                }
                                echo form_dropdown('category', $cat, (isset($_POST['category']) ? $_POST['category'] : ""), 'class="form-control select" id="category" placeholder="' . lang("select") . " " . lang("category") . '" style="width:100%"')
                                ?>
                                
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="product_type"><?= lang("Product Type"); ?></label>
                                <?php
                                    echo form_dropdown('product_type', $product_types, (isset($_POST['product_type']) ? $_POST['product_type'] : ""), 'class="form-control select" id="product_type" placeholder="' . lang("select") . " " . lang("Product Type") . '" style="width:100%"')
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-3">
                        <div class="form-group">
                        <?= lang("subcategory", "subcategory") ?>
                            <div class="controls" id="subcat_data"> <?php
                                echo form_input('subcategory','', 'class="form-control" id="subcategory"  placeholder="' . lang("select_category_to_load") . '"');
                                ?>
                            </div>
                        </div>
                    </div>
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <?= lang("gst", "gst"); ?>
                                <?php 
                                $gst = array(
                                    '0' => lang("all"),
                                    '2' => lang("without_gst"),
                                    '1' => lang("with_gst")
                                    );
                                echo form_dropdown('gst', $gst, (isset($_POST['gst']) ? $_POST['gst'] : ""), 'class="form-control" id="gst" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("gst") . '"');
                                
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
 </div>
                </div>
                </div>
               


<?php if ($Owner) {
    echo form_open('products/product_actions', 'id="action-form"');
} ?>
<div class="box">


    <div class="box-header">
        <h2 class="blue"><i
                class="fa-fw fa fa-barcode"></i><?= lang('products') . ' (' . ($warehouse_id ? $warehouse->name : lang('all_warehouses')) . ')'; ?>
        </h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang("actions") ?>"></i></a>
                    <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li><a href="<?= site_url('products/add') ?>"><i class="fa fa-plus-circle"></i> <?= lang('add_product') ?></a></li>
                        <li><a href="#" id="barcodeProducts" data-action="barcodes"><i class="fa fa-print"></i> <?= lang('print_barcodes') ?></a></li>
                        <li><a href="#" id="labelProducts" data-action="labels"><i class="fa fa-print"></i> <?= lang('print_labels') ?></a></li>
                        <li><a href="#" id="sync_quantity" data-action="sync_quantity"><i class="fa fa-arrows-v"></i> <?= lang('sync_quantity') ?></a></li>
                        <li><a href="#" id="excel" data-action="export_excel"><i class="fa fa-file-excel-o"></i> <?= lang('export_to_excel') ?></a></li>
                        <li><a href="#" id="pdf" data-action="export_pdf"><i class="fa fa-file-pdf-o"></i> <?= lang('export_to_pdf') ?></a></li>
                        <li class="divider"></li>
                        <li><a href="#" class="bpo" title="<b><?= $this->lang->line("delete_products") ?></b>"
                               data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger' id='delete' data-action='delete'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button>" data-html="true" data-placement="left"><i class="fa fa-trash-o"></i> <?= lang('delete_products') ?></a></li>
                    </ul>
                </li>
                <?php if (!empty($warehouses)) { ?>
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-building-o tip" data-placement="left" title="<?= lang("warehouses") ?>"></i></a>
                        <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                            <li><a href="<?= site_url('products') ?>"><i class="fa fa-building-o"></i> <?= lang('all_warehouses') ?></a></li>
                            <li class="divider"></li>
                            <?php
                            foreach ($warehouses as $warehouse) {
                                echo '<li><a href="' . site_url('products/' . $warehouse->id) . '"><i class="fa fa-building"></i>' . $warehouse->name . '</a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('list_results'); ?></p>

                <div class="table-responsive">
                    <table id="PRData" class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                        <tr class="primary">
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkth" type="checkbox" name="check"/>
                            </th>
                            <th style="min-width:40px; width: 40px; text-align: center;"><?php echo $this->lang->line("image"); ?></th>
                            <th><?= lang("product_code") ?></th>
                            <th><?= lang("product_name") ?></th>
                            <th><?= lang("category") ?></th>
                            <?php
                            if ($Owner || $Admin) {
                                echo '<th>' . lang("product_cost") . '</th>';
                                echo '<th>' . lang("product_price") . '</th>';
                            } else {
                                if ($this->session->userdata('show_cost')) {
                                    echo '<th>' . lang("product_cost") . '</th>';
                                }
                                if ($this->session->userdata('show_price')) {
                                    echo '<th>' . lang("product_price") . '</th>';
                                }
                            }
                            ?>
                            <th><?= lang("quantity") ?></th>
                            <th><?= lang("product_unit") ?></th>
                            <th><?= lang("rack") ?></th>
                            <th><?= lang("alert_quantity") ?></th>
                            <th style="min-width:65px; text-align:center;"><?= lang("actions") ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="10" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
                        </tr>
                        </tbody>

                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkft" type="checkbox" name="check"/>
                            </th>
                            <th style="min-width:40px; width: 40px; text-align: center;"><?php echo $this->lang->line("image"); ?></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <?php
                            if ($Owner || $Admin) {
                                echo '<th></th>';
                                echo '<th></th>';
                            } else {
                                if ($this->session->userdata('show_cost')) {
                                    echo '<th></th>';
                                }
                                if ($this->session->userdata('show_price')) {
                                    echo '<th></th>';
                                }
                            }
                            ?>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="width:65px; text-align:center;"><?= lang("actions") ?></th>
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
