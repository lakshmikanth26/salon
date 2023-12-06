<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Staffs_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    
    
    public function getStaffByID($id)
    {
        $q = $this->db->get_where('staffs', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getStaffByEmail($email)
    {
        $q = $this->db->get_where('staffs', array('email' => $email), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function addStaff($data = array())
    {
        if ($this->db->insert('staffs', $data)) {
            $cid = $this->db->insert_id();
            return $cid;
        }
        return false;
    }

    public function updateStaff($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update('staffs', $data)) {
            return true;
        }
        return false;
    }

    public function addStaffs($data = array())
    {
        if ($this->db->insert_batch('staffs', $data)) {
            return true;
        }
        return false;
    }

    public function get_appointments($start_format, $end_format)

    {   

       $query = $this

                ->db

                ->select('a.id as id, c.name as name, c.email as email, c.phone as phone,a.booked_date, a.booked_time,a.booked_to_time, a.staff_id, a.status as status, a.description as description, a.customer_id as customer_id, a.reschedule as reschedule, s.name as staffname,s.cf6 as staffcolor, a.warehouse_id as warehouse_id, a.service_id as service_id, w.name as location, ws.name as service')

                ->from('appointment_details as a')

                ->join('staffs as s', 's.id = a.staff_id', 'INNER')

                ->join('warehouses as w', 'w.id = a.warehouse_id', 'INNER')

                ->join('website_services as ws', 'ws.id = a.service_id', 'INNER')

                ->join('companies as c', 'c.id = a.customer_id', 'INNER')
                
                ->where("CONCAT(a.booked_date, ' ', a.booked_time) >= ".$start_format."", NULL, FALSE)

                ->or_where("CONCAT(a.booked_date, ' ', a.booked_to_time) <= ".$end_format."", NULL, FALSE);

                $query = $this->db->get();

                //print_r($this->db->last_query()); die();

                return $query;

    }


    
    public function deleteStaff($id)
    {
        if ($this->getStaffSales($id)) {
            return false;
        }
        if ($this->db->delete('staffs', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

    public function getStaffSales($id)
    {
        $this->db->where('staff_id', $id)->from('sales');
        return $this->db->count_all_results();
    }


    
    
}
