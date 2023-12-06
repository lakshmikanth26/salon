<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('edit_expense'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open_multipart("purchases/edit_expense/" . $expense->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <?php if ($Owner || $Admin) { ?>

                <div class="form-group">
                    <?= lang("date", "date"); ?>
                    <?= form_input('date', (isset($_POST['date']) ? $_POST['date'] : $this->sma->hrld($expense->date)), 'class="form-control datetime" id="date" required="required"'); ?>
                </div>
            <?php } ?>

            <div class="form-group">
                <?= lang("reference", "reference"); ?>
                <?= form_input('reference', (isset($_POST['reference']) ? $_POST['reference'] : $expense->reference), 'class="form-control tip" id="reference" required="required"'); ?>
            </div>
            <div class="form-group">
                <?= lang("company_name", "company_name"); ?>
                <?= form_input('company_name', (isset($_POST['company_name']) ? $_POST['company_name'] : $expense->company_name), 'class="form-control tip" id="company_name"'); ?>
            </div>
            <div class="form-group">
                <?= lang("gst_no", "gst_no"); ?>
                <?= form_input('gst_no', (isset($_POST['gst_no']) ? $_POST['gst_no'] : $expense->gst_no), 'class="form-control tip" id="gst_no"'); ?>
            </div>

            <div class="form-group">
                <?= lang("amount", "amount"); ?>
                <input name="amount" type="text" id="amount" value="<?= $this->sma->formatDecimal($expense->amount); ?>"
                       class="pa form-control kb-pad amount" required="required"/>
            </div>

            <div class="form-group">
                <?= lang("cost", "cost"); ?>
                <input name="cost" type="text" id="cost" value="<?= $this->sma->formatDecimal($expense->cost); ?>"
                       class="pa form-control kb-pad cost"/>
            </div>
            <div class="form-group">
                <?= lang("gst", "gst"); ?>
                <input name="tax_amount" type="text" id="tax_amount" value="<?= $this->sma->formatDecimal($expense->tax_amount); ?>"
                       class="pa form-control kb-pad tax_amount"/>
            </div>

            <div class="form-group">
                <?= lang("attachment", "attachment") ?>
                <input id="attachment" type="file" name="userfile" data-show-upload="false" data-show-preview="false"
                       class="form-control file">
            </div>

            <div class="form-group">
                <?= lang("note", "note"); ?>
                <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : $expense->note), 'class="form-control" id="note"'); ?>
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_expense', lang('edit_expense'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<script type="text/javascript" charset="UTF-8">
    $.fn.datetimepicker.dates['sma'] = <?=$dp_lang?>;
</script>
<?= $modal_js ?>
<script type="text/javascript" charset="UTF-8">
    $(document).ready(function () {
        $.fn.datetimepicker.dates['sma'] = <?=$dp_lang?>;
    });
</script>
