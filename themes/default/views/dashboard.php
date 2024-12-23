<link rel="stylesheet" href="<?= $assets ?>fullcalendar/dist/fullcalendar.css">
<style>
    h1 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .grid-container {
        display: flex;
        gap: 15px;
        padding: 10px;
    }

    .card {
        cursor: pointer;
        background: #a2cbe375;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        transition: transform 0.3s, box-shadow 0.3s;
        height: 150px;
        width: 250px;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
    }

    .card .icon {
        font-size: 3rem;
        margin-bottom: 15px;
    }

    .card .icon.blue {
        color: #2196F3;
    }

    .card .icon.green {
        color: #4CAF50;
    }

    .card .icon.orange {
        color: #FF9800;
    }

    .card .icon.red {
        color: #F44336;
    }

    .card h3 {
        font-size: 1.5rem;
        color: #333;
        margin-bottom: 10px;
    }

    .card p {
        font-size: 1.2rem;
        font-weight: bold;
        color: #555;
    }

    .card a {
        margin-top: 15px;
        display: inline-block;
        font-size: 0.9rem;
        color: #2196F3;
        text-decoration: none;
    }

    .card a:hover {
        text-decoration: none;
    }
    a.no_underline {
        text-decoration: none;
    }
</style>
<script type="text/javascript" src="<?= $assets ?>availability-calendar/scripts/components/jquery.min.js"></script>
<script src="<?= $assets ?>js/moment.min.js"></script>

<script src="<?= $assets ?>fullcalendar/dist/fullcalendar.min.js"></script>

<script src="<?= $assets ?>js/fullcalendar-init.js"></script>


<?php
function row_status($x)
{
    if ($x == null) {
        return '';
    } elseif ($x == 'pending') {
        return '<div class="text-center"><span class="label label-warning">' . lang($x) . '</span></div>';
    } elseif ($x == 'completed' || $x == 'paid' || $x == 'sent' || $x == 'received') {
        return '<div class="text-center"><span class="label label-success">' . lang($x) . '</span></div>';
    } elseif ($x == 'partial' || $x == 'transferring') {
        return '<div class="text-center"><span class="label label-info">' . lang($x) . '</span></div>';
    } elseif ($x == 'due') {
        return '<div class="text-center"><span class="label label-danger">' . lang($x) . '</span></div>';
    } else {
        return '<div class="text-center"><span class="label label-default">' . lang($x) . '</span></div>';
    }
}

