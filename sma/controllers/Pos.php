<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Pos extends MY_Controller

{



    function __construct()

    {

        parent::__construct();



        if (!$this->loggedIn) {

            $this->session->set_userdata('requested_page', $this->uri->uri_string());

            redirect('login');

        }

        if ($this->Customer || $this->Supplier) {

            $this->session->set_flashdata('warning', lang('access_denied'));

            redirect($_SERVER["HTTP_REFERER"]);

        }



        $this->load->model('pos_model');

        $this->load->helper('text');

        $this->pos_settings = $this->pos_model->getSetting();

        $this->pos_settings->pin_code = $this->pos_settings->pin_code ? md5($this->pos_settings->pin_code) : NULL;

        $this->data['pos_settings'] = $this->pos_settings;

        $this->session->set_userdata('last_activity', now());

        $this->lang->load('pos', $this->Settings->language);

        $this->load->library('form_validation');

    }



    function sales($warehouse_id = NULL)

    {

        $this->sma->checkPermissions('index');



        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

        if ($this->Owner) {

            $this->data['warehouses'] = $this->site->getAllWarehouses();

            $this->data['warehouse_id'] = $warehouse_id;

            $this->data['warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : NULL;

        } else {

            $user = $this->site->getUser();

            $this->data['warehouses'] = NULL;

            $this->data['warehouse_id'] = $this->session->userdata('warehouse_id');

            $this->data['warehouse'] = $this->session->userdata('warehouse_id') ? $this->site->getWarehouseByID($this->session->userdata('warehouse_id')) : NULL;

        }



        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('pos'), 'page' => lang('pos')), array('link' => '#', 'page' => lang('pos_sales')));

        $meta = array('page_title' => lang('pos_sales'), 'bc' => $bc);

        $this->page_construct('pos/sales', $meta, $this->data);

    }



    function getSales($warehouse_id = NULL)

    {

        $this->sma->checkPermissions('index');



        if (!$this->Owner && !$warehouse_id) {

            $user = $this->site->getUser();

            $warehouse_id = $user->warehouse_id;

        }

        $detail_link = anchor('pos/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('view_receipt'));

        $payments_link = anchor('sales/payments/$1', '<i class="fa fa-money"></i> ' . lang('view_payments'), 'data-toggle="modal" data-target="#myModal"');

        $add_payment_link = anchor('pos/add_payment/$1', '<i class="fa fa-money"></i> ' . lang('add_payment'), 'data-toggle="modal" data-target="#myModal"');

        $add_delivery_link = anchor('sales/add_delivery/$1', '<i class="fa fa-truck"></i> ' . lang('add_delivery'), 'data-toggle="modal" data-target="#myModal"');

        $email_link = anchor('#', '<i class="fa fa-envelope"></i> ' . lang('email_sale'), 'class="email_receipt" data-id="$1" data-email-address="$2"');

        $edit_link = anchor('pos/edit/$1', '<i class="fa fa-edit"></i> ' . lang('edit_sale'), 'class="sledit"');

        $return_link = anchor('sales/return_sale/$1', '<i class="fa fa-angle-double-left"></i> ' . lang('return_sale'));

        $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_sale") . "</b>' data-content=\"<p>"

            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete/$1') . "'>"

            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "

            . lang('delete_sale') . "</a>";

        $action = '<div class="text-center"><div class="btn-group text-left">'

            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'

            . lang('actions') . ' <span class="caret"></span></button>

        <ul class="dropdown-menu pull-right" role="menu">

            <li>' . $detail_link . '</li>

            <li>' . $payments_link . '</li>

            <li>' . $add_payment_link . '</li>

            <li>' . $add_delivery_link . '</li>

            <li>' . $email_link . '</li>

            <li>' . $return_link . '</li>

            <li>' . $delete_link . '</li>

        </ul>

        </div></div>';

        //$action = '<div class="text-center">' . $detail_link . ' ' . $edit_link . ' ' . $email_link . ' ' . $delete_link . '</div>';



        $this->load->library('datatables');

        if ($warehouse_id) {

            $this->datatables

                ->select($this->db->dbprefix('sales').".id as id, date, reference_no, biller, customer, grand_total, paid, (grand_total-paid) as balance, payment_status, companies.email as cemail")

                ->from('sales')

                ->join('companies', 'companies.id=sales.customer_id', 'left')

                ->where('warehouse_id', $warehouse_id)

                ->group_by('sales.id');

        } else {

            $this->datatables

                ->select($this->db->dbprefix('sales').".id as id, date, reference_no, biller, customer, grand_total, paid, (grand_total-paid) as balance, payment_status, companies.email as cemail")

                ->from('sales')

                ->join('companies', 'companies.id=sales.customer_id', 'left')

                ->group_by('sales.id');

        }

        $this->datatables->where('pos', 1);

        $this->datatables->where('invoice_type', 1);

        if (!$this->Customer && !$this->Supplier && !$this->Owner && !$this->Admin) {

            $this->datatables->where('created_by', $this->session->userdata('user_id'));

        } elseif ($this->Customer) {

            $this->datatables->where('customer_id', $this->session->userdata('user_id'));

        }

        $this->datatables->add_column("Actions", $action, "id, cemail")->unset_column('cemail');

        echo $this->datatables->generate();

    }

    function sales_bill($warehouse_id = NULL)

    {

        $this->sma->checkPermissions('index');



        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

        if ($this->Owner) {

            $this->data['warehouses'] = $this->site->getAllWarehouses();

            $this->data['warehouse_id'] = $warehouse_id;

            $this->data['warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : NULL;

        } else {

            $user = $this->site->getUser();

            $this->data['warehouses'] = NULL;

            $this->data['warehouse_id'] = $this->session->userdata('warehouse_id');

            $this->data['warehouse'] = $this->session->userdata('warehouse_id') ? $this->site->getWarehouseByID($this->session->userdata('warehouse_id')) : NULL;

        }



        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('pos'), 'page' => lang('pos')), array('link' => '#', 'page' => lang('pos_sales_cash')));

        $meta = array('page_title' => lang('pos_sales_cash'), 'bc' => $bc);

        $this->page_construct('pos/sales_bill', $meta, $this->data);

    }



    function getSalesBill($warehouse_id = NULL)

    {

        $this->sma->checkPermissions('index');



        if (!$this->Owner && !$warehouse_id) {

            $user = $this->site->getUser();

            $warehouse_id = $user->warehouse_id;

        }

        $detail_link = anchor('pos/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('view_receipt'));

        $payments_link = anchor('sales/payments/$1', '<i class="fa fa-money"></i> ' . lang('view_payments'), 'data-toggle="modal" data-target="#myModal"');

        $add_payment_link = anchor('pos/add_payment/$1', '<i class="fa fa-money"></i> ' . lang('add_payment'), 'data-toggle="modal" data-target="#myModal"');

        $add_delivery_link = anchor('sales/add_delivery/$1', '<i class="fa fa-truck"></i> ' . lang('add_delivery'), 'data-toggle="modal" data-target="#myModal"');

        $email_link = anchor('#', '<i class="fa fa-envelope"></i> ' . lang('email_sale'), 'class="email_receipt" data-id="$1" data-email-address="$2"');

        $edit_link = anchor('pos/edit/$1', '<i class="fa fa-edit"></i> ' . lang('edit_sale'), 'class="sledit"');

        $return_link = anchor('sales/return_sale/$1', '<i class="fa fa-angle-double-left"></i> ' . lang('return_sale'));

        $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_sale") . "</b>' data-content=\"<p>"

            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete/$1') . "'>"

            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "

            . lang('delete_sale') . "</a>";

        $action = '<div class="text-center"><div class="btn-group text-left">'

            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'

            . lang('actions') . ' <span class="caret"></span></button>

        <ul class="dropdown-menu pull-right" role="menu">

            <li>' . $detail_link . '</li>

            <li>' . $payments_link . '</li>

            <li>' . $add_payment_link . '</li>

            <li>' . $add_delivery_link . '</li>

            <li>' . $email_link . '</li>

            <li>' . $return_link . '</li>

            <li>' . $delete_link . '</li>

        </ul>

        </div></div>';

        //$action = '<div class="text-center">' . $detail_link . ' ' . $edit_link . ' ' . $email_link . ' ' . $delete_link . '</div>';



        $this->load->library('datatables');

        if ($warehouse_id) {

            $this->datatables

                ->select($this->db->dbprefix('sales').".id as id, date, reference_no, biller, customer, grand_total, paid, (grand_total-paid) as balance, payment_status, companies.email as cemail")

                ->from('sales')

                ->join('companies', 'companies.id=sales.customer_id', 'left')

                ->where('warehouse_id', $warehouse_id)

                ->group_by('sales.id');

        } else {

            $this->datatables

                ->select($this->db->dbprefix('sales').".id as id, date, reference_no, biller, customer, grand_total, paid, (grand_total-paid) as balance, payment_status, companies.email as cemail")

                ->from('sales')

                ->join('companies', 'companies.id=sales.customer_id', 'left')

                ->group_by('sales.id');

        }

        $this->datatables->where('pos', 1);

        $this->datatables->where('invoice_type', 2);

        if (!$this->Customer && !$this->Supplier && !$this->Owner && !$this->Admin) {

            $this->datatables->where('created_by', $this->session->userdata('user_id'));

        } elseif ($this->Customer) {

            $this->datatables->where('customer_id', $this->session->userdata('user_id'));

        }

        $this->datatables->add_column("Actions", $action, "id, cemail")->unset_column('cemail');

        echo $this->datatables->generate();

    }



    /* ---------------------------------------------------------------------------------------------------- */



    function index($sid = NULL)

    {

        $this->sma->checkPermissions();



        if (!$this->pos_settings->default_biller || !$this->pos_settings->default_customer || !$this->pos_settings->default_category) {

            $this->session->set_flashdata('warning', lang('please_update_settings'));

            redirect('pos/settings');

        }

        if ($register = $this->pos_model->registerData($this->session->userdata('user_id'))) {

            $register_data = array('register_id' => $register->id, 'cash_in_hand' => $register->cash_in_hand, 'register_open_time' => $register->date);

            $this->session->set_userdata($register_data);

        } else {

            $this->session->set_flashdata('error', lang('register_not_open'));

            redirect('pos/open_register');

        }



        $this->data['sid'] = $this->input->get('suspend_id') ? $this->input->get('suspend_id') : $sid;

        $did = $this->input->post('delete_id') ? $this->input->post('delete_id') : NULL;

        $suspend = $this->input->post('suspend') ? TRUE : FALSE;

        $count = $this->input->post('count') ? $this->input->post('count') : NULL;





        //validate form input

        $this->form_validation->set_rules('customer', $this->lang->line("customer"), 'trim|required');

        $this->form_validation->set_rules('warehouse', $this->lang->line("warehouse"), 'required');

        $this->form_validation->set_rules('biller', $this->lang->line("biller"), 'required');
        
        $this->form_validation->set_rules('invoice_type', $this->lang->line("invoice_type"), 'required');



        if ($this->form_validation->run() == true) {

            
            $quantity = "quantity";

            $product = "product";

            $unit_cost = "unit_cost";

            $tax_rate = "tax_rate";



            $date = date('Y-m-d H:i:s');

            $warehouse_id = $this->input->post('warehouse');

            $customer_id = $this->input->post('customer');

            $biller_id = $this->input->post('biller');
            
            
            $total_items = $this->input->post('total_items');

            $invoice_type = $this->input->post('invoice_type');

            $service_no = $this->input->post('service_no');
            $tax_summary = $this->input->post('pptaxsummory');

            if(empty($tax_summary))

            {

                $tax_summary = 0;

            }

            

            if($invoice_type == 1)

            {

                $pinvoice_type = 'pos';

            }else

            {

                $pinvoice_type = 'posc';

            }

            //$sale_status = $this->input->post('sale_status');

            $sale_status = 'completed';

            $payment_status = 'due';

            $payment_term = 0;

            $due_date = date('Y-m-d', strtotime('+' . $payment_term . ' days'));

            $shipping = $this->input->post('shipping') ? $this->input->post('shipping') : 0;

            $customer_details = $this->site->getCompanyByID($customer_id);

            $customer = $customer_details->name;
            
            $customer_phone = $customer_details->phone;

            $biller_details = $this->site->getCompanyByID($biller_id);

            $biller = $biller_details->company != '-' ? $biller_details->company : $biller_details->name;

            $note = $this->sma->clear_tags($this->input->post('pos_note'));

            $staff_note = $this->sma->clear_tags($this->input->post('staff_note'));

            $reference = $this->site->getReference($pinvoice_type);

            $non_member_price = $this->input->post('non_gtotal');


            $total = 0;

            $product_tax = 0;

            $order_tax = 0;

            $product_discount = 0;

            $order_discount = 0;

            $coupon_discount = 0;
    
            $percentage = '%';

            $i = isset($_POST['product_code']) ? sizeof($_POST['product_code']) : 0;

            for ($r = 0; $r < $i; $r++) {

                $item_id = $_POST['product_id'][$r];

                $item_type = $_POST['product_type'][$r];

                $item_code = $_POST['product_code'][$r];

                $item_name = $_POST['product_name'][$r];

                $item_hsn_sac = $_POST['hsn_sac'][$r];

                $item_per_type = $_POST['per_type'][$r];

                $sitem_id = $_POST['item_id'][$r];


                $item_option = isset($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' ? $_POST['product_option'][$r] : NULL;

                //$option_details = $this->pos_model->getProductOptionByID($item_option);

                $real_unit_price = $this->sma->formatDecimal($_POST['real_unit_price'][$r]);

                $unit_price = $this->sma->formatDecimal($_POST['unit_price'][$r]);

                $item_quantity = $_POST['quantity'][$r];

                $item_serial = isset($_POST['serial'][$r]) ? $_POST['serial'][$r] : '';

                $item_tax_rate = isset($_POST['product_tax'][$r]) ? $_POST['product_tax'][$r] : NULL;

                $item_discount = isset($_POST['product_discount'][$r]) ? $_POST['product_discount'][$r] : NULL;



                if (isset($item_code) && isset($real_unit_price) && isset($unit_price) && isset($item_quantity)) {

                    $product_details = $item_type != 'manual' ? $this->pos_model->getProductByCode($item_code) : NULL;

                    $unit_price = $real_unit_price;

                    $pr_discount = 0;



                    if (isset($item_discount)) {

                        $discount = $item_discount;

                        $dpos = strpos($discount, $percentage);

                        if ($dpos !== false) {

                            $pds = explode("%", $discount);

                            $pr_discount = (($this->sma->formatDecimal($unit_price)) * (Float)($pds[0])) / 100;

                        } else {

                            $pr_discount = $this->sma->formatDecimal($discount);

                        }

                    }



                    $unit_price = $this->sma->formatDecimal($unit_price - $pr_discount);

                    $item_net_price = $unit_price;

                    $pr_item_discount = $this->sma->formatDecimal($pr_discount * $item_quantity);

                    $product_discount += $pr_item_discount;

                    $pr_tax = 0; $pr_item_tax = 0; $item_tax = 0; $tax = "";



                    if (isset($item_tax_rate) && $item_tax_rate != 0) {

                        $pr_tax = $item_tax_rate;

                        $tax_details = $this->site->getTaxRateByID($pr_tax);

                        if ($tax_details->type == 1 && $tax_details->rate != 0) {



                            if ($product_details && $product_details->tax_method == 1) {

                                $item_tax = $this->sma->formatDecimal((($unit_price) * $tax_details->rate) / 100);

                                $tax = $tax_details->rate . "%";

                            } else {

                                $item_tax = $this->sma->formatDecimal((($unit_price) * $tax_details->rate) / (100 + $tax_details->rate));

                                $tax = $tax_details->rate . "%";

                                $item_net_price = $unit_price - $item_tax;

                            }



                        } elseif ($tax_details->type == 2) {



                            if ($product_details && $product_details->tax_method == 1) {

                                $item_tax = $this->sma->formatDecimal((($unit_price) * $tax_details->rate) / 100);

                                $tax = $tax_details->rate . "%";

                            } else {

                                $item_tax = $this->sma->formatDecimal((($unit_price) * $tax_details->rate) / (100 + $tax_details->rate));

                                $tax = $tax_details->rate . "%";

                                $item_net_price = $unit_price - $item_tax;

                            }



                            $item_tax = $this->sma->formatDecimal($tax_details->rate);

                            $tax = $tax_details->rate;



                        }

                        $pr_item_tax = $this->sma->formatDecimal($item_tax * $item_quantity);



                    }



                    $product_tax += $pr_item_tax;

                    $subtotal = (($item_net_price * $item_quantity) + $pr_item_tax);

                    $k = $_POST['quantity'][$r];

                    for($p = 0; $p < $k; $p++) {
                        
                            
                        $ps = 'staff_'.$item_code.'_'.$sitem_id.'['.$p.']';

                        $this->form_validation->set_rules($ps, lang("staff"), 'required');


                        $staff_id = $_POST['staff_'.$item_code.'_'.$sitem_id.''][$p];



                        $staff = $this->pos_model->getStaffByID($staff_id);

                        if($staff){
                        $staffs[] = array(

                            'product_id' => $product_details->id,

                            'product_code' => $item_code,

                            'sale_item_id' => $sitem_id,

                            'created_on' => $date,

                            'product_name' => $product_details->name,

                            'staff_id' => $_POST['staff_'.$item_code.'_'.$sitem_id.''][$p],

                            'staff_name' => $staff->name,

                            'net_unit_price' => $item_net_price,

                            'unit_price' => $this->sma->formatDecimal($item_net_price + $item_tax),

                            'customer_id' => $customer_id
                        );
                        }else
                        {
                            $staffs[] = '';
                        }

                        
                    }


                    $products[] = array(

                        'product_id' => $item_id,

                        'sale_item_id' => $sitem_id,

                        'product_code' => $item_code,

                        'product_name' => $item_name,

                        'product_type' => $item_type,

                        'option_id' => $item_option,

                        'net_unit_price' => $item_net_price,

                        'unit_price' => $this->sma->formatDecimal($item_net_price + $item_tax),

                        'quantity' => $item_quantity,

                        'warehouse_id' => $warehouse_id,

                        'item_tax' => $pr_item_tax,

                        'tax_rate_id' => $pr_tax,

                        'tax' => $tax,

                        'discount' => $item_discount,

                        'item_discount' => $pr_item_discount,

                        'subtotal' => $this->sma->formatDecimal($subtotal),

                        'serial_no' => $item_serial,

                        'real_unit_price' => $real_unit_price,

                        'hsn_sac' => $item_hsn_sac,

                        'per_type' => $item_per_type

                    );



                    $total += $item_net_price * $item_quantity;

                    
                }

            }

            if (empty($products)) {

                $this->form_validation->set_rules('product', lang("order_items"), 'required');

            } else {

                krsort($products);

            }


            if ($this->Settings->tax2) {

                $order_tax_id = $this->input->post('order_tax');

                if ($order_tax_details = $this->site->getTaxRateByID($order_tax_id)) {

                    if ($order_tax_details->type == 2) {

                        $order_tax = $this->sma->formatDecimal($order_tax_details->rate);

                    }

                    if ($order_tax_details->type == 1) {

                        $order_tax = $this->sma->formatDecimal((($total + $product_tax - $order_discount - $coupon_discount) * $order_tax_details->rate) / 100);

                    }

                }

            } else {

                $order_tax_id = NULL;

            }

            $total_tax = $this->sma->formatDecimal($product_tax + $order_tax);
            $ttotal = $total + $total_tax;
            if ($this->input->post('discount')) {

                $order_discount_id = $this->input->post('discount');

                $discount_id = $this->input->post('discount_id');

                $opos = strpos($order_discount_id, $percentage);

                if ($opos !== false) {

                    $ods = explode("%", $order_discount_id);

                    $order_discount = $this->sma->formatDecimal((($ttotal) * (Float)($ods[0])) / 100);

                } else {

                    $order_discount = $this->sma->formatDecimal($order_discount_id);

                }

            } else {

                $order_discount_id = NULL;
                $discount_id = NULL;

            }


            if ($this->input->post('coupon')) {

                $coupon_discount_id = $this->input->post('coupon');

                $coupon_id = $this->input->post('coupon_id');

                $copos = strpos($coupon_discount_id, $percentage);

                if ($copos !== false) {

                    $cods = explode("%", $coupon_discount_id);

                    $coupon_discount = $this->sma->formatDecimal((($ttotal) * (Float)($cods[0])) / 100);

                } else {

                    $coupon_discount = $this->sma->formatDecimal($coupon_discount_id);

                }

            } else {

                $coupon_discount_id = NULL;
                $coupon_id = NULL;

            }
            $total_discount = $this->sma->formatDecimal($coupon_discount + $order_discount + $product_discount);


            $grand_total = $this->sma->formatDecimal($this->sma->formatDecimal($total) + $total_tax + $this->sma->formatDecimal($shipping) - $order_discount - $coupon_discount);

            //print_r($this->input->post('amount-paid'));die();

            $data = array('date' => $date,

                'reference_no' => $reference,

                'customer_id' => $customer_id,

                'customer' => $customer,

                'biller_id' => $biller_id,

                'biller' => $biller,
                
                'warehouse_id' => $warehouse_id,

                'note' => $note,

                'staff_note' => $staff_note,

                'total' => $this->sma->formatDecimal($total),

                'product_discount' => $this->sma->formatDecimal($product_discount),

                'order_discount_id' => $order_discount_id,

                'discount_id' => $discount_id,

                'order_discount' => $order_discount,

                'coupon_discount_id' => $coupon_discount_id,

                'coupon_id' => $coupon_id,

                'coupon_discount' => $coupon_discount,

                'total_discount' => $total_discount,

                'product_tax' => $this->sma->formatDecimal($product_tax),

                'order_tax_id' => $order_tax_id,

                'order_tax' => $order_tax,

                'total_tax' => $total_tax,

                'shipping' => $this->sma->formatDecimal($shipping),

                'grand_total' => $grand_total,

                'non_member_price' => $non_member_price,

                'total_items' => $total_items,

                'sale_status' => $sale_status,

                'payment_status' => $payment_status,

                'payment_term' => $payment_term,

                'pos' => 1,

                'paid' => $this->input->post('amount-paid') ? $this->input->post('amount-paid') : 0,

                'created_by' => $this->session->userdata('user_id'),

                'invoice_type' => $invoice_type,

                'service_no' => $service_no,

                'tax_summary' => $tax_summary,

            );



            if (!$suspend) {
                $p = isset($_POST['amount']) ? sizeof($_POST['amount']) : 0;
                for ($r = 0; $r < $p; $r++) {
                    if (isset($_POST['amount'][$r]) && !empty($_POST['amount'][$r]) && isset($_POST['paid_by'][$r]) && !empty($_POST['paid_by'][$r])) {
                        $amount = $this->sma->formatDecimal($_POST['balance_amount'][$r] > 0 ? $_POST['amount'][$r] - $_POST['balance_amount'][$r] : $_POST['amount'][$r]);
                        if($_POST['paid_by'][$r] == 'Wallet'){
                            $customer_award_point = $this->site->getCompanyByID($customer_id);
                            if($_POST['amount'][$r] > $customer_award_point->award_points){
                                $this->form_validation->set_rules('wallet', lang("wallet amount less than you added amount"), 'required|valid_wallet');

                                $this->form_validation->set_message('valid_wallet', 'wallet amount less than you added amount');
                            }
        
                        }
                        $payment[] = array(
                            'date' => $date,
                            'reference_no' => $this->site->getReference('pay'),
                            'amount' => $amount,
                            'paid_by' => $_POST['paid_by'][$r],
                            'cheque_no' => $_POST['cheque_no'][$r],
                            'bajaj_no' => $_POST['bajaj_no'][$r],
                            'neft_no' => $_POST['neft_no'][$r],
                            'paytm_no' => $_POST['paytm_no'][$r],
                            'cc_no' => ($_POST['paid_by'][$r] == 'gift_card' ? $_POST['paying_gift_card_no'][$r] : $_POST['cc_no'][$r]),
                            'created_by' => $this->session->userdata('user_id'),
                            'type' => 'received',
                            'note' => $_POST['payment_note'][$r],
                            'pos_paid' => $_POST['amount'][$r],
                            'pos_balance' => $_POST['balance_amount'][$r]
                        );
                        $pp[] = $amount;
                        $this->site->updateReference('pay');
                    }
                }
                if (!empty($pp)) {
                    $paid = array_sum($pp);
                } else {
                    $paid = 0;
                }
                if ($paid = 0) {
                    $payment_term = 'pending';
                } elseif ($grand_total <= $paid) {
                    $payment_term = 'paid';
                } elseif ($grand_total >= $paid) {
                    $payment_term = 'partial';
                }
            }
            

            if (!isset($payment) || empty($payment)) {

                $payment = array();

            }



            // $this->sma->print_arrays($data, $products, $payment);

        }





        if ($this->form_validation->run() == true && !empty($products) && !empty($data)) {

            $sms = $this->site->getAllSms();


            if ($suspend) {

                $data['suspend_note'] = $this->input->post('suspend_note');

                if ($this->pos_model->suspendSale($data, $products, $did)) {

                    $this->session->set_userdata('remove_posls', 1);

                    $this->session->set_flashdata('message', $this->lang->line("sale_suspended"));

                    redirect("pos");

                }

            } else {

                if ($sale = $this->pos_model->addSale($data, $products, $payment, $did, $pinvoice_type, $staffs)) {

                    $this->session->set_userdata('remove_posls', 1);


                    
                    $msg = $this->lang->line("sale_added");

                    if($sms->sale_sent == 1){
                        $to = $customer_phone;
                        
                        $raw_message = $sms->sale;
                        
                        $msg1 = str_replace("{contact_person}",$customer,$raw_message);

                        
                        $msg2 = str_replace("{reference_number}",$reference,$msg1);

                        $msg3 = str_replace("{amount}",$grand_total,$msg2);
                        
                        $message = str_replace("{site_name}",$this->Settings->site_name,$msg3);
                        
                        
                        $this->sma->send_sms($to, $message);
       
                    }



                    if (!empty($sale['message'])) {

                        foreach ($sale['message'] as $m) {

                            $msg .= '<br>' . $m;

                        }

                    }

                    //echo $msg; die();

                    $this->session->set_flashdata('message', $msg);

                    redirect("pos/view/" . $sale['sale_id']);

                }

            }

        } else {

            $this->data['suspend_sale'] = NULL;

            if ($sid) {

                $suspended_sale = $this->pos_model->getOpenBillByID($sid);
                $inv_items = $this->pos_model->getSuspendedSaleItems($sid);
                $c = rand(100000, 9999999);
                foreach ($inv_items as $item) {

                    $row = $this->site->getProductByID($item->product_id);

                    if (!$row) {

                        $row = json_decode('{}');

                        $row->tax_method = 0;

                        $row->quantity = 0;

                    } else {

                        unset($row->details, $row->product_details, $row->cost, $row->supplier1price, $row->supplier2price, $row->supplier3price, $row->supplier4price, $row->supplier5price);

                    }

                    $pis = $this->pos_model->getPurchasedItems($item->product_id, $item->warehouse_id, $item->option_id);

                    if($pis){

                        foreach ($pis as $pi) {

                            $row->quantity += $pi->quantity_balance;

                        }

                    }

                    $row->id = $item->product_id;

                    $row->code = $item->product_code;

                    $row->name = $item->product_name;

                    $row->type = $item->product_type;

                    $row->hsn_sac = $item->hsn_sac;

                    $row->per_type = $item->per_type;

                    $row->qty = $item->quantity;

                    $row->quantity += $item->quantity;

                    $row->discount = $item->discount ? $item->discount : '0';

                    $row->price = $this->sma->formatDecimal($item->net_unit_price+$this->sma->formatDecimal($item->item_discount/$item->quantity));

                    $row->unit_price = $row->tax_method ? $item->unit_price+$this->sma->formatDecimal($item->item_discount/$item->quantity)+$this->sma->formatDecimal($item->item_tax/$item->quantity) : $item->unit_price+($item->item_discount/$item->quantity);

                    $row->real_unit_price = $item->real_unit_price;

                    $row->tax_rate = $item->tax_rate_id;

                    $row->serial = $item->serial_no;

                    $row->option = $item->option_id;

                    $options = $this->pos_model->getProductOptions($row->id, $item->warehouse_id);



                    if ($options) {

                        $option_quantity = 0;

                        foreach ($options as $option) {

                            $pis = $this->pos_model->getPurchasedItems($row->id, $item->warehouse_id, $item->option_id);

                            if($pis){

                                foreach ($pis as $pi) {

                                    $option_quantity += $pi->quantity_balance;

                                }

                            }

                            if($option->quantity > $option_quantity) {

                                $option->quantity = $option_quantity;

                            }

                        }

                    }



                    $ri = $this->Settings->item_addition ? $row->id : $c;

                    if ($row->tax_rate) {

                        $tax_rate = $this->site->getTaxRateByID($row->tax_rate);

                        $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'tax_rate' => $tax_rate, 'options' => $options);

                    } else {

                        $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'tax_rate' => false, 'options' => $options);

                    }

                    $c++;

                }



                $this->data['items'] = json_encode($pr);

                $this->data['sid'] = $sid;

                $this->data['suspend_sale'] = $suspended_sale;

                $this->data['message'] = lang('suspended_sale_loaded');

                $this->data['customer'] = $this->pos_model->getCompanyByID($suspended_sale->customer_id);

                $this->data['reference_note'] = $suspended_sale->suspend_note;

            } else {

                $this->data['customer'] = $this->pos_model->getCompanyByID($this->pos_settings->default_customer);

                $this->data['reference_note'] = NULL;

            }



            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['message'] = isset($this->data['message']) ? $this->data['message'] : $this->session->flashdata('message');

            $this->data['coupons'] = $this->site->getAllAvailableCoupons();
            

            $this->data['biller'] = $this->site->getCompanyByID($this->pos_settings->default_biller);

            $this->data['billers'] = $this->site->getAllCompanies('biller');

            $this->data['staffs'] = $this->site->getAllStaffs();
            
            $this->data['discounts'] = $this->site->getAllDiscounts();


            //print_r($this->data['billers']); die();

            $this->data['warehouses'] = $this->site->getAllWarehouses();

            $this->data['tax_rates'] = $this->site->getAllTaxRates();

            $this->data['per_types'] = $this->site->getAllPerType();

            $this->data['invoice_types'] = $this->site->getAllInvoiceType();

            $this->data['user'] = $this->site->getUser();

            $this->data["tcp"] = $this->pos_model->products_count($this->pos_settings->default_category);

            $this->data['products'] = $this->ajaxproducts($this->pos_settings->default_category);

            $this->data['categories'] = $this->site->getAllCategories();

            $this->data['subcategories'] = $this->pos_model->getSubCategoriesByCategoryID($this->pos_settings->default_category);

            $this->data['pos_settings'] = $this->pos_settings;



            $this->load->view($this->theme . 'pos/add', $this->data);

        }

    }

