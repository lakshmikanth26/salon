<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_customer'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'add-customer-form');
        echo form_open_multipart("customers/add", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <label class="control-label"
                       for="customer_group"><?php echo $this->lang->line("default_customer_group"); ?></label>

                <div class="controls"> <?php
                    foreach ($customer_groups as $customer_group) {
                        $cgs[$customer_group->id] = $customer_group->name;
                    }
                    echo form_dropdown('customer_group', $cgs, $this->Settings->customer_group, 'class="form-control tip select" id="customer_group" style="width:100%;" required="required" disabled="disabled"');
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group company" style="display: none;">
                        <?= lang("company", "company"); ?>
                        <?php echo form_input('company', '', 'class="form-control tip" id="company"'); ?>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label class="control-label"
                                for="customer_group"><?php echo $this->lang->line("Prefix"); ?></label>
                            <div class="controls"> 
                                <?php echo form_dropdown('prefix', $prefix, '', 'class="form-control tip select" id="prefix" style="width:100%;"'); ?>
                            </div>
                        </div>
                        <div class="form-group person col-md-9">
                            <?= lang("name", "name"); ?>
                            <?php echo form_input('name', '', 'class="form-control tip" id="name" data-bv-notempty="true"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"
                            for="gender"><?php echo $this->lang->line("Gender"); ?></label>

                        <div class="controls"> 
                            <?php echo form_dropdown('gender', $gender_options, '', 'class="form-control tip select" id="gender" style="width:100%;"'); ?>
                        </div>
                    </div>
                    <div class="form-group" style="display: none;">
                        <?= lang("vat_no", "vat_no"); ?>
                        <?php echo form_input('vat_no', '', 'class="form-control" id="vat_no"'); ?>
                    </div>
                    <!--<div class="form-group company">
                    <?= lang("contact_person", 
                    "contact_person"); ?>
                    <?php echo form_input('contact_person', '', 'class="form-control" id="contact_person" data-bv-notempty="true"'); ?>
                    </div>-->
                    <div class="form-group">
                        <?= lang("dob", "dob"); ?>
                        <?php echo form_input('dob', '', 'class="form-control datetime" id="dob"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("phone", "phone"); ?>
                        <input type="tel" name="phone" class="form-control" required="required" id="phone"/>
                    </div>
                    <!-- <div class="form-group">
                        <?= lang("ccf1", "cf1"); ?>
                        <?php echo form_input('cf1', '', 'class="form-control datetime" id="cf1"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("ccf2", "cf2"); ?>
                        <?php echo form_input('cf2', '', 'class="form-control datetime" id="cf2"'); ?>
                    </div> -->
                    
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= lang("Communication Prefer","Communication Prefer"); ?>
                        <div class="row">
                            <div class="form-check col-md-3">
                                <label>
                                    <?php echo form_checkbox('communication[]', 'sms', TRUE); ?> SMS
                                </label>
                            </div>
                            <div class="form-check col-md-3">
                                <label>
                                    <?php echo form_checkbox('communication[]', 'email', FALSE, "class='email-checkbox'"); ?> E-Mail
                                </label>
                            </div>
                            <div class="form-check col-md-4">
                                <label>
                                    <?php echo form_checkbox('communication[]', 'Whatsapp',FALSE, "class='whatsapp-checkbox'"); ?> Whatsapp
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= lang("anniversary", "anniversary"); ?>
                        <?php echo form_input('anniversary', '', 'class="form-control datetime" id="anniversary"'); ?>
                    </div>
                    <div class="form-group" id="whatsapp">
                        <?= lang("Whatsapp", "Whatsapp"); ?>
                        <input type="text" name="whatsapp" class="form-control" id="whatsapp-input"/>
                    </div>
                    <div class="form-group" style="display: none;">
                        <?= lang("address", "address"); ?>
                        <?php echo form_input('address', '', 'class="form-control" id="address"'); ?>
                    </div>
                    <div class="form-group" style="display: none;">
                        <?= lang("city", "city"); ?>
                        <?php echo form_input('city', '', 'class="form-control" id="city"'); ?>
                    </div>
                    <div class="form-group" style="display: none;">
                        <?= lang("state", "state"); ?>
                        <?php echo form_input('state', '', 'class="form-control" id="state"'); ?>
                    </div>
                    <div class="form-group" style="display: none;">
                        <?= lang("postal_code", "postal_code"); ?>
                        <?php echo form_input('postal_code', '', 'class="form-control" id="postal_code"'); ?>
                    </div>
                    <div class="form-group" style="display: none;">
                        <?= lang("country", "country"); ?>
                        <?php echo form_input('country', 'INDIA', 'class="form-control" id="country"'); ?>
                    </div>
                    <div class="form-group" id="email">
                        <?= lang("email_address", "email_address"); ?>
                        <input type="email" name="email" class="form-control" id="email_address"/>
                    </div>
                    <!--<div class="form-group">
                        <?= lang("ccf3", "cf3"); ?>
                        <?php echo form_input('cf3', '', 'class="form-control" id="cf3"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("ccf4", "cf4"); ?>
                        <?php echo form_input('cf4', '', 'class="form-control" id="cf4"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("ccf5", "cf5"); ?>
                        <?php echo form_input('cf5', '', 'class="form-control" id="cf5"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("ccf6", "cf6"); ?>
                        <?php echo form_input('cf6', '', 'class="form-control" id="cf6"'); ?>
                    </div> -->
                </div>
            </div>


        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_customer', lang('add_customer'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function (e) {
        $('.whatsapp-checkbox').change(function () {
                if ($(this).prop('checked')) {
                    $('#whatsapp-input').attr('required', 'required');
                } else {
                    $('#whatsapp-input').removeAttr('required');
                }
        });
        $('.email-checkbox').change(function () {
            if ($(this).prop('checked')) {
                $('#email_address').attr('required', 'required');
            } else {
                $('#email_address').removeAttr('required');
            }
        });
        $('.datetime').datetimepicker({
            autoclose:true,
            viewMode: 'days',
            format:'dd-mm-yyyy'
        });
        $('#add-customer-form').bootstrapValidator({
            feedbackIcons: {
                valid: 'fa fa-check',
                invalid: 'fa fa-times',
                validating: 'fa fa-refresh'
            }, excluded: [':disabled']
        });
        $('select.select').select2({minimumResultsForSearch: 6});
        fields = $('.modal-content').find('.form-control');
        $.each(fields, function () {
            var id = $(this).attr('id');
            var iname = $(this).attr('name');
            var iid = '#' + id;
            if (!!$(this).attr('data-bv-notempty') || !!$(this).attr('required')) {
                $("label[for='" + id + "']").append(' *');
                $(document).on('change', iid, function () {
                    $('form[data-toggle="validator"]').bootstrapValidator('revalidateField', iname);
                });
            }
        });
    });
</script>
