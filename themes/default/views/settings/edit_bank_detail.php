<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('edit_bank_detail'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open_multipart("system_settings/edit_bank_details/" . $id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('update_info'); ?></p>

            <div class="form-group">
                <?php echo lang('bank_name', 'bank_name'); ?>
                <div class="controls">
                    <?php echo form_input($bank_name); ?>
                </div>
            </div>
			<div class="form-group">
                <?php echo lang('bank_branch', 'bank_branch'); ?>
                <div class="controls">
                    <?php echo form_input($bank_branch); ?>
                </div>
            </div>
			<div class="form-group">
                <?php echo lang('bank_accno', 'bank_account_no'); ?>
                <div class="controls">
                    <?php echo form_input($bank_account_no); ?>
                </div>
            </div>
			<div class="form-group">
                <?php echo lang('bank_ifsc', 'bank_ifsc_code'); ?>
                <div class="controls">
                    <?php echo form_input($bank_ifsc_code); ?>
                </div>
            </div>
			
			<?php echo form_hidden('id', $id); ?>
        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_bank_detail', lang('edit_bank_detail'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<?= $modal_js ?>