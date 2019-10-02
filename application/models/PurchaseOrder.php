<?php

class PurchaseOrder extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save($data, $id = NULL)
    {

        // Insert
        if ($id === NULL) {
            date_default_timezone_set('Asia/karachi');

            $entry_date = date("Y-m-d H:i:s");
            $data['E_DATE_TIME'] = $entry_date;
            $data['E_USER_ID'] = $this->session->userdata('userid');
            $this->db->set($data);
            $this->db->insert($this->_table_name);
            $id = $this->db->insert_id();
        } // Update
        else {

            date_default_timezone_set('Asia/karachi');

            $update_date = date("Y-m-d H:i:s");
            $data['U_DATE_TIME'] = $update_date;
            $data['U_USER_ID'] = $this->session->userdata('userid');

            //$filter = $this->_primary_filter;
            //$id = $filter($id);
            $this->db->set($data);
            $this->db->where($this->_primary_key, $id);
            $this->db->update($this->_table_name);
        }

        return $id;
    }

    public function find($id){
        $query = $this->db->query("select * from purchase as p 
                LEFT JOIN vendor as v ON v.vendor_id = p.vendor_id 
                LEFT JOIN warehouses as w ON w.warehouse_id = p.warehouse_id
                where purchase_id = $id");

        return $query->row();
    }

    public function get_details($id){
        $query = $this->db->query("select pod.*, i.item_name from purchase_details as pod, item as i WHERE i.item_id = pod.item_id AND pod.receive_qty < pod.purchase_qty AND purchase_id = $id");

        return $query->result();
    }

}


?>