<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Receivings extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Check if user is logged in or id exists in session
        $this->checkUserSession();
    }

    // Get item by search
    function listings()
    {
        $this->header();
        $data['receivings'] = $this->Receiving->getStock_receivings();
        $this->load->view('receivings/listings', $data);
        $this->footer();

    }

    function new_receiving()
    {
        $this->header();
        $data['products'] = $this->Main_model->select('item');
        $data['vendors'] = $this->Main_model->select('vendor');

        $this->load->view('receivings/new', $data);
        $this->footer();
    }

    public function show(){
        $id = $this->uri->segment(3);
        $this->header();

        $data['header'] = $this->Receiving->find($id);


        $data['details'] = $this->Receiving->get_details($id);

        $this->load->view('receivings/show', $data);
        $this->footer();
    }

    public function invoice_print(){
        $id = $this->uri->segment(3);
        $this->header();

        $data['header'] = $this->Receiving->find($id);
        $data['details'] = $this->Receiving->get_details($id);

        $this->load->view('receivings/print', $data);
        $this->footer();
    }
    
    public function receive_partial(){
        $id = $this->uri->segment(3);
        $this->header();

        $data['details'] = $this->PurchaseOrder->get_details($id);
        // echo $this->db->last_query();
        // exit;

        $this->load->view('receivings/partial', $data);
        $this->footer();
    }

    public function create(){
        extract($_POST);
        $invoice_no = $this->input->post('vendor_invoice_no');
        $date = date('Y-m-d', strtotime($receive_date));
        $warehouse_id = $this->session->userdata('warehouse_id');
        $user_id = $this->session->userdata('user_id');

        $post_data = array(
            'receive_date' => $date,
            'vendor_id' => $vendor_id,
            'total_amount' => $total_amount,
            'status' => STATUS_RECEIVED,
            'warehouse_id' => $warehouse_id,
            'user_id' => $user_id,
            'order_no' => $order_no,
        );

        if (!empty($invoice_no) && $invoice_no) {
            //$this->db->update('invoice', $post_data, ['id' => $invoice_id]);
            //$this->db->where('invoice_id', $invoice_id)->delete('invoice_details');
            $post_data['vendor_invoice_no'] = "SR0".$invoice_no;
        } else {
            $invoice_no = rand(10000000, 99999);
            $post_data['vendor_invoice_no'] = "SR0".$invoice_no;
        }

        $this->db->insert(" stock_receivings", $post_data);

        $invoice_id = $this->db->insert_id();

        // log create
            $this->logger
                ->user($user_id)
                ->user_name($this->_user_name)
                ->transaction_id($invoice_id)
                ->transaction_date(date('Y-m-d'))
                ->warehouse($this->_warehouse_id)
                ->type('SR')
                ->supplier_customer($post_data['vendor_id'])
                ->remarks('Receive Items from Supplier')
                ->balance($post_data['total_amount'])
                ->log();
        // end log

        $item_ids = $this->input->post('item_id');
        $cartons = $this->input->post('cartons');
        $supplier_rates = $this->input->post('supplier_rates');
        $rates = $this->input->post('rates'); 
        $totals = $this->input->post('totals');

        $data = [];
        foreach ($item_ids as $key => $id) {
            if (strlen($rates[$key]) > 0) {
                $data1 = $this->Main_model->check_stock_record($id, $warehouse_id);

                if ($data1 == 1) {
                    $data = $this->Main_model->get_stock_qty($id, $warehouse_id);
                    $qty = $data->stock_qty;
                    $new_qty = $qty + $cartons[$key];

                    $data = array(
                        "stock_qty" => $new_qty,
                        "stock_rate" => $rates[$key],
                        "purchase_rate" => $supplier_rates[$key],
                    );
                    $where = array('item_id' => $id);
                    $this->Main_model->update_record('stock', $data, $where);

                } else {
                    $data = array(
                        "item_id" => $id,
                        "stock_qty" => $cartons[$key],
                        "stock_rate" => $rates[$key],
                        "warehouse_id" => $warehouse_id,
                        "purchase_rate" => $supplier_rates[$key],
                    );
                    $this->Main_model->add_record('stock', $data);
                }
            }

            $row['stock_receiving_id'] = $invoice_id;
            $row['item_id'] = $id;
            $row['qty'] = $cartons[$key];
            $row['unit_cost'] = $supplier_rates[$key];
            $row['selling_price'] = $rates[$key];
            $row['user_id'] = $user_id;
            $row['amount'] = $totals[$key];

            $res = $this->db->insert("stock_receiving_details", $row);


            // log details
            $this->logger
                    ->item($row['item_id'])
                    ->user($row['user_id'])
                    ->user_name($this->_user_name)
                    ->transaction_id($row['stock_receiving_id'])
                    ->transaction_date(date('Y-m-d'))
                    ->warehouse($this->_warehouse_id)
                    ->type('SR')
                    ->supplier_customer($post_data['vendor_id'])
                    ->remarks('Recieve '.$row['item_id'].' item from Supplier')
                    ->balance($post_data['total_amount'])
                    ->stock_in($row['qty'])
                    ->quantity($data['stock_qty'])
                    ->log();
            // end log details
        }

        $this->session->set_flashdata("message", "Invoice #($invoice_id) Added Successfully!");
        redirect(base_url() . "index.php/receivings/listings");
    }

    public function receive_po(){
        $id = $this->uri->segment(3);
        $type = $this->uri->segment(4);
        $warehouse_id = $this->_warehouse_id;
        $user_id = $this->session->userdata('user_id');

        $where = array('purchase_id' => $id);
        $header = $this->Main_model->single_row('purchase', $where);
        $records = $this->Main_model->select_wher('purchase_details', $where);

        $insert_arry = array(
          'vendor_invoice_no'        => 'SR-'.$type.$id,
          'po_id'                    => $id,
          'destination_warehouse_id' => $header->destination_warehouse_id,
          'warehouse_id'             => $warehouse_id,
          'order_no'                 => $header->pur_no,
          'user_id'                  => $user_id,
          'status'                   => 1002,
          'receive_date'             => date('Y-m-d'),
          'total_amount'             => $header->grand_total,      
        );

        $receiving = $this->Main_model->add_record('stock_receivings', $insert_arry);

        // log create
            $this->logger
                ->user($user_id)
                ->user_name($this->_user_name)
                ->transaction_id($receiving)
                ->transaction_date(date('Y-m-d'))
                ->warehouse($this->_warehouse_id)
                ->type('SR-PO')
                ->remarks('Stock Recieve from PO')
                ->balance($header->grand_total)
                ->log();
        // end log

        // save transfer details to receiving details
        $data = [];
        foreach ($records as $record) {
            if (strlen($record->purchase_qty) > 0) {
                $data1 = $this->Main_model->check_stock_record($record->item_id, $header->warehouse_id);

                if ($data1 == 1) {
                    $data = $this->Main_model->get_stock_qty($record->item_id, $header->warehouse_id);
                    $ids = $data->stock_qty;
                    $new_qty = $ids + $record->purchase_qty;

                    $data = array(
                        "stock_qty" => $new_qty,
                    );
                    $where = array('item_id' => $record->item_id, 'warehouse_id' => $header->warehouse_id);
                    $this->Main_model->update_record('stock', $data, $where);

                } else {
                    $data = array(
                        "item_id" => $record->item_id,
                        "stock_qty" => $record->purchase_qty,
                        "warehouse_id" => $header->warehouse_id,
                    );
                    $this->Main_model->add_record('stock', $data);
                }
            }

            $row['stock_receiving_id'] = $receiving;
            $row['item_id'] = $record->item_id;
            $row['qty'] = $record->purchase_qty;
            $row['unit_cost'] = $record->purchase_rate;
            $row['selling_price'] = $record->sales_rate;
            $row['user_id'] = $user_id;
            $row['amount'] = $record->purchase_amount;

            $res = $this->db->insert("stock_receiving_details", $row);

            // log details
            $this->logger
                    ->item($record->item_id)
                    ->user($user_id)
                    ->user_name($this->_user_name)
                    ->transaction_id($receiving)
                    ->transaction_date(date('Y-m-d'))
                    ->warehouse($this->_warehouse_id)
                    ->type('SR-PO')
                    ->remarks('Recieve '.$record->item_id.' item from PO')
                    ->balance($record->purchase_amount)
                    ->stock_in($record->purchase_qty)
                    ->quantity($data['stock_qty'])
                    ->log();
            // end log details
        }
 
        // if sucessfull transfer update stransfer header status
            $data = ['status' => 1004];
            $this->db->update('purchase', $data, ['purchase_id' => $id]); 

        // echo $this->db->last_query();
   
        // exit;

        $this->session->set_flashdata("success", "Receive Purchase Order Successfully!");
        redirect(base_url() . "index.php/receivings/listings");
    }

    public function receive_partial_po(){
        extract($_POST);
        
        $po_id = $id;
        $type = 'SR-PO';
        $warehouse_id = $this->_warehouse_id;
        $user_id = $this->session->userdata('user_id');


        $where = array('purchase_id' => $po_id);
        $header = $this->Main_model->single_row('purchase', $where);


        $insert_arry = array(
          'vendor_invoice_no'        => $vendor_invoice_no ?: 'SR-'.$po_id,
          'po_id'                    => $po_id,
          'destination_warehouse_id' => $header->destination_warehouse_id,
          'warehouse_id'             => $warehouse_id,
          'order_no'                 => $header->pur_no,
          'user_id'                  => $user_id,
          'status'                   => STATUS_RECEIVED,
          'receive_date'             => $receive_date,
          'total_amount'             => $header->grand_total,      
        );

        $receiving = $this->Main_model->add_record('stock_receivings', $insert_arry);


        // save po details to receiving details
        $data = [];
        $total_amount = 0;
        foreach ($item_ids as $key => $id) {
            if (strlen($qty_received[$key]) > 0) {
                $data1 = $this->Main_model->check_stock_record($id, $header->destination_warehouse_id);

                if ($data1 == 1) {
                    $data = $this->Main_model->get_stock_qty($id, $header->destination_warehouse_id);
                    $qty = $data->stock_qty;
                    $new_qty = $qty + (int)$qty_received[$key];

                    $data = array(
                        "stock_qty" => $new_qty,
                    );
                    $where = array('item_id' => $id, 'warehouse_id' => $header->destination_warehouse_id);
                    $this->Main_model->update_record('stock', $data, $where);

                } else {
                    $data = array(
                        "item_id" => $id,
                        "stock_qty" => (int)$qty_received[$key],
                        "warehouse_id" => $header->destination_warehouse_id,
                    );
                    $this->Main_model->add_record('stock', $data);
                }

                // update PO item detail
                $receive_qty  = (int)$qty_received[$key] ;
                $where = array('purchase_detail_id' => $detail_ids[$key]);
                $purchase_data = array('receive_qty' => $receive_qty);
                $datail_entry = $this->Main_model->update_record('purchase_details', $purchase_data, $where);


                $row['stock_receiving_id'] = $receiving;
                $row['item_id'] = $id;
                $row['qty'] = (int)$qty_received[$key];
                $row['unit_cost'] = $price[$key];
                $row['selling_price'] = 0;
                $row['user_id'] = $user_id;
                $row['amount'] = (int)$qty_received[$key] * $price[$key];
                $total_amount += $row['amount'];

                $res = $this->db->insert("stock_receiving_details", $row);

                // log details
                $this->logger
                        ->item($id)
                        ->user($user_id)
                        ->user_name($this->_user_name)
                        ->transaction_id($receiving)
                        ->transaction_date(date('Y-m-d'))
                        ->warehouse($this->_warehouse_id)
                        ->type('SR-PO')
                        ->remarks('Recieve '.$id.' item from partial PO')
                        ->balance($row['amount'])
                        ->stock_in($row['qty'])
                        ->quantity($row['qty'])
                        ->log(); 

            } // end if

        } // end loop

                // log create
            $this->logger
                ->user($user_id)
                ->user_name($this->_user_name)
                ->transaction_id($receiving)
                ->transaction_date(date('Y-m-d'))
                ->warehouse($this->_warehouse_id)
                ->type('SR-PO')
                ->balance($total_amount)
                ->remarks('Stock Recieve from partial PO')
                ->log();
        // end log
 
        // if sucessfull transfer update stransfer header status
            $data = ['status' => STATUS_PARTIAL];
            $this->db->update('purchase', $data, ['purchase_id' => $po_id]); 

        // echo $this->db->last_query();
   
        // exit;

        $this->session->set_flashdata("success", "Receive Purchase Order Successfully!");
        redirect(base_url() . "index.php/receivings/listings");
    }


    public function receive_transfer(){
        $id = $this->uri->segment(3);
        $type = $this->uri->segment(4);
        $warehouse_id = $this->_warehouse_id;
        $user_id = $this->session->userdata('user_id');

        $where = array('stock_transfer_id' => $id);

        $header = $this->Main_model->single_row('stock_transfers', $where);
        $records = $this->StockTransfer->getSale_Details($id);

        // save transfer header to receiving

        $insert_arry = array(
          'vendor_invoice_no'        => 'SR-'.$type.$id,
          'trasfer_order_id'         => $id,
          'warehouse_id'             => $warehouse_id,
          'destination_warehouse_id' => $header->destination_warehouse_id,
          'source_warehouse_id'      => $header->source_warehouse_id,
          'order_no'                 => $header->transfer_order_no,
          'user_id'                  => $user_id,
          'status'                   => $transfer,
          'receive_date'             => date('Y-m-d'),
          'total_amount'             => $header->transfer_total_amount,      
        );

        $receiving = $this->Main_model->add_record('stock_receivings', $insert_arry);

        // log create
            $this->logger
                ->user($user_id)
                ->user_name($this->_user_name)
                ->transaction_id($receiving)
                ->transaction_date(date('Y-m-d'))
                ->warehouse($this->_warehouse_id)
                ->type('SR-ST')
                ->remarks('Recieve Items')
                ->balance($header->transfer_total_amount)
                ->log();
        // end log


        // save transfer details to receiving details
        $data = [];
        foreach ($records as $record) {
            if (strlen($record->transfer_qty) > 0) {
                $data1 = $this->Main_model->check_stock_record($record->item_id, $header->destination_warehouse_id);

                if ($data1 == 1) {
                    $data = $this->Main_model->get_stock_qty($record->item_id, $header->destination_warehouse_id);
                    $ids = $data->stock_qty;
                    $new_qty = $ids + $record->transfer_qty;

                    $data = array(
                        "stock_qty" => $new_qty,
                    );
                    $where = array('item_id' => $record->item_id, 'warehouse_id' => $header->destination_warehouse_id);
                    $this->Main_model->update_record('stock', $data, $where);

                } else {
                    $data = array(
                        "item_id" => $record->item_id,
                        "stock_qty" => $record->transfer_qty,
                        "warehouse_id" => $header->destination_warehouse_id,
                    );
                    $this->Main_model->add_record('stock', $data);
                }
            }

            $row['stock_receiving_id'] = $receiving;
            $row['item_id'] = $record->item_id;
            $row['qty'] = $record->transfer_qty;
            $row['unit_cost'] = 0;
            $row['selling_price'] = $record->transfer_rate;
            $row['user_id'] = $user_id;
            $row['amount'] = $record->transfer_totals;

            $res = $this->db->insert("stock_receiving_details", $row);

            // log details
            $this->logger
                    ->item($record->item_id)
                    ->user($user_id)
                    ->user_name($this->_user_name)
                    ->transaction_id($receiving)
                    ->transaction_date(date('Y-m-d'))
                    ->warehouse($this->_warehouse_id)
                    ->type('SR-ST')
                    ->remarks('Transfer Items')
                    ->balance($record->transfer_totals)
                    ->stock_in($record->transfer_qty)
                    ->quantity($data['stock_qty'])
                    ->log();
            // end log details
        }
 
        // if sucessfull transfer update stransfer header status
            $data = ['transfer_status' => 1];
            $this->db->update('stock_transfers', $data, ['stock_transfer_id' => $id]); 

        // //echo $this->db->last_query();
        // //echo $this->db->insert_id();
        // exit;

        $this->session->set_flashdata("success", "Items Transfered Successfully!");
        redirect(base_url() . "index.php/receivings/listings");
    }


}