<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Staffs extends MY_Controller
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
        $this->lang->load('staffs', $this->Settings->language);
        $this->load->library('form_validation');
        $this->load->model('staffs_model');
    }

    function index($action = NULL)
    {
        $this->sma->checkPermissions();
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('staffs')));
        $meta = array('page_title' => lang('staffs'), 'bc' => $bc);
        $this->page_construct('staffs/index', $meta, $this->data);
    }

    function getStaffs()
    {
        $this->sma->checkPermissions('index');
        $user_id = $this->session->userdata('user_id');
        $this->load->library('datatables');
        $this->datatables
            ->select("id, company, name, email, phone, city, country")
            ->from("staffs")
            ->where("user_id", $user_id)
            ->add_column("Actions", "<center><a class=\"tip\" title='" . $this->lang->line("unavailable_dates") . "' href='" . site_url('staffs/unavailable_dates/$1') . "' ><i class=\"fa fa-calendar\"></i></a> <a class=\"tip\" title='" . $this->lang->line("edit_staff") . "' href='" . site_url('staffs/edit/$1') . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a>  <a href='#' class='tip po' title='<b>" . $this->lang->line("delete_staff") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('staffs/delete/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id");
        //->unset_column('id');
        echo $this->datatables->generate();
    }

    //appointments
    public function get_appointments()
    {

     // Our Start and End Dates

     $start = $this->input->get("start");

     $end = $this->input->get("end");



     $start_format = date('Y-m-d', strtotime($start));

     $end_format = date('Y-m-d', strtotime($end));



     $appointments = $this->staffs_model->get_appointments($start_format, $end_format);



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


    function add()
    {
        $this->sma->checkPermissions(false, true);

        $this->form_validation->set_rules('email', $this->lang->line("email_address"), 'is_unique[companies.email]');

        if ($this->form_validation->run('companies/add') == true) {

            $data = array('name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'user_id' => $this->session->userdata('user_id'),
                'group_id' => $this->session->userdata('group_id'),
                'warehouse_id' => 4,
                'company' => $this->input->post('company'),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'postal_code' => $this->input->post('postal_code'),
                'country' => $this->input->post('country'),
                'phone' => $this->input->post('phone'),
                'cf1' => $this->input->post('cf1'),
                'cf2' => $this->input->post('cf2'),
                'cf3' => $this->input->post('cf3'),
                'cf4' => $this->input->post('cf4'),
                'cf5' => $this->input->post('cf5'),
                'cf6' => $this->input->post('cf6'),
            );
        } elseif ($this->input->post('add_staff')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('staffs');
        }

        if ($this->form_validation->run() == true && $sid = $this->staffs_model->addStaff($data)) {
            $this->session->set_flashdata('message', $this->lang->line("staff_added"));
            $ref = isset($_SERVER["HTTP_REFERER"]) ? explode('?', $_SERVER["HTTP_REFERER"]) : NULL;
            redirect($ref[0] . '?staff=' . $sid);
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['modal_js'] = $this->site->modal_js();
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            
            $this->load->view($this->theme . 'staffs/add', $this->data);
        }
    }

    function edit($id = NULL)
    {
        $this->sma->checkPermissions(false, true);

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        $staff_details = $this->staffs_model->getStaffByID($id);
        if ($this->input->post('email') != $staff_details->email) {
            $this->form_validation->set_rules('code', lang("email_address"), 'is_unique[companies.email]');
        }

        if ($this->form_validation->run('companies/add') == true) {
            $data = array('name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'user_id' => $this->session->userdata('user_id'),
                'group_id' => $this->session->userdata('group_id'),
                'warehouse_id' => 4,
                'company' => $this->input->post('company'),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'postal_code' => $this->input->post('postal_code'),
                'country' => $this->input->post('country'),
                'phone' => $this->input->post('phone'),
                'cf1' => $this->input->post('cf1'),
                'cf2' => $this->input->post('cf2'),
                'cf3' => $this->input->post('cf3'),
                'cf4' => $this->input->post('cf4'),
                'cf5' => $this->input->post('cf5'),
                'cf6' => $this->input->post('cf6'),
            );
        } elseif ($this->input->post('edit_staff')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }

        if ($this->form_validation->run() == true && $this->staffs_model->updateStaff($id, $data)) {
            $this->session->set_flashdata('message', $this->lang->line("staff_updated"));
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $this->data['staff'] = $staff_details;
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'staffs/edit', $this->data);
        }
    }

    function unavailable_dates($id = NULL)
    {
        $this->sma->checkPermissions(false, true);

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        $staff_details = $this->staffs_model->getStaffByID($id);
        $this->data['staff'] = $staff_details;
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('staffs')));
        $meta = array('page_title' => lang('staffs'), 'bc' => $bc);
        $this->page_construct('staffs/unavailable_dates', $meta, $this->data);
    
    }

    public function get_staffs_unavailable_dates($id)
    {
        $keys = isset($_GET['keys'])?$_GET['keys']:array();
        if (!is_array($keys)){
            $keys = array($keys);
        }
        $keys = array_filter($_GET['keys']);
        # RESULT
        $unavailable = array();
        if (!empty($keys)){

            $sql = "SELECT * FROM sma_staffs_unavailable_dates WHERE staff_id = '".$id."' and DATE_FORMAT(unavailable_date, '%Y-%m') IN ('".implode("', '", $keys)."')";
            $query = $this->db->query($sql);
            $data = $query->result_array();
            if(!empty($data)){
            foreach($data as $row) {
                $unavailable[] = $row['unavailable_date'];
            }
            }
        }
        echo(json_encode($unavailable));
        exit();

    }

    public function update_unavailable_dates()
    {
        
        $unavailable = array();

        $id = $this->input->post('id');
        $selected_date = $this->input->post('selected_date');
        $sel = date('Y-m-d', strtotime($selected_date));
        $check = $this->db->query("Select * from sma_staffs_unavailable_dates where unavailable_date = '".$sel."' and staff_id ='".$id."'")->num_rows();
        if($check == 0){
            $data = array('unavailable_date' => $sel, 'staff_id' => $id);
            $this->db->insert('staffs_unavailable_dates', $data);
        }else
        {
            $this->db->where('unavailable_date',$sel);
            $this->db->where('staff_id',$id);
            $this->db->delete('staffs_unavailable_dates');
            
        }
        $unavailable[] = $sel;
        echo(json_encode($unavailable));
        exit();

    }

    
    
    function import_csv()
    {
        $this->sma->checkPermissions();
        $this->load->helper('security');
        $this->form_validation->set_rules('csv_file', $this->lang->line("upload_file"), 'xss_clean');

        if ($this->form_validation->run() == true) {

            if (DEMO) {
                $this->session->set_flashdata('warning', $this->lang->line("disabled_in_demo"));
                redirect($_SERVER["HTTP_REFERER"]);
            }

            if (isset($_FILES["csv_file"])) /* if($_FILES['userfile']['size'] > 0) */ {

                $this->load->library('upload');

                $config['upload_path'] = 'assets/uploads/csv/';
                $config['allowed_types'] = 'csv';
                $config['max_size'] = '2000';
                $config['overwrite'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('csv_file')) {

                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("staffs");
                }

                $csv = $this->upload->file_name;

                $arrResult = array();
                $handle = fopen("assets/uploads/csv/" . $csv, "r");
                if ($handle) {
                    while (($row = fgetcsv($handle, 5001, ",")) !== FALSE) {
                        $arrResult[] = $row;
                    }
                    fclose($handle);
                }
                $titles = array_shift($arrResult);

                $keys = array('warehouse','company', 'name', 'email', 'phone', 'address', 'city', 'state', 'postal_code', 'country', 'cf1', 'cf2', 'cf3', 'cf4', 'cf5', 'cf6');

                $final = array();

                foreach ($arrResult as $key => $value) {
                    $final[] = array_combine($keys, $value);
                }
                $rw = 2;
                foreach ($final as $csv) {
                    if ($this->staffs_model->getStaffByEmail($csv['email'])) {
                        $this->session->set_flashdata('error', $this->lang->line("check_staff_email") . " (" . $csv['email'] . "). " . $this->lang->line("staff_already_exist") . " (" . $this->lang->line("line_no") . " " . $rw . ")");
                        redirect("staffs");
                    }
                    $rw++;
                }
                foreach ($final as $record) {
                    $record['user_id'] = $this->session->userdata('user_id');
                    $data[] = $record;
                }
                //$this->sma->print_arrays($data);
            }

        } elseif ($this->input->post('import')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('staffs');
        }

        if ($this->form_validation->run() == true && !empty($data)) {
            if ($this->staffs_model->addStaffs($data)) {
                $this->session->set_flashdata('message', $this->lang->line("staffs_added"));
                redirect('staffs');
            }
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'staffs/import', $this->data);
        }
    }

    function delete($id = NULL)
    {
        $this->sma->checkPermissions(NULL, TRUE);

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->staffs_model->deleteStaff($id)) {
            echo $this->lang->line("staff_deleted");
        } else {
            $this->session->set_flashdata('warning', lang('staff_x_deleted_have_purchases'));
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 0);</script>");
        }
    }

    
    function getStaff($id = NULL)
    {
        $this->sma->checkPermissions('index');
        $row = $this->staffs_model->getStaffByID($id);
        echo json_encode(array(array('id' => $row->id, 'text' => $row->company)));
    }

    function staff_actions()
    {
        if (!$this->Owner) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    $error = false;
                    foreach ($_POST['val'] as $id) {
                        if (!$this->companies_model->deleteStaff($id)) {
                            $error = true;
                        }
                    }
                    if ($error) {
                        $this->session->set_flashdata('warning', lang('staffs_x_deleted_have_purchases'));
                    } else {
                        $this->session->set_flashdata('message', $this->lang->line("staffs_deleted"));
                    }
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('customer'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('company'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('name'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('email'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('phone'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('address'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('city'));
                    $this->excel->getActiveSheet()->SetCellValue('G1', lang('state'));
                    $this->excel->getActiveSheet()->SetCellValue('H1', lang('postal_code'));
                    $this->excel->getActiveSheet()->SetCellValue('I1', lang('country'));
                    $this->excel->getActiveSheet()->SetCellValue('J1', lang('stcf1'));
                    $this->excel->getActiveSheet()->SetCellValue('K1', lang('stcf2'));
                    $this->excel->getActiveSheet()->SetCellValue('L1', lang('stcf3'));
                    $this->excel->getActiveSheet()->SetCellValue('M1', lang('stcf4'));
                    $this->excel->getActiveSheet()->SetCellValue('N1', lang('stcf5'));
                    $this->excel->getActiveSheet()->SetCellValue('O1', lang('stcf6'));
                    $this->excel->getActiveSheet()->SetCellValue('P1', lang('warehouse'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $customer = $this->site->getStaffID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $customer->company);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $customer->name);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $customer->email);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $customer->phone);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $customer->address);
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $customer->city);
                        $this->excel->getActiveSheet()->SetCellValue('G' . $row, $customer->state);
                        $this->excel->getActiveSheet()->SetCellValue('H' . $row, $customer->postal_code);
                        $this->excel->getActiveSheet()->SetCellValue('I' . $row, $customer->country);
                        $this->excel->getActiveSheet()->SetCellValue('J' . $row, $customer->cf1);
                        $this->excel->getActiveSheet()->SetCellValue('K' . $row, $customer->cf2);
                        $this->excel->getActiveSheet()->SetCellValue('L' . $row, $customer->cf3);
                        $this->excel->getActiveSheet()->SetCellValue('M' . $row, $customer->cf4);
                        $this->excel->getActiveSheet()->SetCellValue('N' . $row, $customer->cf5);
                        $this->excel->getActiveSheet()->SetCellValue('O' . $row, $customer->cf6);
                        $this->excel->getActiveSheet()->SetCellValue('P' . $row, $customer->warehouse_name);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'staffs_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line("no_staff_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
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
        if ($this->Owner || $this->Admin) {
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
        }else{
            $warehouses = $this->site->getWarehouseByID($this->session->userdata('warehouse_id'));
            if($warehouses){
                echo '<option value="0">--- Select Location---- </option>';
                echo "<option value='" . set_value('location',$warehouses->id) . "'>" . $warehouses->name . "</option>";
                
            }
            else
            {
            echo '<option value="">--- No Location Available---- </option>';
            die();
            }
        }

        
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
    
}
