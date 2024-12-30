<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('Edit_Discount'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open("system_settings/edit_discount/" . $id, $attrib); ?>
        <div class="modal-body row">
            <p style="padding-left:10px;"><?= lang('enter_info'); ?></p>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="name"><?php echo $this->lang->line("discount_name"); ?></label>
                    <div
                        class="controls"> <?php echo form_input('name', $discount->name, 'class="form-control" id="name" required="required"'); ?> </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="value"><?php echo $this->lang->line("value"); ?></label>

                    <div
                        class="controls"> <?php echo form_input('value', $discount->value, 'class="form-control" id="value" required="required"'); ?> </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="price"><?php echo $this->lang->line("price_for_value"); ?></label>

                    <div
                        class="controls"> <?php echo form_input('price_for_value', $discount->price_for_value, 'class="form-control" id="price_for_value" required="required"'); ?> </div>
                </div>
            </div>


            <div class="col-sm-6">
                        <div class="form-group">
                            <?= lang("start date", "date"); ?>
                            <?= form_input('start_date', $discount->start_date, 'class="form-control date" id="start_date" required="required"'); ?>
                        </div>
                    </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <?= lang("end date", "date"); ?>
                    <?= form_input('end_date', $discount->end_date, 'class="form-control date" id="expiry_date" required="required"'); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label"
                        for="customer_group"><?php echo $this->lang->line("default_customer_group"); ?></label>

                    <div class="controls"> <?php
                        $cgs = $this->data['customer_groups'];
                        echo form_dropdown(
                            'customer_group',
                            $cgs,
                            $discount->customer_group_id,
                            'class="form-control tip select" id="customer_group" style="width:100%;" required="required"'
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_coupon', lang('Edit_Discount'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>