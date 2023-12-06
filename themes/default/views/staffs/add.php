<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_staff'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open_multipart("staffs/add", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <!--<div class="form-group">
                    <?= lang("type", "type"); ?>
                    <?php $types = array('company' => lang('company'), 'person' => lang('person'));
            echo form_dropdown('type', $types, '', 'class="form-control select" id="type" required="required"'); ?>
                </div> -->

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?= lang("warehouse", "warehouse"); ?>
                        <?php
                        $wh[''] = '';
                        foreach ($warehouses as $warehouse) {
                            $wh[$warehouse->id] = $warehouse->name;
                        }
                        echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : $Settings->default_warehouse), 'id="warehouse" class="form-control input-tip select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("warehouse") . '" required="required" style="width:100%;" ');
                        ?>
                    </div>
                
                    <div class="form-group company">
                        <?= lang("company", "company"); ?>
                        <?php echo form_input('company', '', 'class="form-control tip" id="company" data-bv-notempty="true"'); ?>
                    </div>
                    <div class="form-group person">
                        <?= lang("name", "name"); ?>
                        <?php echo form_input('name', '', 'class="form-control tip" id="name" data-bv-notempty="true"'); ?>
                    </div>
                 <!--    <div class="form-group">
                        <?= lang("vat_no", "vat_no"); ?>
                        <?php echo form_input('vat_no', '', 'class="form-control" id="vat_no"'); ?>
                    </div> -->
                    <!--<div class="form-group company">
                    <?= lang("contact_person", "contact_person"); ?>
                    <?php echo form_input('contact_person', '', 'class="form-control" id="contact_person" data-bv-notempty="true"'); ?>
                </div>-->
                    <div class="form-group">
                        <?= lang("email_address", "email_address"); ?>
                        <input type="email" name="email" class="form-control" required="required" id="email_address"/>
                    </div>
                    <div class="form-group">
                        <?= lang("phone", "phone"); ?>
                        <input type="tel" name="phone" class="form-control" required="required" id="phone"/>
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= lang("address", "address"); ?>
                        <?php echo form_input('address', '', 'class="form-control" id="address" required="required"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("city", "city"); ?>
                        <?php echo form_input('city', '', 'class="form-control" id="city" required="required"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("state", "state"); ?>
                        <?php echo form_input('state', '', 'class="form-control" id="state"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("postal_code", "postal_code"); ?>
                        <?php echo form_input('postal_code', '', 'class="form-control" id="postal_code"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("country", "country"); ?>
                        <?php echo form_input('country', 'INDIA', 'class="form-control" id="country"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("stcf1", "cf1"); ?>
                        <?php echo form_input('cf1', '', 'class="form-control datetime1" id="cf1"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("stcf2", "cf2"); ?>
                        <?php echo form_input('cf2', '', 'class="form-control datetime1" id="cf2"'); ?>

                    </div>
                    <!-- <div class="form-group">
                        <?= lang("stcf3", "cf3"); ?>
                        <?php echo form_input('cf3', '', 'class="form-control" id="cf3"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("stcf4", "cf4"); ?>
                        <?php echo form_input('cf4', '', 'class="form-control" id="cf4"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("stcf5", "cf5"); ?>
                        <?php echo form_input('cf5', '', 'class="form-control" id="cf5"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("stcf6", "cf6"); ?>
                        <?php echo form_input('cf6', '', 'class="form-control" id="cf6"'); ?>
                    </div> -->
                </div>
            </div>


        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_staff', lang('add_staff'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>
<script>
    $(document).ready(function(){
            $(".datetime1").timepicker({
                    timeFormat: 'h:mm p',
            minuteStep: 10                });
});
</script>
