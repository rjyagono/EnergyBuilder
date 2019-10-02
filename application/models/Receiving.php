<?php

class Receiving extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

        // get sales history
    public function getStock_receivings()
    {

        $this->db->select('stock_receivings.*, A.warehouse_name as site1, V.vendor_name as vendor_name, U.USER_NAME as created_by');

        $this->db->from('stock_receivings');
        $this->db->join('warehouses AS A', 'A.warehouse_id = stock_receivings.warehouse_id','LEFT');
        $this->db->join('vendor AS V', 'V.vendor_id = stock_receivings.vendor_id','LEFT');
        $this->db->join('usr_user AS U', 'U.USER_ID = stock_receivings.user_id','LEFT');


        if ($this->session->userdata('group_id') != 1) {
            $this->db->where("stock_receivings.warehouse_id", $this->_warehouse_id);
        } 
        
        $query = $this->db->get();

        return $query->result();
    }

    public function find($id){
        $query = $this->db->query("select * from stock_receivings as p 
                LEFT JOIN vendor as v ON v.vendor_id = p.vendor_id 
                LEFT JOIN warehouses as w ON w.warehouse_id = p.warehouse_id
                where id = $id");

        return $query->row();
    }

    public function get_details($id){
        $query = $this->db->query("select srd.*, i.item_name from stock_receiving_details as srd, item as i WHERE i.item_id = srd.item_id AND stock_receiving_id = $id");

        return $query->result();
    }

}


?>