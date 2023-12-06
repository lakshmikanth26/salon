<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Dashboard_model extends CI_Model

{



    public function __construct()

    {

        parent::__construct();

    }



    function getSetting()
    {

        $q = $this->db->get('pos_settings');

        if ($q->num_rows() > 0) {

            return $q->row();

        }

        return FALSE;

    }






    public function getProductByCode($code)

    {



        $q = $this->db->get_where('products', array('code' => $code), 1);

        if ($q->num_rows() > 0) {

            return $q->row();

        }



        return FALSE;

    }



    public function getProductByName($name)

    {

        $q = $this->db->get_where('products', array('name' => $name), 1);

        if ($q->num_rows() > 0) {

            return $q->row();

        }



        return FALSE;

    }



    public function getAllBillerCompanies()

    {

        $q = $this->db->get_where('companies', array('group_name' => 'biller'));

        if ($q->num_rows() > 0) {

            foreach (($q->result()) as $row) {

                $data[] = $row;

            }



            return $data;

        }

    }



    public function getAllCustomerCompanies()

    {

        $q = $this->db->get_where('companies', array('group_name' => 'customer'));

        if ($q->num_rows() > 0) {

            foreach (($q->result()) as $row) {

                $data[] = $row;

            }



            return $data;

        }

    }



    public function getCompanyByID($id)

    {



        $q = $this->db->get_where('companies', array('id' => $id), 1);

        if ($q->num_rows() > 0) {

            return $q->row();

        }



        return FALSE;

    }
    public function getDiscountByID($id)

    {

        $q = $this->db->get_where('discounts', array('id' => $id), 1);

        if ($q->num_rows() > 0) {

            return $q->row();

        }

        return FALSE;

    }

    public function getStaffByID($id)
    {

        $q = $this->db->get_where('staffs', array('id' => $id), 1);

        if ($q->num_rows() > 0) {

            return $q->row();

        }



        return FALSE;

    }


    public function getAllProducts()

    {

        $q = $this->db->query('SELECT * FROM products ORDER BY id');

        if ($q->num_rows() > 0) {

            foreach (($q->result()) as $row) {

                $data[] = $row;

            }



            return $data;

        }

    }



    public function getProductByID($id)

    {



        $q = $this->db->get_where('products', array('id' => $id), 1);

        if ($q->num_rows() > 0) {

            return $q->row();

        }



        return FALSE;

    }



    public function getAllTaxRates()

    {

        $q = $this->db->get('tax_rates');

        if ($q->num_rows() > 0) {

            foreach (($q->result()) as $row) {

                $data[] = $row;

            }



            return $data;

        }

    }



    public function getTaxRateByID($id)

    {



        $q = $this->db->get_where('tax_rates', array('id' => $id), 1);

        if ($q->num_rows() > 0) {

            return $q->row();

        }



        return FALSE;

    }



    public function updateProductQuantity($product_id, $warehouse_id, $quantity)

    {



        if ($this->addQuantity($product_id, $warehouse_id, $quantity)) {

            return true;

        }



        return false;

    }



    public function addQuantity($product_id, $warehouse_id, $quantity)

    {

        if ($warehouse_quantity = $this->getProductQuantity($product_id, $warehouse_id)) {

            $new_quantity = $warehouse_quantity['quantity'] - $quantity;

            if ($this->updateQuantity($product_id, $warehouse_id, $new_quantity)) {

                $this->site->syncProductQty($product_id, $warehouse_id);

                return TRUE;

            }

        } else {

            if ($this->insertQuantity($product_id, $warehouse_id, -$quantity)) {

                $this->site->syncProductQty($product_id, $warehouse_id);

                return TRUE;

            }

        }

        return FALSE;

    }



    public function insertQuantity($product_id, $warehouse_id, $quantity)

    {

        if ($this->db->insert('warehouses_products', array('product_id' => $product_id, 'warehouse_id' => $warehouse_id, 'quantity' => $quantity))) {

            return true;

        }

        return false;

    }



    public function updateQuantity($product_id, $warehouse_id, $quantity)

    {

        if ($this->db->update('warehouses_products', array('quantity' => $quantity), array('product_id' => $product_id, 'warehouse_id' => $warehouse_id))) {

            return true;

        }

        return false;

    }



    public function getProductQuantity($product_id, $warehouse)

    {

        $q = $this->db->get_where('warehouses_products', array('product_id' => $product_id, 'warehouse_id' => $warehouse), 1);

        if ($q->num_rows() > 0) {

            return $q->row_array(); //$q->row();

        }

        return FALSE;

    }



    public function getItemByID($id)

    {

        $q = $this->db->get_where('sale_items', array('id' => $id), 1);

        if ($q->num_rows() > 0) {

            return $q->row();

        }

        return FALSE;

    }



    public function getAllSales()

    {

        $q = $this->db->get('sales');

        if ($q->num_rows() > 0) {

            foreach (($q->result()) as $row) {

                $data[] = $row;

            }

            return $data;

        }

        return FALSE;

    }



    public function sales_count()

    {

        return $this->db->count_all("sales");

    }



    public function fetch_sales($limit, $start)

    {

        $this->db->limit($limit, $start);

        $this->db->order_by("id", "desc");

        $query = $this->db->get("sales");



        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {

                $data[] = $row;

            }

            return $data;

        }

        return false;

    }



    public function getAllInvoiceItems($sale_id)

    {

        $this->db->select('sale_items.*, tax_rates.code as tax_code,tax_rates.type as tax_type, tax_rates.name as tax_name, tax_rates.rate as tax_rate, product_variants.name as variant')

            ->join('tax_rates', 'tax_rates.id=sale_items.tax_rate_id', 'left')

            ->join('product_variants', 'product_variants.id=sale_items.option_id', 'left')

            ->group_by('sale_items.id')

            ->order_by('id', 'asc');

        $q = $this->db->get_where('sale_items', array('sale_id' => $sale_id));

        if ($q->num_rows() > 0) {

            foreach (($q->result()) as $row) {

                $data[] = $row;

            }

            return $data;

        }

        return FALSE;

    }



    public function getSuspendedSaleItems($id)

    {

        $q = $this->db->get_where('suspended_items', array('suspend_id' => $id));

        if ($q->num_rows() > 0) {

            foreach (($q->result()) as $row) {

                $data[] = $row;

            }



            return $data;

        }

    }



    public function getSuspendedSales($user_id = NULL)

    {

        if (!$user_id) {

            $user_id = $this->session->userdata('user_id');

        }

        $q = $this->db->get_where('suspended_bills', array('created_by' => $user_id));

        if ($q->num_rows() > 0) {

            foreach (($q->result()) as $row) {

                $data[] = $row;

            }



            return $data;

        }

    }





    public function getOpenBillByID($id)

    {



        $q = $this->db->get_where('suspended_bills', array('id' => $id), 1);

        if ($q->num_rows() > 0) {

            return $q->row();

        }



        return FALSE;

    }


    public function getInvoicePayments($sale_id)

    {

        $q = $this->db->get_where("payments", array('sale_id' => $sale_id));

        if ($q->num_rows() > 0) {

            foreach (($q->result()) as $row) {

                $data[] = $row;

            }



            return $data;

        }



        return FALSE;

    }

    public function getInvoiceByID($id, $customer_id)
    {
        $q = $this->db->get_where('sales', array('id' => $id, 'customer_id'=>$customer_id), 1);

        if ($q->num_rows() > 0) {

            return $q->row();

        }



        return FALSE;

    }



    public function bills_count()

    {

        if (!$this->Owner && !$this->Admin) {

            $this->db->where('created_by', $this->session->userdata('user_id'));

        }

        return $this->db->count_all_results("suspended_bills");

    }



    public function fetch_bills($limit, $start)

    {

        if (!$this->Owner && !$this->Admin) {

            $this->db->where('created_by', $this->session->userdata('user_id'));

        }

        $this->db->limit($limit, $start);

        $this->db->order_by("id", "asc");

        $query = $this->db->get("suspended_bills");



        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {

                $data[] = $row;

            }

            return $data;

        }

        return false;

    }



    public function getTodaySales()

    {

        $date = date('Y-m-d 00:00:00');

        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)

            ->join('sales', 'sales.id=payments.sale_id', 'left')

            ->where('type', 'received')->where('payments.date >', $date);



        $q = $this->db->get('payments');

        if ($q->num_rows() > 0) {

            return $q->row();

        }

        return false;

    }



    public function getCosting()

    {

        $date = date('Y-m-d');

        $this->db->select('SUM( COALESCE( purchase_unit_cost, 0 ) * quantity ) AS cost, SUM( COALESCE( sale_unit_price, 0 ) * quantity ) AS sales, SUM( COALESCE( purchase_net_unit_cost, 0 ) * quantity ) AS net_cost, SUM( COALESCE( sale_net_unit_price, 0 ) * quantity ) AS net_sales', FALSE)

            ->where('date', $date);



        $q = $this->db->get('costing');

        if ($q->num_rows() > 0) {

            return $q->row();

        }

        return false;

    }



    public function getTodayCCSales()

    {

        $date = date('Y-m-d 00:00:00');

        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_cc_slips, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)

            ->join('sales', 'sales.id=payments.sale_id', 'left')

            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'CC');



        $q = $this->db->get('payments');

        if ($q->num_rows() > 0) {

            return $q->row();

        }

        return false;

    }



    public function getTodayCashSales()

    {

        $date = date('Y-m-d 00:00:00');

        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)

            ->join('sales', 'sales.id=payments.sale_id', 'left')

            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'cash');



        $q = $this->db->get('payments');

        if ($q->num_rows() > 0) {

            return $q->row();

        }

        return false;

    }



    public function getTodayRefunds()

    {

        $date = date('Y-m-d 00:00:00');

        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS returned', FALSE)

            ->join('return_sales', 'return_sales.id=payments.return_id', 'left')

            ->where('type', 'returned')->where('payments.date >', $date);



        $q = $this->db->get('payments');

        if ($q->num_rows() > 0) {

            return $q->row();

        }

        return false;

    }

    public function getStaffBysaleID($id)

    {

        $this->db->select($this->db->dbprefix('sale_staffs') . '.staff_id as staff_id, ' . $this->db->dbprefix('sale_staffs') . '.product_id as product_id,' . $this->db->dbprefix('sale_staffs') . '.staff_name as staff_name,' . $this->db->dbprefix('sale_staffs') . '.sale_item_id as sale_item_id')

            ->join('sales', 'sales.id=sale_staffs.sale_id', 'left');

        $q = $this->db->get_where('sale_staffs', array('sale_staffs.sale_id' => $id));

        if ($q->num_rows() > 0) {

        foreach (($q->result()) as $row) {

                $data[] = $row;

            }

            return $data;

        }    

    }

    function getdiscount($id)
    {
        $this->db->where('id', $id);
        $q = $this->db->get('discounts');

        if ($q->num_rows() > 0) {

            return $q->row();

        }

        return FALSE;

    }

    function getCoupon($coupon_id, $customer_id)
    {
        $this->db->where('coupon_id', $coupon_id);
        $this->db->where('customer_id', $customer_id);
        $this->db->order_by('balance','desc');
        $q = $this->db->get('gift_cards');

        if ($q->num_rows() > 0) {

            return $q->row();

        }

        return FALSE;

    }

    public function get_appointments($start_format, $end_format, $customer_id)

    {   

       $query = $this

                ->db

                ->select('a.id as id, c.name as name, c.email as email, c.phone as phone,a.booked_date, a.booked_time,a.booked_to_time, a.staff_id, a.status as status, a.description as description, a.customer_id as customer_id, a.reschedule as reschedule, s.name as staffname,s.cf6 as staffcolor, a.warehouse_id as warehouse_id, a.service_id as service_id, w.name as location, ws.name as service')

                ->from('appointment_details as a')

                ->join('staffs as s', 's.id = a.staff_id', 'INNER')

                ->join('warehouses as w', 'w.id = a.warehouse_id', 'INNER')

                ->join('website_services as ws', 'ws.id = a.service_id', 'INNER')

                ->join('companies as c', 'c.id = a.customer_id', 'INNER')
                
                ->where('a.customer_id', $customer_id)
                ->group_start()
                ->where("CONCAT(a.booked_date, ' ', a.booked_time) >= ".$start_format."", NULL, FALSE)

                ->or_where("CONCAT(a.booked_date, ' ', a.booked_to_time) <= ".$end_format."", NULL, FALSE)
                ->group_end();
                
                $query = $this->db->get();

                //print_r($this->db->last_query()); die();

                return $query;

    }








}

