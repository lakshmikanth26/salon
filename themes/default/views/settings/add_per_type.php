<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_per_types'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open_multipart("system_settings/add_per_types", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <?php echo lang('per_types_code', 'code'); ?>
                <div class="controls">
                    <?php echo form_input($code); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo lang('per_types_name', 'name'); ?>
                <div class="controls">
                    <?php echo form_input($name); ?>
                </div>
            </div>
            <div class="form-group">
                <?= lang("per_types_image", "image") ?>
                <input id="image" type="file" name="userfile" data-show-upload="false" data-show-preview="false"
                       class="form-control file">
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_per_type', lang('add_per_types'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<?= $modal_js ?>