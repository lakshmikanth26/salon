<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->wp_sitedb = $this->load->database('wp_site',TRUE);

    }

    function index($m = NULL)
    {
        $this->data['title'] = lang('login');
        $this->data['message'] = '';
        $this->data['error'] = '';
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['staffs'] = $this->site->getAllStaffs();
        $this->data['services'] = $this->site->getAllWebsiteServices();


        $this->load->view($this->theme . 'frontend_appointment/index', $this->data);
    }

    public function remove_duplicate_customers()
    {
        $query = $this->db->query("Select phone, count(*) c from sma_companies where group_id = '3' group by phone having c>1")->result();
        foreach($query as $row):
            $query1 = $this->db->query("Select * from sma_companies where group_id = '3' and phone = '".$row->phone."' order by customer_group_id desc")->result();
            $i = 1;
            foreach ($query1 as $row1) {
                if(count($query1) == $i){
                    $last_customer_id = $row1->id;   
                }
                if($i == 1){
                    $first_customer_id = $row1->id;   
                }
                $update_data = array('customer_id'=>$first_customer_id);
                $this->db->where('customer_id', $row1->id);
                $this->db->update('sales', $update_data);
                
                echo $row1->phone." - ". $row1->id." - ". $row1->customer_group_name." - ".$row1->name."<br>";
                
                $i++;
            }

                    $this->db->where('phone', $row->phone);
                    $this->db->where('id !=', $first_customer_id);
                    $this->db->where('group_id', 3);
                    $this->db->delete('companies');
                    
                    
                    echo $first_customer_id."<br>";
                    echo $last_customer_id."<br>";
                    
        endforeach;

    }

    public function get_staffs()
    {
        $location = $_GET['location'];
        $query = $this->site->get_staff($location);

        echo '<option value="">--- Select Staff---- </option>';
        if(!empty($query['response'] == 200)){
            foreach ($query['data'] as $row) {
                echo "<option value='" . set_value('city',$row->id) . "'>" . $row->name . "</option>";
            }
        }
    }

    public function get_staffs_unavailable_dates($id)
    {
        $unavailable = array();
        if (!empty($id)){

            $sql = "SELECT * FROM sma_staffs_unavailable_dates WHERE staff_id = '".$id."'";
            $query = $this->db->query($sql);
            $data = $query->result_array();
            if(!empty($data)){
            foreach($data as $row) {
                $unavailable[] = date('d-m-Y', strtotime($row['unavailable_date']));
            }
            }
        }
        echo(json_encode($unavailable));
        exit();

    }

    public function get_slots(){

                    $id = $this->input->get('id');  
                    $select_date = date('Y-m-d', strtotime($this->input->get('selected')));  
                    $response['staff'] = $this->site->getStaffByID($id);
                    
                    $s1starttime = date('H:i:s', strtotime($response['staff']->cf1));
                    $s1endtime = date('H:i:s', strtotime($response['staff']->cf2));

                    $time_slot = 15;    
                    echo '<option value="0">--- Select Slots---- </option>';
            
                    for($i = strtotime($s1starttime); $i<= strtotime($s1endtime); $i = $i + $time_slot * 60) {
                        $slots[] = date("H:i:s", $i);  
                    }           
                    
                    
                    foreach($slots as $j => $check_start) {         

                        // Loop through the $slots array and create the booking table
                        if((date('Y-m-d') == $select_date) && ($check_start < date("H:i:s",strtotime("-10 minutes")))) {

                            // Remove before unbooked slots from the $slots array
                            $slots = array_diff($slots, array($check_start));

                        } // Close if
                    }   

                    foreach($slots as $i => $start) {   

                        $stmt = $this->db->query("SELECT booked_date, booked_time FROM sma_appointment_details WHERE booked_date LIKE  '".$select_date."' and booked_time = '".$start."'  and staff_id = '".$id."'  ");
                        $stmt_res = $stmt->result_array();  


                        if($stmt->num_rows() > 0) {

                        // Remove any booked slots from the $slots array

                        // Calculate finish time
                        $finish_time = strtotime($start) + $time_slot * 60; 

                        echo "<option value='' disabled>" . date("h:i A", strtotime($start)) ." (Booked)</option>";
            
                        
                        } // Close if
                        else
                        {

                            // Calculate finish time
                            $finish_time = strtotime($start) + $time_slot * 60; 
                            $booked_slot = date("h:i A", strtotime($start)).'-'.date("h:i A", $finish_time);
                            echo "<option value='" . set_value('availableslots',$booked_slot) . "'>" . date("h:i A", strtotime($start)) ."</option>";
            
                            
                        }
                    }
    }

    public function get_customer_details()
    {
        $phone = $this->input->get('phone');
            $query = $this->site->getCompanyByMobileNo($phone);
            if($query){
                $data['name'] = $query->name;
                $data['email'] = $query->email;
                echo json_encode($data);
            }else
            {
                $data['name'] = "";
                $data['email'] = "";
                echo json_encode($data);
            }    
        
    }

    function add_appointments(){


        /* Values received via ajax */

        
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $staff_id = $_POST['staff'];
        $warehouse_id = $_POST['location'];
        $service_id = $_POST['service'];
        $description = $_POST['description'];
        
        $query = $this->site->getCompanyByMobileNo($phone);
            if($query){
                $p_data['email'] = $_POST['email'];
                $p_data['name'] = $_POST['name'];
                $this->db->where('id', $query->id);
                $this->db->update('companies', $p_data);
                $customer_id = $query->id;

            }else
            {
                $p_data['phone'] = $_POST['phone'];
                $p_data['email'] = $_POST['email'];
                $p_data['name'] = $_POST['name'];
                $p_data['group_id'] = 3;
                $p_data['group_name'] = 'customer';
                $p_data['customer_group_id'] = 4;
                $p_data['customer_group_name'] = 'General';
                $p_data['logo'] = 'logo.png';
                
                
                $this->db->insert('companies', $p_data);
                $customer_id = $this->db->insert_id();


            }

        $staff_details = $this->site->getStaffByID($staff_id);
        $this->data['staff'] = $staff_details;
        
        $service_details = $this->site->getServiceByID($service_id);
        $this->data['service'] = $service_details;
        
        $warehouse_details = $this->site->getWarehouseByID($warehouse_id);
        $this->data['warehouse'] = $warehouse_details;
                        

        $booked = explode('-', $_POST['availableslot']);        
            
        $booked_date = date('Y-m-d', strtotime($_POST['availabledate']));

        $booked_time = date('H:i:s', strtotime($booked[0]));

        $booked_to_date = date('Y-m-d', strtotime($_POST['availabledate']));

        $booked_to_time = date('H:i:s', strtotime($booked[1]));

        
        // update the records

        $post_data = array('booked_date' => $booked_date,
            'booked_time' => $booked_time,
            'booked_to_date' => $booked_to_date,
            'booked_to_time' => $booked_to_time,
            'customer_id' => $customer_id,
            'staff_id' => $staff_id,
            'service_id' => $service_id,
            'warehouse_id' => $warehouse_id,
            'description' => $description,
            'status' => 1
        );



        $result = $this->db->insert('appointment_details',$post_data);
        if($result){
                
            $response['id'] = $this->db->insert_id();

            $sms = $this->site->getAllSms();


            if($sms->sale_sent == 1){
                $to = $phone;
                  
                $raw_message = "Dear ".$name." your appointment has been confirmed on date ".date('D d M, Y', strtotime($booked_date))." ".date('h:i A', strtotime($booked_time))." Team TheInfinityUnisexSalon";

                $this->sma->send_sms($to, $raw_message);
   
            }

            $subject = "Appointment - The Infinity Unisex Salon";
            
            if($email != ''){
            
                $pdata = array(

                    'site_link' => base_url(),

                    'site_name' => $this->Settings->site_name,

                    'company_logo' => base_url().'assets/uploads/logos/'.$this->Settings->logo2,

                    'title' => 'Appointment - '.$this->Settings->site_name,

                    'name' => $name,

                    'message' => "Your appointment has been confirmed on date ".date('D d M, Y', strtotime($booked_date))." ".date('h:i A', strtotime($booked_time))

                );
                $emessage = $this->load->view($this->theme . 'email_templates/reschedule_appointment', $pdata, true);
                $this->sma->send_email($email, $subject, $emessage);
            }

            $sdata = array(

                'site_link' => base_url(),

                'site_name' => $this->Settings->site_name,

                'company_logo' => base_url().'assets/uploads/logos/'.$this->Settings->logo2,

                'title' => 'Appointment - '.$this->Settings->site_name,

                'name' => $name,

                'staff_name' => $staff_details->name,

                'location_name' => $warehouse_details->name,
                
                'service_name' => $service_details->name,
                
                'phone' => $phone,
                
                'staff_message' => "Appointment has been confirmed on date ".date('D d M, Y', strtotime($booked_date))." ".date('h:i A', strtotime($booked_time))

            );
            
            $admin_email = 'theinfinitysalon1@gmail.com'; 
            $bcc = 'pssoma0@gmail.com'; 
            $smessage       = $this->load->view($this->theme . 'email_templates/staff_reschedule_appointment', $sdata, true);
            
            $this->sma->send_email($admin_email, $subject, $smessage, NULL, NULL, NULL, NULL, $bcc);

                $response['data'] = '<div class="dt-sc-appointment-notification-box" style="">
                
                    <div class="column dt-sc-one-half dt-sc-notification-details dt-sc-notification-schedulebox first" style="">
                        <h3>Schedule Details</h3>
                        <div class="dt-sc-schedule-details" id="dt-sc-schedule-details"><ul><li><label>Day : </label>'.date('l d M, Y', strtotime($booked_date)).' </li><li><label>Time : </label>'.date('h:i A', strtotime($booked_time)).'</li><li><label>Service : </label>'.$this->data['service']->name.'</li><li><label>Staff : </label>'.$this->data['staff']->name.'</li></ul></div>
                    </div>
                    
                    <div class="column dt-sc-one-half dt-sc-notification-details dt-sc-notification-contactbox" style="">
                        <h3>Contact Information</h3>
                        <div class="dt-sc-contact-info" id="dt-sc-contact-info"><ul><li><label>Name : </label>'.$name.'</li><li><label>Phone : </label>'.$phone.'</li><li><label>Email : </label>'.$email.'</li></ul></div>
                    </div>
        
                    <div class="dt-sc-margin25"></div>
                    <div class="clear"></div>
                     
                     
                    <div class="dt-sc-apt-success-box" style="">
                        <div class="dt-sc-notification-box dt-sc-success-box ">
                            <i class="fa fa-check"></i>
                            Appointment created successfully. Our professionals will be waiting for your arrival on appointment date.
                        </div>
                    </div>
                </div>';

        }else{
                $response['data'] = '<div class="dt-sc-appointment-notification-box" style="">
                    <div class="dt-sc-apt-error-box" style="">
                        <div class="dt-sc-notification-box dt-sc-error-box ">
                            <i class="fa fa-close"></i>
                                Oops! Something went wrong!
                        </div>  
                    </div>
                </div>';

        }

        $this->session->set_flashdata('c_data',$response['data']);        
        echo json_encode($response);

    }
    


    function update_appointment(){

        
        $data['title'] = 'Appointment';

        $id = $_POST['id'];

        $customer_id = $_POST['customer_id'];

        $name = $_POST['name'];
        $reschedule = $_POST['reschedule'];
        
        $email = $_POST['email'];

        $phone = $_POST['phone'];

        $status = $_POST['status'];

        $description = $_POST['description'];
        $event_start_date = date('Y-m-d', strtotime($_POST['event_start_date']));
        $event_start_time = date('g:iA', strtotime($_POST['event_start_time']));
        $event_end_date = date('Y-m-d', strtotime($_POST['event_end_date']));
        $event_end_time = date('g:iA', strtotime($_POST['event_end_time']));
        
        if($reschedule == 1){

            $check_already = $this->db->query('Select * from sma_appointment_details where booked_date = "'.$event_start_date.'" and booked_time = "'.$event_start_time.'" and id != "'.$id.'"')->num_rows();
            if($check_already > 0){
                $result['status'] = 201;  
                $result['data'] = 'Already Exist!';  
                header('Content-Type: application/json');
                
                echo json_encode($result);
        
                exit(); 
              
            }else
            {
                $post_data = array(
                    'booked_date' => $event_start_date,
                    'booked_to_date' => $event_end_date,
                    'booked_time' => $event_start_time,
                    'booked_to_time' => $event_end_time,
                    'reschedule' => $reschedule,
                    'status' => $status,
                    'description' => $description);
            }
            

        }else
        {
            $post_data = array('status' => $status,'reschedule' => $reschedule,'description' => $description);

        }

        // update the records
        $previous_data = $this->db->query('Select * from sma_appointment_details where id = "'.$id.'"')->row_array();
        $data['before_date'] = date('d-m-Y', strtotime($previous_data['booked_date']));
        $data['before_time'] = date('g:iA', strtotime($previous_data['booked_time']));        
        $data['name'] = $name;        
        $data['email'] = $email;        
        $data['after_date'] = date('d-m-Y', strtotime($event_start_date));        
        $data['after_time'] = date('g:iA', strtotime($event_start_time));        
        
        $staff_data = $this->db->query('Select name from sma_staffs where id = "'.$previous_data['staff_id'].'"')->row_array();
        
        $location_data = $this->db->query('Select name from sma_warehouses where id = "'.$previous_data['warehouse_id'].'"')->row_array();
        
        $service_data = $this->db->query('Select name from sma_website_services where id = "'.$previous_data['service_id'].'"')->row_array();
        
        $this->db->where('id',$id);

        $result_appointment = $this->db->update('appointment_details',$post_data);

        if($result_appointment){

            

            $post_mr_data = array('name' => $name,
            'email' => $email,
            'phone' => $phone);

            $this->db->where('id',$customer_id);
            
            $update_patient = $this->db->update('companies',$post_mr_data);

            // send rescheduled message
            if($reschedule == 1){

            $subject                  = "Reschedule Appointment - The Infinity Unisex Salon";
            
            if($email != ''){
            
                $pdata = array(

                    'site_link' => base_url(),

                    'site_name' => $this->Settings->site_name,

                    'company_logo' => base_url().'assets/uploads/logos/'.$this->Settings->logo2,

                    'title' => 'Reschedule Appointment - '.$this->Settings->site_name,

                    'name' => $name,

                    'message' => "Your appointment has been rescheduled from date ".$data['before_date']." ".$data['before_time']." to ".$data['after_date']." ".$data['after_time']

                );
                $emessage = $this->load->view($this->theme . 'email_templates/reschedule_appointment', $pdata, true);
                $this->sma->send_email($email, $subject, $emessage);
            }

            $sdata = array(

                'site_link' => base_url(),

                'site_name' => $this->Settings->site_name,

                'company_logo' => base_url().'assets/uploads/logos/'.$this->Settings->logo2,

                'title' => 'Reschedule Appointment - '.$this->Settings->site_name,

                'name' => $name,

                'staff_name' => $staff_data['name'],

                'location_name' => $location_data['name'],
                
                'service_name' => $service_data['name'],
                
                'phone' => $phone,
                
                'staff_message' => "Appointment has been rescheduled from date ".$data['before_date']." ".$data['before_time']." to ".$data['after_date']." ".$data['after_time']

            );
            
            $admin_email = 'theinfinitysalon1@gmail.com'; 
            $bcc = 'pssoma0@gmail.com'; 
            $smessage       = $this->load->view($this->theme . 'email_templates/staff_reschedule_appointment', $sdata, true);
            
            $this->sma->send_email($admin_email, $subject, $smessage, NULL, NULL, NULL, NULL, $bcc);

            $message="Dear ".$name.", your appointment has been rescheduled from date ".$data['before_date']." ".$data['before_time']." to ".$data['after_date']." ".$data['after_time'];
            
            $this->sma->send_sms($phone, $message);




            }
            $result['data'] = 'Updated successfully';  
            $result['status'] = 200;    
            header('Content-Type: application/json');
                
            echo json_encode($result);
            
        }else
        {
            $result['status'] = 201;
            $result['data'] = 'Oops..! Something Went wrong';  
            header('Content-Type: application/json');
                
            echo json_encode($result);
        
        }
                

    }

    function delete_appointment(){

        $data['title'] = 'Appointment';

        $id = $_POST['id'];

        $previous_data = $this->db->query('Select * from sma_appointment_details where id = "'.$id.'"')->row_array();
        $patient_data = $this->db->query('Select * from sma_companies where id = "'.$previous_data['customer_id'].'"')->row_array();
        $data['booked_date'] = date('d-m-Y', strtotime($previous_data['booked_date']));
        $booked_date = date('Y-m-d', strtotime($previous_data['booked_date']));
        
        $data['booked_time'] = date('g:iA', strtotime($previous_data['booked_time']));        
        $data['name'] = $patient_data['name'];        
        $data['email'] = $patient_data['email'];
        $data['phone'] = $patient_data['phone'];
        
        $this->db->where('id',$id);

        $result_appointment = $this->db->delete('sma_appointment_details');

        if($result_appointment){


            // $subject                  = "Appointment Rejected - Cutis";
            // $user_email_content       = $this->load->view('/templates/admin/delete_email', $data, true);
            // $user_email_response      = $this->emailhandler->send_smtp_email($subject, $user_email_content, $data['email']);
            
            // send rescheduled message
            $message="Dear ".$data['name'].", your appointment has been rejected on date ".$data['booked_date']." ".$data['booked_time'];

            $this->sma->send_sms($data['phone'], $message);

            $result['data'] = 'Deleted successfully';  
            $result['status'] = 200;    
            header('Content-Type: application/json');
                
            echo json_encode($result);
            
        }else
        {
            $result['status'] = 201;
            $result['data'] = 'Oops..! Something Went wrong';  
            header('Content-Type: application/json');
                
            echo json_encode($result);
        
        }
                

    }


}
