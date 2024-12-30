<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('edit_coupon'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open("system_settings/edit_coupon/" . $id, $attrib); ?>
        <div class="modal-body row">
            <p><?= lang('enter_info'); ?></p>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="name"><?php echo $this->lang->line("coupon_name"); ?></label>
                    <div
                        class="controls"> <?php echo form_input('name', $coupon->name, 'class="form-control" id="name" required="required"'); ?> </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="price"><?php echo $this->lang->line("price"); ?></label>

                    <div
                        class="controls"> <?php echo form_input('price', $coupon->price, 'class="form-control" id="price" required="required"'); ?> </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="value"><?php echo $this->lang->line("value"); ?></label>

                    <div
                        class="controls"> <?php echo form_input('value', $coupon->value, 'class="form-control" id="value" required="required"'); ?> </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="count"><?php echo $this->lang->line("count"); ?></label>

                    <div
                        class="controls"> <?php echo form_input('count', $coupon->count, 'class="form-control" id="count" required="required"'); ?> </div>
                </div>
            </div>

            <div class="col-sm-6">
                        <div class="form-group">
                            <?= lang("start date", "date"); ?>
                            <?= form_input('start_date', $coupon->start_date, 'class="form-control date" id="start_date" required="required"'); ?>
                        </div>
                    </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <?= lang("end date", "date"); ?>
                    <?= form_input('expiry_date', $coupon->expiry_date, 'class="form-control date" id="expiry_date" required="required"'); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <?= lang("validity upto", "validity"); ?>
                    <?= form_input('validity', $coupon->valid_upto, 'class="form-control date" id="validity" required="required"'); ?>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_coupon', lang('edit_coupon'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>