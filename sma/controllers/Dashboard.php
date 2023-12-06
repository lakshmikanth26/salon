<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_UserController
{

    function __construct()
    {
        parent::__construct();

        if (!$this->user_loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            redirect('user/login');
        }
        $this->load->model('dashboard_model');

        $this->load->library('form_validation');
        $this->load->model('db_model');
        $this->wp_sitedb = $this->load->database('wp_site',TRUE);

    }

    public function index()
    {
        if ($this->Settings->version == '2.3') {
            $this->session->set_flashdata('warning', 'Please complete your update by synchronizing your database.');
            redirect('sync');
        }

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $lmsdate = date('Y-m-d', strtotime('first day of last month')) . ' 00:00:00';
        $lmedate = date('Y-m-d', strtotime('last day of last month')) . ' 23:59:59';
        $this->data['lmbs'] = $this->db_model->getBestSeller($lmsdate, $lmedate);
        $bc = array(array('link' => '#', 'page' => lang('dashboard')));
        $meta = array('page_title' => lang('dashboard'), 'bc' => $bc);
        $this->page_construct('dashboard', $meta, $this->data);

    }

    function recent_bills()
    {
    
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
    
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('recent_bills')));
        $meta = array('page_title' => lang('recent_bills'), 'bc' => $bc);
        $this->page_construct('recent_bills/index', $meta, $this->data);
    }

    function getRecentBills()
    {
        $detail_link = anchor('dashboard/recent_bill_view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('bill_details'));
        
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li>' . $detail_link . '</li>
        </ul>
        </div></div>';
        //$action = '<div class="text-center">' . $detail_link . ' ' . $edit_link . ' ' . $email_link . ' ' . $delete_link . '</div>';

        $this->load->library('datatables');
            $this->datatables
                ->select("id, date, reference_no, grand_total, paid, (grand_total-paid) as balance, payment_status")
                ->from('sales');

        $this->datatables->where('customer_id', $this->session->userdata('user'));
        
        $this->datatables->add_column("Actions", $action, "id");
        echo $this->datatables->generate();
    }

    function recent_bill_view($sale_id = NULL, $modal = NULL)

    {

        if ($this->input->get('id')) {

            $sale_id = $this->input->get('id');

        }

        $this->load->helper('text');

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

        $this->data['message'] = $this->session->flashdata('message');

        
        $inv = $this->dashboard_model->getInvoiceByID($sale_id, $this->session->userdata('user'));

        $this->data['rows'] = $this->dashboard_model->getAllInvoiceItems($sale_id);

        $biller_id = $inv->biller_id;

        $customer_id = $inv->customer_id;
        
        $staff_id = $inv->staff_id;

        $discount_id = $inv->discount_id;

        $this->data['biller'] = $this->dashboard_model->getCompanyByID($biller_id);
        
        $this->data['staffs'] = $this->dashboard_model->getStaffBysaleID($sale_id);

        $this->data['customer'] = $this->dashboard_model->getCompanyByID($customer_id);
        
        if($discount_id != NULL){
        $this->data['discount'] = $this->dashboard_model->getDiscountByID($discount_id);
        
        }
        $coupon_id = $inv->coupon_id;
        if($coupon_id != NULL){
        $this->data['coupon'] = $this->dashboard_model->getCouponByID($coupon_id);
        
        }
            

        $this->data['customer_group'] = $this->site->getCustomerGroupByID($this->data['customer']->customer_group_id);


        $this->data['payments'] = $this->dashboard_model->getInvoicePayments($inv->id);

        $this->data['pos_settings'] = $this->dashboard_model->getSetting();

        $this->data['barcode'] = $this->barcode($inv->reference_no, 'code39', 30);

        $this->data['inv'] = $inv;

        $this->data['sid'] = $sale_id;

        $this->data['modal'] = $modal;

        $this->data['page_title'] = $this->lang->line("invoice");

        if($modal == NULL){
            $this->load->view($this->theme . 'recent_bills/view_print', $this->data);
  
        }else
        {
            $this->load->view($this->theme . 'recent_bills/view', $this->data);
    
        }

        
    }

    function barcode($text = NULL, $bcs = 'code39', $height = 50)

    {

        return site_url('products/gen_barcode/' . $text . '/' . $bcs . '/' . $height);

    }


    public function appointments()
    {
        if ($this->Settings->version == '2.3') {
            $this->session->set_flashdata('warning', 'Please complete your update by synchronizing your database.');
            redirect('sync');
        }

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $lmsdate = date('Y-m-d', strtotime('first day of last month')) . ' 00:00:00';
        $lmedate = date('Y-m-d', strtotime('last day of last month')) . ' 23:59:59';
        $this->data['lmbs'] = $this->db_model->getBestSeller($lmsdate, $lmedate);
        $bc = array(array('link' => '#', 'page' => lang('dashboard')));
        $meta = array('page_title' => lang('dashboard'), 'bc' => $bc);
        $this->page_construct('appointment/index', $meta, $this->data);

    }

    //appointments
    public function get_appointments()
    {

     // Our Start and End Dates

     $start = $this->input->get("start");

     $end = $this->input->get("end");



     $start_format = date('Y-m-d', strtotime($start));

     $end_format = date('Y-m-d', strtotime($end));



     $appointments = $this->dashboard_model->get_appointments($start_format, $end_format, $this->session->userdata('user'));



     $data_appointments = array();

     $data_color = array("#439b6e", "#FFA07A", "#cc6600", "#465933", "#008080", "#000080", "#800080", "red", "#cc6600", "#E9D9CF", "#7ec0ee", "#c39797","#cf1b3c",  "#008b8b", "#147a00", "#465933");

     $i = 0;
     foreach($appointments->result() as $r) {

         
         if($r->reschedule == 1){
            $className = "qt-fc-event-primary";
         }else
         {   
             if($r->status == 1){

                $className = "qt-fc-event-success";

             }else if($r->status == 2){

                $className = "qt-fc-event-danger";

             }else

             {

                $className = "qt-fc-event-warning";

             }
         }

         $start_date = date('Y-m-d', strtotime($r->booked_date));    

         $end_date = date('Y-m-d', strtotime($r->booked_date));

         $start_time = date('H:i:s', strtotime($r->booked_time));    

         $end_time = date('H:i:s', strtotime($r->booked_to_time));



         $start = $start_date."T".$start_time;

         $end = $end_date."T".$end_time;

         

         $data_appointments[] = array(

             "id" => $r->id,

             "customer_id" => $r->customer_id,

             "title" => $r->name." (".$r->staffname.")",

             "name" => $r->name,

             "end" => $end,

             "start" => $start,

             "className" => $className,

             "allDay" => "false",

             "email" => $r->email,

             "phone" => $r->phone,

             "staff_id" => $r->staff_id,
        
             "staff" => $r->staffname,
             
             "service_id" => $r->service_id,
        
             "service" => $r->service,

             "location_id" => $r->warehouse_id,
        
             "location" => $r->location,
             
             "status" => $r->status,
             
             "reschedule" => $r->reschedule,

             "description" => $r->description,

             "color" => $r->staffcolor
            

         );
     }



     echo json_encode($data_appointments);

     exit();

    }

    public function get_staffs()
    {
        $event_start_date = $this->input->get('event_start_date');
        $query = $this->site->getAllStaffsAvailable($event_start_date);
        if($query['response'] == 200){
        echo '<option value="0">--- Select Staffs---- </option>';
        foreach ($query['data'] as $row) {
            echo "<option value='" . set_value('service',$row->id) . "'>" . $row->name . "</option>";
        }}
        else
        {
        echo '<option value="">--- No Staffs Available---- </option>';
        }
    }
    
    public function get_services()
    {
        $event_start_date = $this->input->get('event_start_date');
        $query = $this->site->getAllWebsiteServices();
        if($query){
        echo '<option value="0">--- Select Services---- </option>';
        foreach ($query as $row) {
            echo "<option value='" . set_value('service',$row->id) . "'>" . $row->name . "</option>";
        }}
        else
        {
        echo '<option value="">--- No Service Available---- </option>';
        }
    }
    
    public function get_warehouses()
    {
        $warehouses = $this->site->getAllWarehouses();
        if($warehouses){
            echo '<option value="0">--- Select Location---- </option>';
            foreach ($warehouses as $row) {
                echo "<option value='" . set_value('location',$row->id) . "'>" . $row->name . "</option>";
            }
        }
        else
        {
        echo '<option value="">--- No Location Available---- </option>';
        die();
        }
    
        
    }
        
    function wallets(){
        $bc = array(array('link' => '#', 'page' => lang('wallet')));
        $meta = array('page_title' => lang('wallet'), 'bc' => $bc);
        $this->page_construct('wallet', $meta, $this->data);
    }   
    function promotions()
    {
        $this->load->view($this->theme . 'promotions', $this->data);
    }

    function information()

    {
        $this->data['modal_js'] = $this->site->modal_js();
        echo $email = $this->session->userdata('email');

        
        $this->load->view($this->theme . 'info', $this->data);

    }



    function image_upload()
    {
        if (DEMO) {
            $error = array('error' => $this->lang->line('disabled_in_demo'));
            echo json_encode($error);
            exit;
        }
        $this->security->csrf_verify();
        if (isset($_FILES['file'])) {
            $this->load->library('upload');
            $config['upload_path'] = 'assets/uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '500';
            $config['max_width'] = $this->Settings->iwidth;
            $config['max_height'] = $this->Settings->iheight;
            $config['encrypt_name'] = TRUE;
            $config['overwrite'] = FALSE;
            $config['max_filename'] = 25;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('file')) {
                $error = $this->upload->display_errors();
                $error = array('error' => $error);
                echo json_encode($error);
                exit;
            }
            $photo = $this->upload->file_name;
            $array = array(
                'filelink' => base_url() . 'assets/uploads/images/' . $photo
            );
            echo stripslashes(json_encode($array));
            exit;

        } else {
            $error = array('error' => 'No file selected to upload!');
            echo json_encode($error);
            exit;
        }
    }

    function set_data($ud, $value)
    {
        $this->session->set_userdata($ud, $value);
        echo true;
    }

    function hideNotification($id = NULL)
    {
        $this->session->set_userdata('hidden' . $id, 1);
        echo true;
    }

    function language($lang = false)
    {
        if ($this->input->get('lang')) {
            $lang = $this->input->get('lang');
        }
        //$this->load->helper('cookie');
        $folder = 'sma/language/';
        $languagefiles = scandir($folder);
        if (in_array($lang, $languagefiles)) {
            $cookie = array(
                'name' => 'language',
                'value' => $lang,
                'expire' => '31536000',
                'prefix' => 'sma_',
                'secure' => false
            );

            $this->input->set_cookie($cookie);
        }
        redirect($_SERVER["HTTP_REFERER"]);
    }

    function download($file)
    {
        $this->load->helper('download');
        force_download('./files/'.$file, NULL);
        exit();
    }

}