?>
<?php if ($Owner && $chatData) {
    foreach ($chatData as $month_sale) {
        $months[] = date('M-Y', strtotime($month_sale->month));
        $msales[] = $month_sale->sales;
        $mtax1[] = $month_sale->tax1;
        $mtax2[] = $month_sale->tax2;
        $mpurchases[] = $month_sale->purchases;
        $mtax3[] = $month_sale->ptax;
    }
    ?>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><i class="fa fa-th"></i><span class="break"></span><?= lang('membership_users') ?></h2>
                </div>
                <div class="box-content">
                    <div class="grid-container">
                        <!-- Total Members Card -->
                        <a class="no_underline" href="<?= site_url('customers?group=member') ?>">
                            <div class="card">
                                <div class="icon blue">
                                    <i class="fa fa-users"></i>
                                </div>
                                <h3>Total Membership Users</h3>
                                <b><?php echo $total_members_count; ?></b>
                            </div>
                        </a>
                        <!-- Expiring Memberships Card -->
                        <a class="no_underline" href="<?= site_url('customers?group=member&expiresIn=30') ?>">
                            <div class="card">
                                <div class="icon orange">
                                    <i class="fa fa-street-view"></i>
                                </div>
                                <h3>Expiring in 30 Days</h3>
                                <b><?php echo $expiring_members_count; ?></b>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="box" style="margin-bottom: 15px;">
        <div class="box-header">
            <h2 class="blue"><i class="fa-fw fa fa-bar-chart-o"></i><?= lang('overview_chart'); ?></h2>
        </div>
        <div class="box-content">
            <div class="row">
                <div class="col-md-12">
                    <p class="introtext"><?php echo lang('overview_chart_heading'); ?></p>

                    <div id="ov-chart" style="width:100%; height:450px;"></div>
                    <p class="text-center"><?= lang("chart_lable_toggle"); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="row" style="margin-bottom: 15px;">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa fa-th"></i><span class="break"></span><?= lang('quick_links') ?></h2>
            </div>
            <div class="box-content">
                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bblue white quick-button small" href="<?= site_url('products') ?>">
                        <i class="fa fa-barcode"></i>

                        <p><?= lang('products') ?></p>
                    </a>
                </div>
                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bdarkGreen white quick-button small" href="<?= site_url('pos/sales') ?>">
                        <i class="fa fa-heart"></i>

                        <p><?= lang('sales') ?></p>
                    </a>
                </div>

                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="blightOrange white quick-button small" href="<?= site_url('quotes') ?>">
                        <i class="fa fa-heart-o"></i>

                        <p><?= lang('quotes') ?></p>
                    </a>
                </div>

                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bred white quick-button small" href="<?= site_url('purchases') ?>">
                        <i class="fa fa-star"></i>

                        <p><?= lang('purchases') ?></p>
                    </a>
                </div>

                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bpink white quick-button small" href="<?= site_url('transfers') ?>">
                        <i class="fa fa-star-o"></i>

                        <p><?= lang('transfers') ?></p>
                    </a>
                </div>

                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bgrey white quick-button small" href="<?= site_url('customers') ?>">
                        <i class="fa fa-users"></i>

                        <p><?= lang('customers') ?></p>
                    </a>
                </div>

                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bgrey white quick-button small" href="<?= site_url('suppliers') ?>">
                        <i class="fa fa-users"></i>

                        <p><?= lang('suppliers') ?></p>
                    </a>
                </div>
                <?php if ($Owner || $Admin) { ?>
                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="blightBlue white quick-button small" href="<?= site_url('notifications') ?>">
                            <i class="fa fa-comments"></i>

                            <p><?= lang('notifications') ?></p>
                            <!--<span class="notification green">4</span>-->
                        </a>
                    </div>
                <?php }
                if ($Owner) { ?>
                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="bblue white quick-button small" href="<?= site_url('auth/users') ?>">
                            <i class="fa fa-group"></i>

                            <p><?= lang('users') ?></p>
                            <!--<span class="notification blue">7</span>-->
                        </a>
                    </div>
                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="bblue white quick-button small" href="<?= site_url('system_settings') ?>">
                            <i class="fa fa-cogs"></i>

                            <p><?= lang('settings') ?></p>
                        </a>
                    </div>
                <?php } ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

</div>

<?php if ($this->Customer) { ?>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-4">
            <!-- small box -->
            <div class="small-box bblue white">
                <div class="inner">
                    <div class="col-md-4">
                        <h3><?= '0.00' ?></h3>

                        <p>Invoice <br>Amount</p>
                    </div>
                    <div class="col-md-4">
                        <h3><?= '0.00' ?></h3>

                        <p>Total <br>Paid</p>
                    </div>
                    <div class="col-md-4">
                        <h3><?= '0.00' ?></h3>

                        <p>Rest <br>Amount</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-2">
                    <div class="small-box blightOrange">
                        <div class="inner clearfix">
                            <a href="<?= site_url('orders/drafts') ?>">
                                <h3><?= '0.00' ?></h3>

                                <p>Drafts<br>Orders</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="small-box blightBlue">
                        <div class="inner clearfix">
                            <a href="<?= site_url('orders/opened_orders') ?>">
                                <h3><?= '0.00' ?></h3>

                                <p>Opened<br>Orders</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="small-box bred">
                        <div class="inner clearfix">
                            <a href="<?= site_url('orders/cancelled_orders') ?>">
                                <h3><?= '0.00' ?></h3>

                                <p>Cancelled<br>Orders</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="small-box bdarkGreen">
                        <div class="inner clearfix">
                            <a href="<?= site_url('orders/completed_orders') ?>">
                                <h3><?= '0.00' ?></h3>

                                <p>Completed<br>Orders</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="small-box bgrey">
                        <div class="inner clearfix">
                            <a href="<?= site_url('orders/back_orders') ?>">
                                <h3><?= '0.00' ?></h3>

                                <p>Back <br>Orders</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="small-box borange">
                        <div class="inner clearfix">
                            <a href="<?= site_url('quotes') ?>">
                                <h3><?= '0.00' ?></h3>

                                <p>Quotations<br>&nbsp;</p>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php } ?>

<div class="row" style="margin-bottom: 15px;">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa-fw fa fa-tasks"></i> <?= lang('latest_five') ?></h2>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-md-12">

                        <ul id="dbTab" class="nav nav-tabs">
                            <?php if ($Owner || $Admin || $GP['sales-index']) { ?>
                            <li class=""><a href="#sales"><?= lang('sales') ?></a></li>
                            <?php } if ($Owner || $Admin || $GP['quotes-index']) { ?>
                            <li class=""><a href="#quotes"><?= lang('quotes') ?></a></li>
                            <?php } if ($Owner || $Admin || $GP['purchases-index']) { ?>
                            <li class=""><a href="#purchases"><?= lang('purchases') ?></a></li>
                            <?php } if ($Owner || $Admin || $GP['transfers-index']) { ?>
                            <li class=""><a href="#transfers"><?= lang('transfers') ?></a></li>
                            <?php } if ($Owner || $Admin || $GP['customers-index']) { ?>
                            <li class=""><a href="#customers"><?= lang('customers') ?></a></li>
                            <?php } if ($Owner || $Admin || $GP['suppliers-index']) { ?>
                            <li class=""><a href="#suppliers"><?= lang('suppliers') ?></a></li>
                            <?php } ?>
                        </ul>

                        <div class="tab-content">
                        <?php if ($Owner || $Admin || $GP['sales-index']) { ?>

                            <div id="sales" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="sales-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                <tr>
                                                    <th style="width:30px !important;">#</th>
                                                    <th><?= $this->lang->line("date"); ?></th>
                                                    <th><?= $this->lang->line("reference_no"); ?></th>
                                                    <th><?= $this->lang->line("customer"); ?></th>
                                                    <th><?= $this->lang->line("status"); ?></th>
                                                    <th><?= $this->lang->line("total"); ?></th>
                                                    <th><?= $this->lang->line("payment_status"); ?></th>
                                                    <th><?= $this->lang->line("paid"); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (!empty($sales)) {
                                                    $r = 1;
                                                    foreach ($sales as $order) {
                                                        echo '<tr id="' . $order->id . '" class="' . ($order->pos ? "receipt_link" : "invoice_link") . '"><td>' . $r . '</td>
                                                            <td>' . $this->sma->hrld($order->date) . '</td>
                                                            <td>' . $order->reference_no . '</td>
                                                            <td>' . $order->customer . '</td>
                                                            <td>' . row_status($order->sale_status) . '</td>
                                                            <td class="text-right">' . $this->sma->formatMoney($order->grand_total) . '</td>
                                                            <td>' . row_status($order->payment_status) . '</td>
                                                            <td class="text-right">' . $this->sma->formatMoney($order->paid) . '</td>
                                                        </tr>';
                                                        $r++;
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="7"
                                                            class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } if ($Owner || $Admin || $GP['quotes-index']) { ?>

                            <div id="quotes" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="quotes-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                <tr>
                                                    <th style="width:30px !important;">#</th>
                                                    <th><?= $this->lang->line("date"); ?></th>
                                                    <th><?= $this->lang->line("reference_no"); ?></th>
                                                    <th><?= $this->lang->line("customer"); ?></th>
                                                    <th><?= $this->lang->line("status"); ?></th>
                                                    <th><?= $this->lang->line("amount"); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (!empty($quotes)) {
                                                    $r = 1;
                                                    foreach ($quotes as $quote) {
                                                        echo '<tr id="' . $quote->id . '" class="quote_link"><td>' . $r . '</td>
                                                        <td>' . $this->sma->hrld($quote->date) . '</td>
                                                        <td>' . $quote->reference_no . '</td>
                                                        <td>' . $quote->customer . '</td>
                                                        <td>' . row_status($quote->status) . '</td>
                                                        <td class="text-right">' . $this->sma->formatMoney($quote->grand_total) . '</td>
                                                    </tr>';
                                                        $r++;
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="6"
                                                            class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } if ($Owner || $Admin || $GP['purchases-index']) { ?>

                            <div id="purchases" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="purchases-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                <tr>
                                                    <th style="width:30px !important;">#</th>
                                                    <th><?= $this->lang->line("date"); ?></th>
                                                    <th><?= $this->lang->line("reference_no"); ?></th>
                                                    <th><?= $this->lang->line("supplier"); ?></th>
                                                    <th><?= $this->lang->line("status"); ?></th>
                                                    <th><?= $this->lang->line("amount"); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (!empty($purchases)) {
                                                    $r = 1;
                                                    foreach ($purchases as $purchase) {
                                                        echo '<tr id="' . $purchase->id . '" class="purchase_link"><td>' . $r . '</td>
                                                    <td>' . $this->sma->hrld($purchase->date) . '</td>
                                                    <td>' . $purchase->reference_no . '</td>
                                                    <td>' . $purchase->supplier . '</td>
                                                    <td>' . row_status($purchase->status) . '</td>
                                                    <td class="text-right">' . $this->sma->formatMoney($purchase->grand_total) . '</td>
                                                </tr>';
                                                        $r++;
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="6"
                                                            class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } if ($Owner || $Admin || $GP['transfers-index']) { ?>

                            <div id="transfers" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="transfers-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                <tr>
                                                    <th style="width:30px !important;">#</th>
                                                    <th><?= $this->lang->line("date"); ?></th>
                                                    <th><?= $this->lang->line("reference_no"); ?></th>
                                                    <th><?= $this->lang->line("from"); ?></th>
                                                    <th><?= $this->lang->line("to"); ?></th>
                                                    <th><?= $this->lang->line("status"); ?></th>
                                                    <th><?= $this->lang->line("amount"); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (!empty($transfers)) {
                                                    $r = 1;
                                                    foreach ($transfers as $transfer) {
                                                        echo '<tr id="' . $transfer->id . '" class="transfer_link"><td>' . $r . '</td>
                                                <td>' . $this->sma->hrld($transfer->date) . '</td>
                                                <td>' . $transfer->transfer_no . '</td>
                                                <td>' . $transfer->from_warehouse_name . '</td>
                                                <td>' . $transfer->to_warehouse_name . '</td>
                                                <td>' . row_status($transfer->status) . '</td>
                                                <td class="text-right">' . $this->sma->formatMoney($transfer->grand_total) . '</td>
                                            </tr>';
                                                        $r++;
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="7"
                                                            class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } if ($Owner || $Admin || $GP['customers-index']) { ?>

                            <div id="customers" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="customers-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                <tr>
                                                    <th style="width:30px !important;">#</th>
                                                    <th><?= $this->lang->line("company"); ?></th>
                                                    <th><?= $this->lang->line("name"); ?></th>
                                                    <th><?= $this->lang->line("email"); ?></th>
                                                    <th><?= $this->lang->line("phone"); ?></th>
                                                    <th><?= $this->lang->line("address"); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (!empty($customers)) {
                                                    $r = 1;
                                                    foreach ($customers as $customer) {
                                                        echo '<tr id="' . $customer->id . '" class="customer_link pointer"><td>' . $r . '</td>
                                            <td>' . $customer->company . '</td>
                                            <td>' . $customer->name . '</td>
                                            <td>' . $customer->email . '</td>
                                            <td>' . $customer->phone . '</td>
                                            <td>' . $customer->address . '</td>
                                        </tr>';
                                                        $r++;
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="6"
                                                            class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } if ($Owner || $Admin || $GP['suppliers-index']) { ?>

                            <div id="suppliers" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="suppliers-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                <tr>
                                                    <th style="width:30px !important;">#</th>
                                                    <th><?= $this->lang->line("company"); ?></th>
                                                    <th><?= $this->lang->line("name"); ?></th>
                                                    <th><?= $this->lang->line("email"); ?></th>
                                                    <th><?= $this->lang->line("phone"); ?></th>
                                                    <th><?= $this->lang->line("address"); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (!empty($suppliers)) {
                                                    $r = 1;
                                                    foreach ($suppliers as $supplier) {
                                                        echo '<tr id="' . $supplier->id . '" class="supplier_link pointer"><td>' . $r . '</td>
                                        <td>' . $supplier->company . '</td>
                                        <td>' . $supplier->name . '</td>
                                        <td>' . $supplier->email . '</td>
                                        <td>' . $supplier->phone . '</td>
                                        <td>' . $supplier->address . '</td>
                                    </tr>';
                                                        $r++;
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="6"
                                                            class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } ?>

                        </div>


                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.order').click(function () {
            window.location.href = '<?=site_url()?>orders/view/' + $(this).attr('id') + '#comments';
        });
        $('.invoice').click(function () {
            window.location.href = '<?=site_url()?>orders/view/' + $(this).attr('id');
        });
        $('.quote').click(function () {
            window.location.href = '<?=site_url()?>quotes/view/' + $(this).attr('id');
        });
    });
</script>

<?php if ($Owner && $chatData) { ?>
    <style type="text/css" media="screen">
        .tooltip-inner {
            max-width: 500px;
        }
    </style>
    <script src="<?= $assets; ?>js/hc/highcharts.js"></script>
    <script type="text/javascript">
        $(function () {
            Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
                return {
                    radialGradient: {cx: 0.5, cy: 0.3, r: 0.7},
                    stops: [[0, color], [1, Highcharts.Color(color).brighten(-0.3).get('rgb')]]
                };
            });
            $('#ov-chart').highcharts({
                chart: {},
                credits: {enabled: false},
                title: {text: ''},
                xAxis: {categories: <?= json_encode($months); ?>},
                yAxis: {min: 0, title: ""},
                tooltip: {
                    shared: true,
                    followPointer: true,
                    formatter: function () {
                        if (this.key) {
                            return '<div class="tooltip-inner hc-tip" style="margin-bottom:0;">' + this.key + '<br><strong>' + currencyFormat(this.y) + '</strong> (' + formatNumber(this.percentage) + '%)';
                        } else {
                            var s = '<div class="well well-sm hc-tip" style="margin-bottom:0;"><h2 style="margin-top:0;">' + this.x + '</h2><table class="table table-striped"  style="margin-bottom:0;">';
                            $.each(this.points, function () {
                                s += '<tr><td style="color:{series.color};padding:0">' + this.series.name + ': </td><td style="color:{series.color};padding:0;text-align:right;"> <b>' +
                                currencyFormat(this.y) + '</b></td></tr>';
                            });
                            s += '</table></div>';
                            return s;
                        }
                    },
                    useHTML: true, borderWidth: 0, shadow: false, valueDecimals: site.settings.decimals,
                    style: {fontSize: '14px', padding: '0', color: '#000000'}
                },
                series: [{
                    type: 'column',
                    name: '<?= lang("sp_tax"); ?>',
                    data: [<?php
                    echo implode(', ', $mtax1);
                    ?>]
                },
                    {
                        type: 'column',
                        name: '<?= lang("order_tax"); ?>',
                        data: [<?php
                    echo implode(', ', $mtax2);
                    ?>]
                    },
                    {
                        type: 'column',
                        name: '<?= lang("sales"); ?>',
                        data: [<?php
                    echo implode(', ', $msales);
                    ?>]
                    }, {
                        type: 'spline',
                        name: '<?= lang("purchases"); ?>',
                        data: [<?php
                    echo implode(', ', $mpurchases);
                    ?>],
                        marker: {
                            lineWidth: 2,
                            states: {
                                hover: {
                                    lineWidth: 4
                                }
                            },
                            lineColor: Highcharts.getOptions().colors[3],
                            fillColor: 'white'
                        }
                    }, {
                        type: 'spline',
                        name: '<?= lang("pp_tax"); ?>',
                        data: [<?php
                    echo implode(', ', $mtax3);
                    ?>],
                        marker: {
                            lineWidth: 2,
                            states: {
                                hover: {
                                    lineWidth: 4
                                }
                            },
                            lineColor: Highcharts.getOptions().colors[3],
                            fillColor: 'white'
                        }
                    }, {
                        type: 'pie',
                        name: '<?= lang("stock_value"); ?>',
                        data: [
                            ['', 0],
                            ['', 0],
                            ['<?= lang("stock_value_by_price"); ?>', <?php echo $stock->stock_by_price; ?>],
                            ['<?= lang("stock_value_by_cost"); ?>', <?php echo $stock->stock_by_cost; ?>],
                        ],
                        center: [80, 42],
                        size: 80,
                        showInLegend: false,
                        dataLabels: {
                            enabled: false
                        }
                    }]
            });
        });
    </script>

    <script type="text/javascript">
        $(function () {
            $('#lmbschart').highcharts({
                chart: {type: 'column'},
                title: {text: ''},
                credits: {enabled: false},
                xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
                yAxis: {min: 0, title: {text: ''}},
                legend: {enabled: false},
                series: [{
                    name: '<?=lang('sold');?>',
                    data: [<?php
                    foreach ($lmbs as $r) {
                        if($r->SoldQty > 0) {
                            echo "['".$r->name."', ".$r->SoldQty."],";
                        }
                    }
                    ?>],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#000',
                        align: 'right',
                        y: -25,
                        style: {fontSize: '12px'}
                    }
                }]
            });
            $('#bschart').highcharts({
                chart: {type: 'column'},
                title: {text: ''},
                credits: {enabled: false},
                xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
                yAxis: {min: 0, title: {text: ''}},
                legend: {enabled: false},
                series: [{
                    name: '<?=lang('sold');?>',
                    data: [<?php
                foreach ($bs as $r) {
                    if($r->SoldQty > 0) {
                        echo "['".$r->name."', ".$r->SoldQty."],";
                    }
                }
                ?>],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#000',
                        align: 'right',
                        y: -25,
                        style: {fontSize: '12px'}
                    }
                }]
            });

        });
    </script>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><i
                            class="fa-fw fa fa-bar-chart-o"></i><?= lang('best_seller'), ' (' . date('M-Y', time()) . ')'; ?>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="bschart" style="width:100%; height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><i
                            class="fa-fw fa fa-bar-chart-o"></i><?= lang('best_seller') . ' (' . date('M-Y', strtotime('-1 month')) . ')'; ?>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="lmbschart" style="width:100%; height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
