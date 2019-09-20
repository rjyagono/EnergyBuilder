<?php
/*
 *	@author : Jude 
 *	date	: 18 Sep17, 2019
 *	Xchan Inventory Management System
 *  version: 1.0
 */
class Warehouse extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

        // get sales history
    public function getWarehouse($warehouse_id)
    {

        $query = $this->db->query("SELECT stock_transfer_id,transfer_order_no,transfer_date , A.warehouse_name as site1, A.address as site1_address, B.warehouse_name as site2, B.address as site2_address FROM `stock_transfers` join `warehouses` AS A on `A`.`warehouse_id`= `stock_transfers`.`source_warehouse_id` join `warehouses` AS B on `B`.`warehouse_id`= `stock_transfers`.`destination_warehouse_id` where `stock_transfers`.`stock_transfer_id`= $transfer_id ");
        return $query->row();
        
    }

    // get sale details by sale id
    public function getWarehouse_Items($id)
    {

        $query = $this->db->select()->from('stock_transfer_details as std,item as i')
            ->where('std.item_id = i.item_id')
            ->where("std.stock_transfer_id", $id)
            ->get();

        return $query->result();
    }

    // get max transfer id
    public function get_warehouse_max()
    {
        $this->db->select_max('warehouse_id');
        $q = $this->db->get('warehouses');
        $data = $q->row();

        return $data;
    }

}


?>