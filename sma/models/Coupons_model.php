<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupons_model extends CI_Model
{
    private $table = 'coupons';

    public function get_all_coupons()
    {
        return $this->db->get($this->table)->result();
    }

    public function get_coupon($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert_coupon($data)
    {
        $this->db->insert($this->table, $data);
    }

    public function update_coupon($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }

    public function delete_coupon($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }
}
