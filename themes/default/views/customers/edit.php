<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('edit_customer'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open_multipart("customers/edit/" . $customer->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <label class="control-label"
                    for="customer_group"><?php echo $this->lang->line("default_customer_group"); ?></label>

                <div class="controls"> <?php
                    foreach ($customer_groups as $customer_group) {
                        $cgs[$customer_group->id] = $customer_group->name;
                    }
                    echo form_dropdown('customer_group', $cgs, $customer->customer_group_id, 'class="form-control tip select" id="customer_group" style="width:100%;" required="required" ');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group company" style="display: none;">
                        <?= lang("company", "company"); ?>
                        <?php echo form_input('company', $customer->company, 'class="form-control tip" id="company" '); ?>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label class="control-label"
                                for="customer_group"><?php echo $this->lang->line("Prefix"); ?></label>
                            <div class="controls"> 
                                <?php echo form_dropdown('prefix', $prefix, $customer->prefix, 'class="form-control tip select" id="prefix" style="width:100%;"'); ?>
                            </div>
                        </div>
                        <div class="form-group person col-md-9">
                            <?= lang("name", "name"); ?>
                            <?php echo form_input('name', $customer->name, 'class="form-control tip" id="name" data-bv-notempty="true"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"
                            for="gender"><?php echo $this->lang->line("Gender"); ?></label>

                        <div class="controls"> 
                            <?php echo form_dropdown('gender', $gender_options, $customer->gender, 'class="form-control tip select" id="gender" style="width:100%;"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= lang("dob", "dob"); ?>
                        <?php echo form_input('dob', $customer->dob, 'class="form-control datetime" id="dob" '); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("phone", "phone"); ?>
                        <input type="tel" name="phone" class="form-control" required="required" id="phone"
                            value="<?= $customer->phone ?>"/>
                    </div>
                    <!-- <div class="form-group">
                        <?= lang("ccf1", "cf1"); ?>
                        <?php echo form_input('cf1', $customer->cf1, 'class="form-control datetime" id="cf1"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("ccf2", "cf2"); ?>
                        <?php echo form_input('cf2', $customer->cf2, 'class="form-control datetime" id="cf2"'); ?>
                    </div> -->
                    <div class="form-group" style="display: none;">
                        <?= lang("vat_no", "vat_no"); ?>
                        <?php echo form_input('vat_no', $customer->vat_no, 'class="form-control" id="vat_no"'); ?>
                    </div>
                    <!--<div class="form-group company">
                    <?= lang("contact_person", "contact_person"); ?>
                    <?php //echo form_input('contact_person', $customer->contact_person, 'class="form-control" id="contact_person" required="required"'); ?>
                    </div> -->
                    
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= lang("Communication Prefer","Communication Prefer"); ?>
                        <div>
                        <div class="row">
                            <div class="form-check col-md-3">
                                <label>
                                    <?php echo form_checkbox('communication[]', 'sms', (strpos($customer->communication, 'sms') !== false) ? TRUE : FALSE); ?> SMS
                                </label>
                            </div>
                            <div class="form-check col-md-3">
                                <label>
                                    <?php echo form_checkbox('communication[]', 'email', (strpos($customer->communication, 'email') !== false) ? TRUE : FALSE, "class='email-checkbox'"); ?> E-Mail
                                </label>
                            </div>
                            <div class="form-check col-md-4">
                                <label>
                                    <?php echo form_checkbox('communication[]', 'Whatsapp',(strpos($customer->communication, 'Whatsapp') !== false) ? TRUE : FALSE, "class='whatsapp-checkbox'"); ?> Whatsapp
                                </label>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= lang("anniversary", "anniversary"); ?>
                        <?php echo form_input('anniversary', $customer->anniversary, 'class="form-control datetime" id="anniversary"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("Whatsapp", "Whatsapp"); ?>
                        <?php echo form_input('whatsapp', $customer->whatsapp, 'class="form-control" id="whatsapp""'); ?>
                    </div>
                    
                    <div class="form-group">
                        <?= lang("email_address", "email_address"); ?>
                        <input type="email" name="email" class="form-control" id="email_address"
                            value="<?= $customer->email ?>"/>
                    </div>
                    <div class="form-group" style="display: none;">
                        <?= lang("address", "address"); ?>
                        <?php echo form_input('address', $customer->address, 'class="form-control" id="address"'); ?>
                    </div>
                    <div class="form-group" style="display: none;">
                        <?= lang("city", "city"); ?>
                        <?php echo form_input('city', $customer->city, 'class="form-control" id="city"'); ?>
                    </div>
                    <div class="form-group" style="display: none;">
                        <?= lang("state", "state"); ?>
                        <?php echo form_input('state', $customer->state, 'class="form-control" id="state"'); ?>
                    </div>

                    <div class="form-group" style="display: none;">
                        <?= lang("postal_code", "postal_code"); ?>
                        <?php echo form_input('postal_code', $customer->postal_code, 'class="form-control" id="postal_code"'); ?>
                    </div>
                    <div class="form-group" style="display: none;">
                        <?= lang("country", "country"); ?>
                        <?php echo form_input('country', $customer->country, 'class="form-control" id="country"'); ?>
                    </div>
                    <!-- <div class="form-group">
                        <?= lang("ccf3", "cf3"); ?>
                        <?php echo form_input('cf3', $customer->cf3, 'class="form-control" id="cf3"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("ccf4", "cf4"); ?>
                        <?php echo form_input('cf4', $customer->cf4, 'class="form-control" id="cf4"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("ccf5", "cf5"); ?>
                        <?php echo form_input('cf5', $customer->cf5, 'class="form-control" id="cf5"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("ccf6", "cf6"); ?>
                        <?php echo form_input('cf6', $customer->cf6, 'class="form-control" id="cf6"'); ?>
                    </div> -->
                </div>
            </div>
            <div class="form-group">
                <?= lang('award_points', 'award_points'); ?>
                <?= form_input('award_points', set_value('award_points', $customer->award_points), 'class="form-control tip" id="award_points"  required="required"'); ?>
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_customer', lang('edit_customer'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>


<script type="text/javascript">
    $(document).ready(function (e) {
        $('.datetime').datetimepicker({
            autoclose:true,
            viewMode: 'days',
            format:'dd-mm-yyyy'
        });
    });
</script>