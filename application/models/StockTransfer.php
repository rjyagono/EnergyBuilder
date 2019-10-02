<?php
/*
 *	@author : Jude 
 *	date	: 18 Sep17, 2019
 *	Xchan Inventory Management System
 *  version: 1.0
 */
class StockTransfer extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

        // get sales history
    public function getTransaction_history($transfer_id)
    {

        $query = $this->db->query("SELECT stock_transfer_id,transfer_order_no,transfer_date,transfer_total_amount, transfer_status, A.warehouse_name as site1, A.address as site1_address, B.warehouse_name as site2, B.address as site2_address FROM `stock_transfers` join `warehouses` AS A on `A`.`warehouse_id`= `stock_transfers`.`source_warehouse_id` join `warehouses` AS B on `B`.`warehouse_id`= `stock_transfers`.`destination_warehouse_id` where `stock_transfers`.`stock_transfer_id`= $transfer_id ");

        return $query->row();
        
    }

    public function getListings()
    {

        $this->db->select('stock_transfer_id,transfer_order_no,transfer_date,transfer_total_amount,transfer_status,reason, A.warehouse_name as site1, A.address as site1_address, B.warehouse_name as site2, B.address as site2_address');

        $this->db->from('stock_transfers');
        $this->db->join('warehouses AS A', 'A.warehouse_id = stock_transfers.source_warehouse_id');
        $this->db->join('warehouses AS B', 'B.warehouse_id = stock_transfers.destination_warehouse_id');

        if ($this->session->userdata('group_id') != 1) {
            $this->db->where("stock_transfers.destination_warehouse_id", $this->_warehouse_id);
        } 
        
        $query = $this->db->get();
        // echo $this->db->last_query();
        // echo $this->db->insert_id();
        // exit;
        return $query->result();
    }

    // get sale details by sale id
    public function getSale_Details($id)
    {

        $query = $this->db->select()->from('stock_transfer_details as std,item as i')
            ->where('std.item_id = i.item_id')
            ->where("std.stock_transfer_id", $id)
            ->get();

        return $query->result();
    }

    // get max transfer id
    public function get_transfer_max()
    {
        $this->db->select_max('stock_transfer_id');
        $q = $this->db->get('stock_transfers');
        $data = $q->row();

        return $data;
    }

}


?>