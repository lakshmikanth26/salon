<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('import_products_by_csv'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <?php
                $attrib = array('class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form');
                echo form_open_multipart("products/import_csv", $attrib)
                ?>
                <div class="row">
                    <div class="col-md-12">

                        <div class="well well-small">
                            <a href="<?php echo base_url(); ?>assets/csv/sample_products.csv"
                               class="btn btn-primary pull-right"><i
                                    class="fa fa-download"></i> <?= lang("download_sample_file") ?></a>
                            <span class="text-warning"><?= lang("csv1"); ?></span><br/><?= lang("csv2"); ?> <span
                                class="text-info">(<?= lang("product_code") . ', ' . lang("product_name") . ', ' . lang("category_code") . ', ' . lang("product_unit") . ', ' . lang("product_cost") . ', ' . lang("member_price")  . ', ' . lang("product_price") . ', ' . lang("alert_quantity") . ', ' . lang("product_tax") . ', ' . lang("tax_method") . ', ' . lang("track_quantity") . ', ' . lang("type") . ', ' . lang("subcategory_code") . ', ' . lang("product_variants_sep_by"); ?>
                                )</span> <?= lang("csv3"); ?>

                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="csv_file"><?= lang("upload_file"); ?></label>
                                <input type="file" name="userfile" class="form-control file" data-show-upload="false"
                                       data-show-preview="false" id="csv_file" required="required"/>
                            </div>

                            <div class="form-group">
                                <?php echo form_submit('import', $this->lang->line("import"), 'class="btn btn-primary"'); ?>
                            </div>
                        </div>
                    </div>
                    <?= form_close(); ?>

                </div>

            </div>
        </div>
    </div>
</div>