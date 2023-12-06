<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $this->lang->line("purchase") . " " . $inv->reference_no; ?> </title>
    <link href="<?php echo $assets ?>styles/style.css" rel="stylesheet">
    <style type="text/css">
    html,
    body {
        height: 100%;
        background: #FFF;
    }

    body:before,
    body:after {
        display: none !important;
    }

    .table th {
        text-align: center;
        padding: 5px;
    }

    .table td {
        padding: 4px;
    }
    p{
        font-size: 12px;
    }
    .table td {
    font-size: 12px;
}

#content {
    background: white;
}
.text-uppercase
{
    text-transform: uppercase;
}
.divTable{
    display: table;
    width: 100%;
}
.divTableRow {
    display: table-row;
}
.divTableHeading {
    background-color: #EEE;
    display: table-header-group;
}
.divTableCell, .divTableHead {
    border: 1px solid #999999;
    display: table-cell;
    padding: 3px 10px;
}
.divTableHeading {
    background-color: #EEE;
    display: table-header-group;
    font-weight: bold;
}
.divTableFoot {
    background-color: #EEE;
    display: table-footer-group;
    font-weight: bold;
}
.divTableBody {
    display: table-row-group;
}
</style>
</head>

<body>
    <div id="wrap">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                                <td style="text-align: center;" colspan="4"> <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>" alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>"> </td>
                                <td style="text-align: center;" colspan="4">
                                    <h2>GST INVOICE</h2>
                                    <p>Customer copy</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <h2 class="">
                                        <?= $biller->company != '-' ? $biller->company : $biller->name; ?>
                                    </h2>
                                    <?= $biller->company ? "" : "Attn: " . $biller->name ?>
                                        <?php
                                        echo $biller->address . "<br />" . $biller->city . " " . $biller->postal_code . " " . $biller->state . "<br />" . $biller->country;
                                        echo "<p>";
                                        if ($biller->cf1 != "-" && $biller->cf1 != "") {
                                            echo "<br>" . lang("bcf1") . ": " . $biller->cf1;
                                        }
                                        if ($biller->cf2 != "-" && $biller->cf2 != "") {
                                            echo "<br>" . lang("bcf2") . ": " . $biller->cf2;
                                        }
                                        if ($biller->cf3 != "-" && $biller->cf3 != "") {
                                            echo "<br>" . lang("bcf3") . ": " . $biller->cf3;
                                        }
                                        if ($biller->cf4 != "-" && $biller->cf4 != "") {
                                            echo "<br>" . lang("bcf4") . ": " . $biller->cf4;
                                        }
                                        if ($biller->cf5 != "-" && $biller->cf5 != "") {
                                            echo "<br>" . lang("bcf5") . ": " . $biller->cf5;
                                        }
                                        if ($biller->cf6 != "-" && $biller->cf6 != "") {
                                            echo "<br>" . lang("bcf6") . ": " . $biller->cf6;
                                        }
                                        echo "</p>";
                                        echo lang("tel") . ": " . $biller->phone . "<br />" . lang("email") . ": " . $biller->email;
                                        ?> <br>
                                            <hr>
                                            <h2 class="">
                                                <?= $customer->company ? $customer->company : $customer->name; ?>
                                            </h2>
                                            <?= $customer->company ? "" : "Attn: " . $customer->name ?>
                                                <?php
                                                echo $customer->address . "<br />" . $customer->city . " " . $customer->postal_code . " " . $customer->state . "<br />" . $customer->country;
                                                echo "<p>";
                                                if ($customer->cf1 != "-" && $customer->cf1 != "") {
                                                    echo "<br>" . lang("ccf1") . ": " . $customer->cf1;
                                                }
                                                if ($customer->cf2 != "-" && $customer->cf2 != "") {
                                                    echo "<br>" . lang("ccf2") . ": " . $customer->cf2;
                                                }
                                                if ($customer->cf3 != "-" && $customer->cf3 != "") {
                                                    echo "<br>" . lang("ccf3") . ": " . $customer->cf3;
                                                }
                                                if ($customer->cf4 != "-" && $customer->cf4 != "") {
                                                    echo "<br>" . lang("ccf4") . ": " . $customer->cf4;
                                                }
                                                if ($customer->cf5 != "-" && $customer->cf5 != "") {
                                                    echo "<br>" . lang("ccf5") . ": " . $customer->cf5;
                                                }
                                                if ($customer->cf6 != "-" && $customer->cf6 != "") {
                                                    echo "<br>" . lang("ccf6") . ": " . $customer->cf6;
                                                }
                                                echo "</p>";
                                                echo lang("tel") . ": " . $customer->phone . "<br />" . lang("email") . ": " . $customer->email;
                                                ?> </td>
                                <td colspan="4">
                                    <table class="table table-bordered table-hover table-striped">
                                        <tbody>
                                            <tr>
                                                <td>DATE</td>
                                                <td>24/08/2017</td>
                                            </tr>
                                            <tr>
                                                <td>INVOICE</td>
                                                <td>Sale_0009</td>
                                            </tr>
                                            <tr>
                                                <td>SALES STATUS</td>
                                                <td>Completed</td>
                                            </tr>
                                            <tr>
                                                <td>PAYMENT TERMS</td>
                                                <td>Done</td>
                                            </tr>
                                            <tr>
                                                <td>PAYMENT STATUS</td>
                                                <td>Paid</td>
                                            </tr>
                                            <tr>
                                                <td>PO REF</td>
                                                <td>4545646545</td>
                                            </tr>
                                            <tr>
                                                <td>SUPPLIER`S REF</td>
                                                <td>11564545</td>
                                            </tr>
                                            <tr>
                                                <td>DISPATCHED THROW</td>
                                                <td>ING</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <p style="text-align: justify;">
                                        <strong>TERMS OF SALES</strong> <br>
                                        It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                                    </p>
                                </td>
                            </tr><tr>
                        <th class="text-uppercase"><?= lang("sl_no"); ?></th>
                        <th class="text-uppercase"><?= lang("description"); ?> (<?= lang("code"); ?>)</th>
                        <th class="text-uppercase"><?= lang("serial_no"); ?></th>
                        <th class="text-uppercase"><?= lang("hsn_sac"); ?></th>
                        <th class="text-uppercase">Qty/Per</th>
                        <th class="text-uppercase">Rate</th>
                        <th class="text-uppercase"><?= lang("tax"); ?></th>
                        <th class="text-uppercase">Taxable Amount</th>
                    </tr>
                    </thead>
                    <tbody style="height:400px">
                    <?php $r = 1;
                    foreach ($rows as $row):
                        ?>
                        <tr>
                            <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                            <td style="vertical-align:middle;"><?= $row->product_name . " (" . $row->product_code . ")" . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                <?= $row->details ? '<br>' . $row->details : ''; ?>
                            </td>
                            <?php
                                echo '<td>' . $row->serial_no . '</td>';
                            ?>
                            <?php
                                echo '<td>123145</td>';
                            ?>
                            <td style="width: 80px; text-align:center; vertical-align:middle;"><?php echo "1Nos"; ?></td>
                            <td style="text-align:right; width:90px;"><?= $this->sma->formatMoney($row->net_unit_price); ?></td>
                            <?php
                            if ($Settings->tax1) {
                                echo '<td style="width: 90px; text-align:right; vertical-align:middle;">(5%) 16.67<br></td>';
                            }
                            ?>
                            <td style="vertical-align:middle; text-align:right; width:110px;"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                        </tr>
                        <?php
                        $r++;
                    endforeach;

                    ?>
                    <tr>
                    <td style="vertical-align:middle; text-align:right;height:35px;"></td>
                    <td style="vertical-align:middle; text-align:right;height:35px;"></td>
                    <td style="vertical-align:middle; text-align:right;height:35px;"></td>
                    <td style="vertical-align:middle; text-align:right;height:35px;"></td>
                    <td style="vertical-align:middle; text-align:right;height:35px;"></td>
                    <td style="vertical-align:middle; text-align:right;height:35px;"></td>
                    <td style="vertical-align:middle; text-align:right;height:35px;"></td>
                    <td style="vertical-align:middle; text-align:right;height:35px;"></td>
                        </tr>
                    <tr>
                    <td style="vertical-align:middle; text-align:right;height:35px;"></td>
                    <td style="vertical-align:middle; text-align:right;height:35px;"></td>
                    <td style="vertical-align:middle; text-align:right;height:35px;"></td>
                    <td style="vertical-align:middle; text-align:right;height:35px;"></td>
                    <td style="vertical-align:middle; text-align:right;height:35px;"></td>
                    <td style="vertical-align:middle; text-align:right;height:35px;"></td>
                    <td style="vertical-align:middle; text-align:right;height:35px;"></td>
                    <td style="vertical-align:middle; text-align:right;height:35px;"></td>
                        </tr>
                        
                    <tr>
                        <td colspan="2" style="text-align: right;">
                            Total
                        </td>
                        <td colspan="5" style="text-align: right;">
                            768.42
                        </td>
                        <td style="text-align: right;">
                            8400
                        </td>
                    </tr>
                    </tbody>
                    
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <tbody>
                    <tr>
                        <td class="text-center">
                           GST 
                        </td>
                        <td  class="text-center">
                            SGST
                        </td>
                        <td  class="text-center">
                            CGST
                        </td>
                        <td  class="text-center">
                            Total
                        </td>
                    </tr>
                    <tr>
                        <td  class="text-center">
                            GST 5%
                        </td>
                        <td class="text-center">
                            (2.5%) 83.35
                        </td>
                        <td  class="text-center">
                            (2.5%) 83.35
                        </td>
                        <td  class="text-center">
                            166.67
                        </td>
                        
                    </tr>
                    <tr>
                        <td  class="text-center">
                            GST 14%
                        </td>
                        <td class="text-center">
                            (7%) 300.86
                        </td>
                        <td  class="text-center">
                            (7%) 300.86
                        </td>
                        <td  class="text-center">
                            601.72
                        </td>
                        
                    </tr>
                    <tr>
                        <td colspan='3' class="text-center">
                            Total
                        </td>
                        <td  class="text-center">
                            768.42
                        </td>
                        
                    </tr>
                    </tbody>
                    
                </table>

            </div>
                <p style="text-align: justify;">
                   <strong>Sales Notes: </strong><br>
                   It is a long established fact that a reader will be distracted by the readable content of a page.
               </p>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <tbody>
                    <tr>
                        <td  class="text-center">
                            Bank
                        </td>
                        <td  class="text-center">
                            Name
                        </td>
                        <td  class="text-center">
                            Account Number
                        </td>
                        <td  class="text-center">
                            Ifsc Code
                        </td>
                    </tr>
                    <tr>
                        <td  class="text-center">
                            Government
                        </td>
                        <td  class="text-center">
                            Sbi
                        </td>
                        <td  class="text-center">
                            300065222
                        </td>
                        <td  class="text-center">
                            SBIN0001313
                        </td>
                    </tr>
                    </tbody>
                    
                </table>
               <p class="text-center">Thank you for yout valuable business.</p>
               <p>
                   <span class="text-left">Biller: inet sales</span>
                   <span style="float: right;">Biller: inet sales</span>
               </p>
               <p>
                   <span class="text-left">Sign</span>
                   <span style="float: right;">Sign</span>
               </p>
            </div>
            </div>
        </div>
    </div>
</body>

</html>
