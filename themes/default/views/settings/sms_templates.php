<?php
$ss = array('0' => lang('no'), '1' => lang('yes'));
?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-envelope"></i><?= lang('sms_templates'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <!--<p class="introtext"><?= lang('list_results'); ?></p>-->
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <ul id="myTab" class="nav nav-tabs">
                            <li class=""><a href="#credentials"><?= lang('new_user/new_customer') ?></a></li>
                            <li class=""><a href="#sale"><?= lang('sale') ?></a></li>
                            <li class=""><a href="#purchase"><?= lang('purchase') ?></a></li>
                            <li class=""><a href="#payment"><?= lang('payment') ?></a></li>
                            
                        </ul>

                        <div class="tab-content">
                            <div id="credentials" class="tab-pane fade in">
                                <?= form_open('system_settings/sms_templates'); ?>

                                <?php echo form_textarea('sms_body', (isset($_POST['sms_body']) ? html_entity_decode($_POST['sms_body']) : html_entity_decode($credentials)), 'class="form-control" id="comment"'); ?>
                            <div class="form-group">
                            <?= lang('sms', 'sms'); ?>
                            <div class="controls">  <?php
                                echo form_dropdown('sms_sent', $ss, (isset($_POST['sms_sent']) ? $_POST['sms_sent'] : $credentials_sent), 'class="tip form-control" required="required" id="sms" style="width:100%;"');
                                ?> </div>
                            </div>
                                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('save'); ?>"
                                       style="margin-top:15px;"/>

                                <?php echo form_close(); ?>
                            </div>

                            <div id="sale" class="tab-pane fade">
                                <?= form_open('system_settings/sms_templates/sale'); ?>

                                <?php echo form_textarea('sms_body', (isset($_POST['sms_body']) ? html_entity_decode($_POST['sms_body']) : html_entity_decode($sale)), 'class="form-control" id="comment"'); ?>
                                <div class="form-group">
                            <?= lang('sms', 'sms'); ?>
                            <div class="controls">  <?php
                                echo form_dropdown('sms_sent', $ss, (isset($_POST['sms_sent']) ? $_POST['sms_sent'] : $sale_sent), 'class="tip form-control" required="required" id="sms" style="width:100%;"');
                                ?> </div>
                            </div>
                            
                                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('save'); ?>"
                                       style="margin-top:15px;"/>

                                <?php echo form_close(); ?>
                            </div>
                            <div id="purchase" class="tab-pane fade">
                                <?= form_open('system_settings/sms_templates/purchase'); ?>

                                <?php echo form_textarea('sms_body', (isset($_POST['sms_body']) ? html_entity_decode($_POST['sms_body']) : html_entity_decode($purchase)), 'class="form-control" id="comment"'); ?>
                                <div class="form-group">
                            <?= lang('sms', 'sms'); ?>
                            <div class="controls">  <?php
                                echo form_dropdown('sms_sent', $ss, (isset($_POST['sms_sent']) ? $_POST['sms_sent'] : $purchase_sent), 'class="tip form-control" required="required" id="sms" style="width:100%;"');
                                ?> </div>
                            </div>
                            
                                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('save'); ?>"
                                       style="margin-top:15px;"/>

                                <?php echo form_close(); ?>
                            </div>
                            <div id="payment" class="tab-pane fade">
                                <?= form_open('system_settings/sms_templates/payment'); ?>

                                <?php echo form_textarea('sms_body', (isset($_POST['sms_body']) ? html_entity_decode($_POST['sms_body']) : html_entity_decode($payment)), 'class="form-control" id="comment"'); ?>
                                <div class="form-group">
                            <?= lang('sms', 'sms'); ?>
                            <div class="controls">  <?php
                                echo form_dropdown('sms_sent', $ss, (isset($_POST['sms_sent']) ? $_POST['sms_sent'] : $payment_sent), 'class="tip form-control" required="required" id="sms" style="width:100%;"');
                                ?> </div>
                            </div>
                            
                                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('save'); ?>"
                                       style="margin-top:15px;"/>

                                <?php echo form_close(); ?>
                            </div>


                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="margin5">
                            <h3 style="font-weight: bold;"><?= $this->lang->line('short_tags'); ?></h3>
                            <pre>{site_name} {site_link}</pre>
                            <?= lang('new_user/new_customer') ?>
                            <pre>{client_name} {email} {password} </pre>
                            <?= lang('orders') ?> &amp; <?= lang('payments') ?>
                            <pre>{contact_person} {reference_number} {amount}</pre>


                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>