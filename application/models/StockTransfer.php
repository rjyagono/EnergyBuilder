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

        $query = $this->db->query("SELECT stock_transfer_id,transfer_order_no,transfer_date , A.warehouse_name as site1, A.address as site1_address, B.warehouse_name as site2, B.address as site2_address, C.customer_name as customer_name FROM `stock_transfers` join `warehouses` AS A on `A`.`warehouse_id`= `stock_transfers`.`source_warehouse_id` join `warehouses` AS B on `B`.`warehouse_id`= `stock_transfers`.`destination_warehouse_id` join `customer` AS C on `C`.`customer_id`= `stock_transfers`.`customer_id` where `stock_transfers`.`stock_transfer_id`= $transfer_id ");
        return $query->row();
        
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