function discount_suggestions()
    {
        $term = $this->input->get('term', TRUE);
        $customer_id = $this->input->get('customer_id', TRUE);
        $price = $this->input->get('price', TRUE);

        $non_total = $this->input->get('non_total', TRUE);
        $total = $this->input->get('total', TRUE);
        $tax = $this->input->get('tax', TRUE);
        
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $customer = $this->site->getCompanyByID($customer_id);
        
        $row = $this->pos_model->getdiscount($term);
        $pr = array();
        if($row->customer_group_id == '3'){
            $customer_group = $this->site->getCustomerGroupByID($customer->customer_group_id);
            if($customer->customer_group_id == 4){          
            if(floatval($row->price_for_value) <= floatval($total)){

            $percentage = '%';

            $discount = $row->value;

            $dpos = strpos($discount, $percentage);

            if ($dpos !== false) {

                $pds = explode("%", $discount);

                // $pr_discount = (($this->sma->formatDecimal($total)) * (Float)($pds[0])) / 100;
                $pr_discount = $discount;

            } else {

                $pr_discount = $this->sma->formatDecimal($discount);

            }    
              
            $pr = array('status' => 1, 'value'=> $pr_discount, 'name' => $row->name);
            }else{
            $pr = array('status' => 0,'fail' => 'Price Not reached above"'.$row->price_for_value.'"');
            }
            }else{
            
            if(floatval($row->price_for_value) <= floatval($total)){
            $dis = floatval($total) - floatval($total);
            
            $percentage = '%';

            $discount = $row->value;

            $dpos = strpos($discount, $percentage);

            if ($dpos !== false) {

                $pds = explode("%", $discount);

                // $pr_discount = (($this->sma->formatDecimal($total)) * (Float)($pds[0])) / 100;
                $pr_discount = $discount;
            } else {

                $pr_discount = $this->sma->formatDecimal($discount);

            }
            $fdis = floatval($pr_discount) - floatval($dis);  

            $pr = array('status' => 1, 'value'=> $pr_discount, 'name' => $row->name);
            }else{
            $pr = array('status' => 0,'fail' => 'Price Not reached above"'.$row->price_for_value.'"');
            }
                
            }
        }else if($row->customer_group_id == $customer->customer_group_id){
            $customer_group = $this->site->getCustomerGroupByID($row->customer_group_id);
            if(floatval($row->price_for_value) <= floatval($total)){
            
            $percentage = '%';

            $discount = $row->value;

            $dpos = strpos($discount, $percentage);

            if ($dpos !== false) {

                $pds = explode("%", $discount);

                // $pr_discount = (($this->sma->formatDecimal($total)) * (Float)($pds[0])) / 100;
                $pr_discount = $discount;
            } else {

                $pr_discount = $this->sma->formatDecimal($discount);

            }

            $pr = array('status' => 1, 'value'=> $pr_discount, 'name' => $row->name);
            }else{
            $pr = array('status' => 0,'fail' => 'Price Not reached abov"'.$row->price_for_value.'"');
            }
        }else
        {
            $customer_group = $this->site->getCustomerGroupByID($row->customer_group_id);
        
            $pr = array('status' => 0,'fail' => 'customer not"'.$customer_group->name.'"');
        }
        
        echo json_encode($pr);
        
    }

    function coupon_suggestions()
    {
        $term = $this->input->get('term', TRUE);
        $customer_id = $this->input->get('customer_id', TRUE);
        $price = $this->input->get('price', TRUE);
        $non_total = $this->input->get('non_total', TRUE);
        $total = $this->input->get('total', TRUE);
        $tax = $this->input->get('tax', TRUE);
        
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . site_url('welcome') . "'; }, 10);</script>");
        }

        $customer = $this->site->getCompanyByID($customer_id);
        
        $row = $this->pos_model->getcoupon($term, $customer_id);
        $pr = array();
        if($row != FALSE){
            if($row->balance > 0){          
                if(floatval($row->balance) <= floatval($total)){
                    $pr = array('status' => 1, 'value'=> $row->balance, 'name' => $row->coupon."(".$row->card_no.")");
                }else{

                    $pr = array('status' => 1, 'value'=> $total, 'name' => $row->coupon."(".$row->card_no.")");
                }
            }else{
            
                    $pr = array('status' => 0,'fail' => 'This Coupon full amount is already applied');
                    
            }
        }else
        {
        
            $pr = array('status' => 0,'fail' => 'customer not have this coupon');
        }
        
        echo json_encode($pr);
        
    }



    function view_bill()

    {

        $this->sma->checkPermissions('index');

        $this->data['tax_rates'] = $this->site->getAllTaxRates();

        $this->load->view($this->theme . 'pos/view_bill', $this->data);

    }



    function stripe_balance()

    {

        if (!$this->Owner) {

            return FALSE;

        }

        $this->load->model('stripe_payments');

        return $this->stripe_payments->get_balance();

    }



    function paypal_balance()

    {

        if (!$this->Owner) {

            return FALSE;

        }

        $this->load->model('paypal_payments');

        return $this->paypal_payments->get_balance();

    }



    function registers()

    {

        $this->sma->checkPermissions();



        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

        $this->data['registers'] = $this->pos_model->getOpenRegisters();

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('pos'), 'page' => lang('pos')), array('link' => '#', 'page' => lang('open_registers')));

        $meta = array('page_title' => lang('open_registers'), 'bc' => $bc);

        $this->page_construct('pos/registers', $meta, $this->data);

    }



    function open_register()

    {

        $this->sma->checkPermissions('index');

        $this->form_validation->set_rules('cash_in_hand', lang("cash_in_hand"), 'trim|required|numeric');



        if ($this->form_validation->run() == true) {

            $data = array('date' => date('Y-m-d H:i:s'),

                'cash_in_hand' => $this->input->post('cash_in_hand'),

                'user_id' => $this->session->userdata('user_id'),

                'status' => 'open',

            );

        }

        if ($this->form_validation->run() == true && $this->pos_model->openRegister($data)) {

            $this->session->set_flashdata('message', lang("welcome_to_pos"));

            redirect("pos");

        } else {



            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('open_register')));

            $meta = array('page_title' => lang('open_register'), 'bc' => $bc);

            $this->page_construct('pos/open_register', $meta, $this->data);

        }

    }



    function close_register($user_id = NULL)

    {

        $this->sma->checkPermissions('index');

        if (!$this->Owner && !$this->Admin) {

            $user_id = $this->session->userdata('user_id');

        }

        $this->form_validation->set_rules('total_cash', lang("total_cash"), 'trim|required|numeric');

        $this->form_validation->set_rules('total_cheques', lang("total_cheques"), 'trim|required|numeric');

        $this->form_validation->set_rules('total_cc_slips', lang("total_cc_slips"), 'trim|required|numeric');



        if ($this->form_validation->run() == true) {

            if ($this->Owner || $this->Admin) {

                $user_register = $user_id ? $this->pos_model->registerData($user_id) : NULL;

                $rid = $user_register ? $user_register->id : $this->session->userdata('register_id');

                $user_id = $user_register ? $user_register->user_id : $this->session->userdata('user_id');

            } else {

                $rid = $this->session->userdata('register_id');

                $user_id = $this->session->userdata('user_id');

            }

            $data = array('closed_at' => date('Y-m-d H:i:s'),

                'total_cash' => $this->input->post('total_cash'),

                'total_cheques' => $this->input->post('total_cheques'),

                'total_cc_slips' => $this->input->post('total_cc_slips'),

                'total_cash_submitted' => $this->input->post('total_cash_submitted'),

                'total_cheques_submitted' => $this->input->post('total_cheques_submitted'),

                'total_cc_slips_submitted' => $this->input->post('total_cc_slips_submitted'),

                'note' => $this->input->post('note'),

                'status' => 'close',

                'transfer_opened_bills' => $this->input->post('transfer_opened_bills'),

                'closed_by' => $this->session->userdata('user_id'),

            );

        } elseif ($this->input->post('close_register')) {

            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : $this->session->flashdata('error')));

            redirect("pos");

        }



        if ($this->form_validation->run() == true && $this->pos_model->closeRegister($rid, $user_id, $data)) {

            $this->session->set_flashdata('message', lang("register_closed"));

            redirect("welcome");

        } else {

            if ($this->Owner || $this->Admin) {

                $user_register = $user_id ? $this->pos_model->registerData($user_id) : NULL;

                $register_open_time = $user_register ? $user_register->date : $this->session->userdata('register_open_time');

                $this->data['cash_in_hand'] = $user_register ? $user_register->cash_in_hand : NULL;

                $this->data['register_open_time'] = $user_register ? $register_open_time : NULL;

            } else {

                $register_open_time = $this->session->userdata('register_open_time');

                $this->data['cash_in_hand'] = NULL;

                $this->data['register_open_time'] = NULL;

            }

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['ccsales'] = $this->pos_model->getRegisterCCSales($register_open_time, $user_id);

            $this->data['cashsales'] = $this->pos_model->getRegisterCashSales($register_open_time, $user_id);

            $this->data['chsales'] = $this->pos_model->getRegisterChSales($register_open_time, $user_id);

            $this->data['pppsales'] = $this->pos_model->getRegisterPPPSales($register_open_time, $user_id);

            $this->data['stripesales'] = $this->pos_model->getRegisterStripeSales($register_open_time, $user_id);

            $this->data['totalsales'] = $this->pos_model->getRegisterSales($register_open_time, $user_id);

            $this->data['refunds'] = $this->pos_model->getRegisterRefunds($register_open_time);

            $this->data['cashrefunds'] = $this->pos_model->getRegisterCashRefunds($register_open_time);

            $this->data['expenses'] = $this->pos_model->getRegisterExpenses($register_open_time);

            $this->data['users'] = $this->pos_model->getUsers($user_id);

            $this->data['suspended_bills'] = $this->pos_model->getSuspendedsales($user_id);

            $this->data['user_id'] = $user_id;

            $this->data['modal_js'] = $this->site->modal_js();

            $this->load->view($this->theme . 'pos/close_register', $this->data);

        }

    }



    function getProductDataByCode($code = NULL, $warehouse_id = NULL)

    {

        $this->sma->checkPermissions('index');

        if ($this->input->get('code')) {

            $code = $this->input->get('code', TRUE);

        }

        if ($this->input->get('warehouse_id')) {

            $warehouse_id = $this->input->get('warehouse_id', TRUE);

        }

        if ($this->input->get('customer_id')) {

            $customer_id = $this->input->get('customer_id', TRUE);

        }

        if (!$code) {

            echo NULL;

            die();

        }

        $customer = $this->site->getCompanyByID($customer_id);

        $customer_group = $this->site->getCustomerGroupByID($customer->customer_group_id);

        $row = $this->pos_model->getWHProduct($code, $warehouse_id);



        $option = '';

        if ($row) {

            $combo_items = FALSE;
            $option = FALSE;

            $row->quantity = 0;

            $row->item_tax_method = $row->tax_method;

            $row->qty = 1;
            
            $row->discount = '0';
                
            $row->serial = '';

            
            $options = $this->pos_model->getProductOptions($row->id, $warehouse_id);

            if ($options) {

                $opt = current($options);

                if (!$option) {

                    $option = $opt->id;

                }

            } else {

                $opt = json_decode('{}');

                $opt->price = 0;

            }

            $row->option = $option;

            $pis = $this->pos_model->getPurchasedItems($row->id, $warehouse_id, $row->option);

            if($pis){

                foreach ($pis as $pi) {

                    $row->quantity += $pi->quantity_balance;

                }

            }

            // if (!$this->Settings->overselling) {

            //     if ($row->quantity <= 0) {

            //         echo NULL;

            //         die();

            //     }

            // }

            if ($options) {

                $option_quantity = 0;

                foreach ($options as $option) {

                    $pis = $this->pos_model->getPurchasedItems($row->id, $warehouse_id, $row->option);

                    if($pis){

                        foreach ($pis as $pi) {

                            $option_quantity += $pi->quantity_balance;

                        }

                    }

                    if($option->quantity > $option_quantity) {

                        $option->quantity = $option_quantity;

                    }

                }

            }
            
            if ($opt->price != 0) {

                $row->price = $opt->price + (($opt->price * $customer_group->percent) / 100);

            } else {

                $row->price = $row->price + (($row->price * $customer_group->percent) / 100);

            }
            
            $row->real_unit_price = $row->price;

            $combo_items = FALSE;

            if ($row->tax_rate) {

                $tax_rate = $this->site->getTaxRateByID($row->tax_rate);

                if ($row->type == 'combo') {

                    $combo_items = $this->pos_model->getProductComboItems($row->id, $warehouse_id);

                }

                $pr = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'options' => $options, 'group' => $customer_group->id);

            } else {

                $pr = array('id' => str_replace(".", "", microtime(true)), 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => false, 'options' => $options, 'group' => $customer_group->id);

            }

            echo json_encode($pr);

        } else {

            echo NULL;

        }

    }



    function ajaxproducts()

    {

        $this->sma->checkPermissions('index');

        if ($this->input->get('category_id')) {

            $category_id = $this->input->get('category_id');

        } else {

            $category_id = $this->pos_settings->default_category;

        }

        if ($this->input->get('subcategory_id')) {

            $subcategory_id = $this->input->get('subcategory_id');

        } else {

            $subcategory_id = NULL;

        }

        if ($this->input->get('per_page') == 'n') {

            $page = 0;

        } else {

            $page = $this->input->get('per_page');

        }



        $this->load->library("pagination");



        $config = array();

        $config["base_url"] = base_url() . "pos/ajaxproducts";

        $config["total_rows"] = $subcategory_id ? $this->pos_model->products_count($category_id, $subcategory_id) : $this->pos_model->products_count($category_id);

        $config["per_page"] = $this->pos_settings->pro_limit;

        $config['prev_link'] = FALSE;

        $config['next_link'] = FALSE;

        $config['display_pages'] = FALSE;

        $config['first_link'] = FALSE;

        $config['last_link'] = FALSE;



        $this->pagination->initialize($config);



        $products = $subcategory_id ? $this->pos_model->fetch_products($category_id, $config["per_page"], $page, $subcategory_id) : $this->pos_model->fetch_products($category_id, $config["per_page"], $page);

        $pro = 1;

        $prods = '<div>';


        if($products){
        foreach ($products as $product) {

            $count = $product->id;

            if ($count < 10) {

                $count = "0" . ($count / 100) * 100;

            }

            if ($category_id < 10) {

                $category_id = "0" . ($category_id / 100) * 100;

            }



            $prods .= "<button id=\"product-" . $category_id . $count . "\" type=\"button\" value='" . $product->code . "' title=\"" . $product->name . "\" class=\"btn-prni btn-" . $this->pos_settings->product_button_color . " product pos-tip\" data-container=\"body\"><img src=\"" . base_url() . "assets/uploads/thumbs/" . $product->image . "\" alt=\"" . $product->name . "\" style='width:" . $this->Settings->twidth . "px;height:" . $this->Settings->theight . "px;' class='img-rounded' /><span>" . character_limiter($product->name, 40) . "</span></button>";



            $pro++;

        }
        }



        $prods .= "</div>";



        if ($this->input->get('per_page')) {

            echo $prods;

        } else {

            return $prods;

        }

    }


    function ajaxcategorydata($category_id = NULL)

    {

        $this->sma->checkPermissions('index');

        if ($this->input->get('category_id')) {

            $category_id = $this->input->get('category_id');

        } else {

            $category_id = $this->pos_settings->default_category;

        }



        $subcategories = $this->pos_model->getSubCategoriesByCategoryID($category_id);

        $scats = '';

        if($subcategories) {

            foreach ($subcategories as $category) {

                $scats .= "<button id=\"subcategory-" . $category->id . "\" type=\"button\" value='" . $category->id . "' class=\"btn-prni subcategory\" ><img src=\"assets/uploads/thumbs/" . ($category->image ? $category->image : 'no_image.png') . "\" style='width:" . $this->Settings->twidth . "px;height:" . $this->Settings->theight . "px;' class='img-rounded img-thumbnail' /><span>" . $category->name . "</span></button>";

            }

        }



        $products = $this->ajaxproducts($category_id);



        if (!($tcp = $this->pos_model->products_count($category_id))) {

            $tcp = 0;

        }



        echo json_encode(array('products' => $products, 'subcategories' => $scats, 'tcp' => $tcp));

    }



    /* ------------------------------------------------------------------------------------ */



    function view($sale_id = NULL, $modal = NULL)

    {

        $this->sma->checkPermissions('index');

        if ($this->input->get('id')) {

            $sale_id = $this->input->get('id');

        }

        $this->load->helper('text');

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

        $this->data['message'] = $this->session->flashdata('message');

        $this->data['rows'] = $this->pos_model->getAllInvoiceItems($sale_id);

        $inv = $this->pos_model->getInvoiceByID($sale_id);

        $biller_id = $inv->biller_id;

        $customer_id = $inv->customer_id;
        
        $staff_id = $inv->staff_id;

        $discount_id = $inv->discount_id;

        $this->data['biller'] = $this->pos_model->getCompanyByID($biller_id);
        
        $this->data['staffs'] = $this->pos_model->getStaffBysaleID($sale_id);

        $this->data['customer'] = $this->pos_model->getCompanyByID($customer_id);
        
        if($discount_id != NULL){
        $this->data['discount'] = $this->pos_model->getDiscountByID($discount_id);
        
        }
        $coupon_id = $inv->coupon_id;
        if($coupon_id != NULL){
        $this->data['coupon'] = $this->pos_model->getCouponByID($coupon_id);
        
        }
            

        $this->data['customer_group'] = $this->site->getCustomerGroupByID($this->data['customer']->customer_group_id);


        $this->data['payments'] = $this->pos_model->getInvoicePayments($sale_id);

        $this->data['pos'] = $this->pos_model->getSetting();

        $this->data['barcode'] = $this->barcode($inv->reference_no, 'code39', 30);

        $this->data['inv'] = $inv;

        $this->data['sid'] = $sale_id;

        $this->data['modal'] = $modal;

        $this->data['page_title'] = $this->lang->line("invoice");
        
        if($modal == NULL){
            $this->load->view($this->theme . 'pos/view_print', $this->data);
  
        }else
        {
            $this->load->view($this->theme . 'pos/view', $this->data);
    
        }
        $customerGroupName = strtolower($this->data['customer_group']->name);
        if ($customerGroupName == 'non member') {
            $this->pos_model->updateCustomerGroupToMember($this->data['customer']->id);
            $this->pos_model->updateCustomerMembershipPlan($this->data['rows'],$this->data['customer']->id);
        }
        
        
    }



    function register_details()

    {

        $this->sma->checkPermissions('index');

        $register_open_time = $this->session->userdata('register_open_time');

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

        $this->data['ccsales'] = $this->pos_model->getRegisterCCSales($register_open_time);

        $this->data['cashsales'] = $this->pos_model->getRegisterCashSales($register_open_time);

        $this->data['chsales'] = $this->pos_model->getRegisterChSales($register_open_time);

        $this->data['pppsales'] = $this->pos_model->getRegisterPPPSales($register_open_time);

        $this->data['stripesales'] = $this->pos_model->getRegisterStripeSales($register_open_time);

        $this->data['totalsales'] = $this->pos_model->getRegisterSales($register_open_time);

        $this->data['refunds'] = $this->pos_model->getRegisterRefunds($register_open_time);

        $this->data['expenses'] = $this->pos_model->getRegisterExpenses($register_open_time);

        $this->load->view($this->theme . 'pos/register_details', $this->data);

    }



    function today_sale()

    {

        if (!$this->Owner && !$this->Admin) {

            $this->session->set_flashdata('error', lang('access_denied'));

            $this->sma->md();

        }



        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

        $this->data['ccsales'] = $this->pos_model->getTodayCCSales();

        $this->data['cashsales'] = $this->pos_model->getTodayCashSales();

        $this->data['chsales'] = $this->pos_model->getTodayChSales();

        $this->data['pppsales'] = $this->pos_model->getTodayPPPSales();

        $this->data['stripesales'] = $this->pos_model->getTodayStripeSales();

        $this->data['totalsales'] = $this->pos_model->getTodaySales();

        $this->data['refunds'] = $this->pos_model->getTodayRefunds();

        $this->data['expenses'] = $this->pos_model->getTodayExpenses();

        $this->load->view($this->theme . 'pos/today_sale', $this->data);

    }



    function today_profit()

    {

        if (!$this->Owner) {

            $this->session->set_flashdata('error', lang('access_denied'));

            $this->sma->md();

        }



        $this->data['costing'] = $this->pos_model->getCosting();

        $this->data['expenses'] = $this->pos_model->getTodayExpenses();

        $this->load->view($this->theme . 'pos/today_profit', $this->data);

    }



    function check_pin()

    {

        $pin = $this->input->post('pw', true);

        if ($pin == $this->pos_pin) {

            echo json_encode(array('res' => 1));

        }

        echo json_encode(array('res' => 0));

    }



    function barcode($text = NULL, $bcs = 'code39', $height = 50)

    {

        return site_url('products/gen_barcode/' . $text . '/' . $bcs . '/' . $height);

    }



    function settings()

    {

        if (!$this->Owner) {

            $this->session->set_flashdata('error', lang('access_denied'));

            redirect("welcome");

        }

        $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('no_zero_required'));

        $this->form_validation->set_rules('pro_limit', $this->lang->line('pro_limit'), 'required|is_natural_no_zero');

        $this->form_validation->set_rules('pin_code', $this->lang->line('delete_code'));

        $this->form_validation->set_rules('category', $this->lang->line('default_category'), 'required|is_natural_no_zero');

        $this->form_validation->set_rules('customer', $this->lang->line('default_customer'), 'required|is_natural_no_zero');

        $this->form_validation->set_rules('biller', $this->lang->line('default_biller'), 'required|is_natural_no_zero');



        if ($this->form_validation->run() == true) {



            $data = array(

                'pro_limit' => $this->input->post('pro_limit'),

                'pin_code' => $this->input->post('pin_code') ? $this->input->post('pin_code') : NULL,

                'default_category' => $this->input->post('category'),

                'default_customer' => $this->input->post('customer'),

                'default_biller' => $this->input->post('biller'),
                
                'default_staff' => $this->input->post('staff'),

                'display_time' => $this->input->post('display_time'),

                'receipt_printer' => $this->input->post('receipt_printer'),

                'cash_drawer_codes' => $this->input->post('cash_drawer_codes'),

                'cf_title1' => $this->input->post('cf_title1'),

                'cf_title2' => $this->input->post('cf_title2'),

                'cf_value1' => $this->input->post('cf_value1'),

                'cf_value2' => $this->input->post('cf_value2'),

                'focus_add_item' => $this->input->post('focus_add_item'),

                'add_manual_product' => $this->input->post('add_manual_product'),

                'customer_selection' => $this->input->post('customer_selection'),

                'add_customer' => $this->input->post('add_customer'),

                'toggle_category_slider' => $this->input->post('toggle_category_slider'),

                'toggle_subcategory_slider' => $this->input->post('toggle_subcategory_slider'),

                'cancel_sale' => $this->input->post('cancel_sale'),

                'suspend_sale' => $this->input->post('suspend_sale'),

                'print_items_list' => $this->input->post('print_items_list'),

                'finalize_sale' => $this->input->post('finalize_sale'),

                'today_sale' => $this->input->post('today_sale'),

                'open_hold_bills' => $this->input->post('open_hold_bills'),

                'close_register' => $this->input->post('close_register'),

                'tooltips' => $this->input->post('tooltips'),

                'keyboard' => $this->input->post('keyboard'),

                'pos_printers' => $this->input->post('pos_printers'),

                'java_applet' => $this->input->post('enable_java_applet'),

                'product_button_color' => $this->input->post('product_button_color'),

                'paypal_pro' => $this->input->post('paypal_pro'),

                'stripe' => $this->input->post('stripe'),

                'rounding' => $this->input->post('rounding'),

            );

            $payment_config = array(

                'APIUsername' => $this->input->post('APIUsername'),

                'APIPassword' => $this->input->post('APIPassword'),

                'APISignature' => $this->input->post('APISignature'),

                'stripe_secret_key' => $this->input->post('stripe_secret_key'),

                'stripe_publishable_key' => $this->input->post('stripe_publishable_key'),

            );

        } elseif ($this->input->post('update_settings')) {

            $this->session->set_flashdata('error', validation_errors());

            redirect("pos/settings");

        }



        if ($this->form_validation->run() == true && $this->pos_model->updateSetting($data)) {

            if ($this->write_payments_config($payment_config)) {

                $this->session->set_flashdata('message', $this->lang->line('pos_setting_updated'));

                redirect("pos/settings");

            } else {

                $this->session->set_flashdata('error', $this->lang->line('pos_setting_updated_payment_failed'));

                redirect("pos/settings");

            }

        } else {



            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');



            $this->data['pos'] = $this->pos_model->getSetting();

            $this->data['categories'] = $this->site->getAllCategories();

            //$this->data['customer'] = $this->pos_model->getCompanyByID($this->pos_settings->default_customer);

            $this->data['billers'] = $this->pos_model->getAllBillerCompanies();
            $this->data['staffs'] = $this->site->getAllStaffs();

            $this->config->load('payment_gateways');

            $this->data['stripe_secret_key'] = $this->config->item('stripe_secret_key');

            $this->data['stripe_publishable_key'] = $this->config->item('stripe_publishable_key');

            $this->data['APIUsername'] = $this->config->item('APIUsername');

            $this->data['APIPassword'] = $this->config->item('APIPassword');

            $this->data['APISignature'] = $this->config->item('APISignature');

            $this->data['paypal_balance'] = $this->pos_settings->paypal_pro ? $this->paypal_balance() : NULL;

            $this->data['stripe_balance'] = $this->pos_settings->stripe ? $this->stripe_balance() : NULL;

            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('pos_settings')));

            $meta = array('page_title' => lang('pos_settings'), 'bc' => $bc);

            $this->page_construct('pos/settings', $meta, $this->data);

        }

    }



    public function write_payments_config($config)

    {

        if (!$this->Owner) {

            $this->session->set_flashdata('error', lang('access_denied'));

            redirect("welcome");

        }

        $file_contents = file_get_contents('./assets/config_dumps/payment_gateways.php');

        $output_path = APPPATH . 'config/payment_gateways.php';

        $this->load->library('parser');

        $parse_data = array(

            'APIUsername' => $config['APIUsername'],

            'APIPassword' => $config['APIPassword'],

            'APISignature' => $config['APISignature'],

            'stripe_secret_key' => $config['stripe_secret_key'],

            'stripe_publishable_key' => $config['stripe_publishable_key'],

        );

        $new_config = $this->parser->parse_string($file_contents, $parse_data);



        $handle = fopen($output_path, 'w+');

        @chmod($output_path, 0777);



        if (is_writable($output_path)) {

            if (fwrite($handle, $new_config)) {

                @chmod($output_path, 0644);

                return true;

            } else {

                return false;

            }

        } else {

            return false;

        }

    }



    function opened_bills($per_page = 0)

    {

        $this->load->library('pagination');



        //$this->table->set_heading('Id', 'The Title', 'The Content');

        if ($this->input->get('per_page')) {

            $per_page = $this->input->get('per_page');

        }



        $config['base_url'] = site_url('pos/opened_bills');

        $config['total_rows'] = $this->pos_model->bills_count();

        $config['per_page'] = 6;

        $config['num_links'] = 3;



        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';

        $config['full_tag_close'] = '</ul>';

        $config['first_tag_open'] = '<li>';

        $config['first_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li>';

        $config['last_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li>';

        $config['next_tag_close'] = '</li>';

        $config['prev_tag_open'] = '<li>';

        $config['prev_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li>';

        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a>';

        $config['cur_tag_close'] = '</a></li>';



        $this->pagination->initialize($config);

        $data['r'] = TRUE;

        $bills = $this->pos_model->fetch_bills($config['per_page'], $per_page);

        if (!empty($bills)) {

            $html = "";

            $html .= '<ul class="ob">';

            foreach ($bills as $bill) {

                $html .= '<li><button type="button" class="btn btn-info sus_sale" id="' . $bill->id . '">
                <p>' . $bill->suspend_note . '</p><strong>' . $bill->customer . '</strong>
                <br>Date: ' . $bill->date . '<br>Items: ' . $bill->count . '<br>
                Total: ' . $this->sma->formatMoney($bill->total) . '</button></li>';

            }

            $html .= '</ul>';

        } else {

            $html = "<h3>" . lang('no_opeded_bill') . "</h3><p>&nbsp;</p>";

            $data['r'] = FALSE;

        }



        $data['html'] = $html;



        $data['page'] = $this->pagination->create_links();

        $this->load->view($this->theme . 'pos/opened', $data);



    }





    function delete($id = NULL)

    {



        $this->sma->checkPermissions('index');



        if ($this->pos_model->deleteBill($id)) {

            echo lang("suspended_sale_deleted");

        }

    }



    function email_receipt($sale_id = NULL)

    {

        $this->sma->checkPermissions('index');

        if ($this->input->post('id')) {

            $sale_id = $this->input->post('id');

        } else {

            die();

        }

        if ($this->input->post('email')) {

            $to = $this->input->post('email');

        }

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

        $this->data['message'] = $this->session->flashdata('message');



        $this->data['rows'] = $this->pos_model->getAllInvoiceItems($sale_id);

        $inv = $this->pos_model->getInvoiceByID($sale_id);

        $biller_id = $inv->biller_id;

        $customer_id = $inv->customer_id;

        $this->data['biller'] = $this->pos_model->getCompanyByID($biller_id);

        $this->data['customer'] = $this->pos_model->getCompanyByID($customer_id);



        $this->data['payments'] = $this->pos_model->getInvoicePayments($sale_id);

        $this->data['pos'] = $this->pos_model->getSetting();

        $this->data['barcode'] = $this->barcode($inv->reference_no, 'code39', 30);

        $this->data['inv'] = $inv;

        $this->data['sid'] = $sale_id;

        $this->data['page_title'] = $this->lang->line("invoice");



        if (!$to) {

            $to = $this->data['customer']->email;

        }

        if (!$to) {

            echo json_encode(array('msg' => $this->lang->line("no_meil_provided")));

        }

        $receipt = $this->load->view($this->theme . 'pos/email_receipt', $this->data, TRUE);



        if ($this->sma->send_email($to, 'Receipt from ' . $this->data['biller']->company, $receipt)) {

            echo json_encode(array('msg' => $this->lang->line("email_sent")));

        } else {

            echo json_encode(array('msg' => $this->lang->line("email_failed")));

        }



    }



    public function active()

    {

        $this->session->set_userdata('last_activity', now());

        if ((now() - $this->session->userdata('last_activity')) <= 20) {

            die('Successfully updated the last activity.');

        } else {

            die('Failed to update last activity.');

        }

    }



    function add_payment($id = NULL)

    {

        $this->sma->checkPermissions('payments', true);

        $this->load->helper('security');

        if ($this->input->get('id')) {

            $id = $this->input->get('id');

        }



        $this->form_validation->set_rules('reference_no', lang("reference_no"), 'required');

        $this->form_validation->set_rules('amount-paid', lang("amount"), 'required');

        $this->form_validation->set_rules('paid_by', lang("paid_by"), 'required');

        //$this->form_validation->set_rules('note', lang("note"), 'xss_clean');

        $this->form_validation->set_rules('userfile', lang("attachment"), 'xss_clean');

        if ($this->form_validation->run() == true) {

            if ($this->Owner || $this->Admin) {

                $date = $this->sma->fld(trim($this->input->post('date')));

            } else {

                $date = date('Y-m-d H:i:s');

            }

            $payment = array(

                'date' => $date,

                'sale_id' => $this->input->post('sale_id'),

                'reference_no' => $this->input->post('reference_no'),

                'amount' => $this->input->post('amount-paid'),

                'paid_by' => $this->input->post('paid_by'),

                'cheque_no' => $this->input->post('cheque_no'),

                'cc_no' => $this->input->post('paid_by') == 'gift_card' ? $this->input->post('gift_card_no') : $this->input->post('pcc_no'),

                'cc_holder' => $this->input->post('pcc_holder'),

                'cc_month' => $this->input->post('pcc_month'),

                'cc_year' => $this->input->post('pcc_year'),

                'cc_type' => $this->input->post('pcc_type'),

                'cc_cvv2' => $this->input->post('pcc_ccv'),

                'note' => $this->input->post('note'),

                'created_by' => $this->session->userdata('user_id'),

                'type' => 'received'

            );



            if ($_FILES['userfile']['size'] > 0) {

                $this->load->library('upload');

                $config['upload_path'] = $this->digital_upload_path;

                $config['allowed_types'] = $this->digital_file_types;

                $config['max_size'] = $this->allowed_file_size;

                $config['overwrite'] = FALSE;

                $config['encrypt_name'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {

                    $error = $this->upload->display_errors();

                    $this->session->set_flashdata('error', $error);

                    redirect($_SERVER["HTTP_REFERER"]);

                }

                $photo = $this->upload->file_name;

                $payment['attachment'] = $photo;

            }



            //$this->sma->print_arrays($payment);



        } elseif ($this->input->post('add_payment')) {

            $this->session->set_flashdata('error', validation_errors());

            redirect($_SERVER["HTTP_REFERER"]);

        }





        if ($this->form_validation->run() == true && $msg = $this->pos_model->addPayment($payment)) {

            if ($msg) {

                if ($msg['status'] == 0) {

                    $error = '';

                    foreach ($msg as $m) {

                        $error .= '<br>' . (is_array($m) ? print_r($m, true) : $m);

                    }

                    $this->session->set_flashdata('error', '<pre>' . $error . '</pre>');

                } else {

                    $this->session->set_flashdata('message', lang("payment_added"));

                }

            } else {

                $this->session->set_flashdata('error', lang("payment_failed"));

            }

            redirect("pos/sales");

        } else {



            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));



            $sale = $this->pos_model->getInvoiceByID($id);

            $this->data['inv'] = $sale;

            $this->data['payment_ref'] = $this->site->getReference('pay');

            $this->data['modal_js'] = $this->site->modal_js();



            $this->load->view($this->theme . 'pos/add_payment', $this->data);

        }

    }



    function updates()

    {

        if (DEMO) {

            $this->session->set_flashdata('warning', lang('disabled_in_demo'));

            redirect($_SERVER["HTTP_REFERER"]);

        }

        if (!$this->Owner) {

            $this->session->set_flashdata('error', lang('access_denied'));

            redirect("welcome");

        }

        $this->form_validation->set_rules('purchase_code', lang("purchase_code"), 'required');

        $this->form_validation->set_rules('envato_username', lang("envato_username"), 'required');

        if ($this->form_validation->run() == true) {

            $this->db->update('pos_settings', array('purchase_code' => $this->input->post('purchase_code', TRUE), 'envato_username' => $this->input->post('envato_username', TRUE)), array('pos_id' => 1));

            redirect('pos/updates');

        } else {

            $fields = array('version' => $this->pos_settings->version, 'code' => $this->pos_settings->purchase_code, 'username' => $this->pos_settings->envato_username, 'site' => base_url());

            $this->load->helper('update');

            $protocol = is_https() ? 'https://' : 'http://';

            $updates = get_remote_contents($protocol.'tecdiary.com/api/v1/update/', $fields);

            $this->data['updates'] = json_decode($updates);

            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('updates')));

            $meta = array('page_title' => lang('updates'), 'bc' => $bc);

            $this->page_construct('pos/updates', $meta, $this->data);

        }

    }



    function install_update($file, $m_version, $version)

    {

        if (DEMO) {

            $this->session->set_flashdata('warning', lang('disabled_in_demo'));

            redirect($_SERVER["HTTP_REFERER"]);

        }

        if (!$this->Owner) {

            $this->session->set_flashdata('error', lang('access_denied'));

            redirect("welcome");

        }

        $this->load->helper('update');

        save_remote_file($file . '.zip');

        $this->sma->unzip('./files/updates/' . $file . '.zip');

        if ($m_version) {

            $this->load->library('migration');

            if (!$this->migration->latest()) {

                $this->session->set_flashdata('error', $this->migration->error_string());

                redirect("pos/updates");

            }

        }

        $this->db->update('pos_settings', array('version' => $version, 'update' => 0), array('pos_id' => 1));

        unlink('./files/updates/' . $file . '.zip');

        $this->session->set_flashdata('success', lang('update_done'));

        redirect("pos/updates");

    }

    function get_staff(){
        $staffs = $this->site->getAllStaffs();
        if($staffs){
            $option = "<option value=''>SELECT STAFF</option>";
            foreach ($staffs as $staff) {
                 $option.= "<option value='".$staff->id."'>".$staff->name."</option>";   
            }
            $data['option'] = $option;
            echo json_encode($data);

        }else
        {
            $option = "<option value=''>Select Staff</option>";
            $data['option'] = $option;
            echo json_encode($data);

        }
    }



}

