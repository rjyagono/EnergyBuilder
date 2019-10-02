<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transfer extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Check if user is logged in or id exists in session
        $this->checkUserSession();
    }

    // creating New Transfer Form
    public function new_transfer()
    {

        $data['purchase'] = $this->Main_model->item_cat();
        $data['products'] = $this->Main_model->select('item');
        $data['warehouses'] = $this->Main_model->select('warehouses');
        $data['companies'] = $this->Main_model->select('company');
        $data['category'] = $this->Main_model->select('category');
        $data['customers'] = $this->Main_model->select('customer');
        
        $record = $this->Main_model->get_sales_max();

        $this->header($title = 'New Stock Transfer');
        $this->load->view('transfer/new_transfer', $data);
        $this->footer();

    }

    // get product list of sales
    public function get_sale_product_list()
    {
        $cat_id = $this->uri->segment(3);
        $response = $this->Main_model->get_sale_data($cat_id);
        $output = '';
        $output .= '<p onclick="add_product("' . $cat_id . '")" style="cursor: pointer;">';
        $output .= '
					<span class="fa-stack fa-2x text-success">
						<i class="fa fa-circle-o fa-stack-2x"></i>
						<i class="fa fa-plus fa-stack-1x"></i>
					</span>' . $response->item_name . '
				</p>';
        echo $output;
    }

    // get product detail by ajax search
    public function get_details()
    {

        $product_id = $this->input->post('id', true);
        $data = $this->Main_model->get_product_details_v2($product_id);
        if ($data) {
            header('application/json');
            echo json_encode($data);
        } else {
            header('application/json');
            $d = 0;
            echo json_encode($d);
        }
    }

    function imran()
    {
        $product_id = $this->input->post('id', true);
        $data = $this->Main_model->get_product_details_v2($product_id);
        if ($data) {
            echo json_encode($data);
        } else {
            $d = 0;
            echo json_encode($d);
        }
    }

    // Create Invoice
    public function create_invoice_action()
    {
        extract($_POST);

        $invoice_id = $this->input->post('invoice_id');
        $date = date('Y-m-d', strtotime($_POST['transfer_date']));
        $warehouse_id = $this->_warehouse_id;
        $user_id = $this->_user_id;

        $post_data = array(
            'transfer_date' => $date,
            'source_warehouse_id' => $this->_warehouse_id,
            'destination_warehouse_id' => $destination_warehouse_id,
            'transfer_status' => STATUS_INTRANSIT,
            'transfer_order_no' => $transfer_order_no,
            'transfer_total_amount' => $total_amount,
            'reason' => $reason,
        );


        $this->db->insert("stock_transfers", $post_data);
        $invoice_id = $this->db->insert_id();

                // echo $this->db->last_query();
                // echo $this->db->insert_id();
                // exit;

        // log create
            $this->logger
                ->user($user_id)
                ->user_name($this->_user_name)
                ->transaction_id($invoice_id )
                ->transaction_date(date('Y-m-d'))
                ->warehouse($this->_warehouse_id)
                ->type('ST')
                ->remarks('Items In Transit for transfer')
                ->balance($post_data['transfer_total_amount'])
                ->log();
        // end log

        // This code need to be reviewed why $invoice_id = $this->db->insert_id(); is not working

            $maxID = $this->StockTransfer->get_transfer_max();
            $max = $maxID->stock_transfer_id;
            $invoice_id = $max;

        // end for review

        $product_ids = $this->input->post('product_id');
        $category_id = $this->input->post('category_id');
        $cartons = $this->input->post('cartons'); 

        $data = [];
        foreach ($product_ids as $key => $id) {
            if (strlen($cartons[$key]) > 0) {
                $data1 = $this->Main_model->check_stock_record($id, $warehouse_id);

                if ($data1 == 1) {
                    $data = $this->Main_model->get_stock_qty($id, $warehouse_id);
                    $ids = $data->stock_qty;
                    $new_id = $ids - $cartons[$key];

                    $data = array(
                        "stock_qty" => $new_id,
                    );
                    $where = array('item_id' => $id, 'warehouse_id' => $warehouse_id);
                    $this->Main_model->update_record('stock', $data, $where);

                } 
                // else {
                //     $data = array(
                //         "item_id" => $id,
                //         "stock_qty" => $cartons[$key],
                //         "warehouse_id" => $warehouse_id,
                //     );
                //     $this->Main_model->add_record('stock', $data);
                // }

            }

            $row['stock_transfer_id'] = $invoice_id;
            $row['item_id'] = $id;
            $row['transfer_qty'] = $cartons[$key];
            $row['transfer_rate'] = $rates[$key];
            $row['transfer_totals'] = $totals[$key];

            $res = $this->db->insert("stock_transfer_details", $row);

            // log create
                $this->logger
                    ->user($user_id)
                    ->user_name($this->_user_name)
                    ->transaction_id($invoice_id)
                    ->transaction_date(date('Y-m-d'))
                    ->warehouse($this->_warehouse_id)
                    ->stock_out($cartons[$key])
                    ->type('ST') 
                    ->remarks('Transfered to site '.$post_data['destination_warehouse_id'])
                    ->quantity($data['stock_qty'])
                    ->log();
            // end log
        }
        
        $this->session->set_flashdata("success", "Invoice #($transfer_order_no) Added Successfully!");
        redirect(base_url() . "index.php/transfer/listings");


    }

    public function process_transfer(){
        $id = $this->input->post('stock_transfer_id');
        $warehouse_id = $this->_warehouse_id;
        $user_id = $this->session->userdata('user_id');
        $receive_date = $this->input->post('receive_date');
        $receive_status = $this->input->post('transfer_status');

        $where = array('stock_transfer_id' => $id);

        $header = $this->Main_model->single_row('stock_transfers', $where);
        $records = $this->StockTransfer->getSale_Details($id);

        // save transfer header to receiving

        $insert_arry = array(
          'receive_date' => date('Y-m-d')    
        );

        // log create
            $this->logger
                ->user($user_id)
                ->user_name($this->_user_name)
                ->transaction_id($id)
                ->transaction_date($receive_date)
                ->warehouse($this->_warehouse_id)
                ->type('ST')
                ->remarks('Recieve Transfered Items')
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

            // From Warehouse
                $this->logger
                    ->user($user_id)
                    ->item($record->item_id)
                    ->user_name($this->_user_name)
                    ->transaction_id($id)
                    ->transaction_date($receive_date)
                    ->warehouse($header->destination_warehouse_id)
                    ->stock_in($record->transfer_qty)
                    ->type('ST')
                    ->remarks('Recieve from site '.$this->_warehouse_id)
                    ->balance($header->transfer_total_amount)
                    ->quantity($data['stock_qty'])
                    ->log();
            // end log


        }
 
        // if sucessfull transfer update stransfer header status
            $data = ['transfer_status' => $receive_status, 'receive_date' => $receive_date];
            $this->db->update('stock_transfers', $data, ['stock_transfer_id' => $id]); 

        // echo $this->db->last_query();
        // echo $this->db->insert_id();
        // exit;

        $this->session->set_flashdata("success", "Items Transfered Successfully!");
        redirect(base_url() . "index.php/transfer/listings");
    }

    // Sales Table
    public function transfer_index()
    {
        $this->Main_model->bps_table('stock_transfers', 'stock_transfer_id');

    }

    // Sales History or Sales List
    public function listings()
    {
        // $this->transfer_index();
        // $dat = array(
        //     "warehouses " => " warehouses.warehouse_id = stock_transfers.source_warehouse_id"
        // );

        // $data['transfers'] = $this->Main_model->get_join($dat);
        $data['transfers'] = $this->StockTransfer->getListings();

        $this->header();
        $this->load->view('transfer/listings', $data);
        $this->footer();
    }

    // Sale Items Table
    public function transferItems()
    {
        $this->Main_model->bps_table('sales', 'sales_no');
    }

    // Show single sales history in invoice
    public function receive()
    {
        $this->header();
        $id = $this->uri->segment(3);
        $data['header'] = $this->StockTransfer->getTransaction_history($id);
        $data['details'] = $this->StockTransfer->getSale_Details($id);
        $this->load->view('transfer/receive', $data);
        $this->footer();
    }

    // Show single sales history in invoice
    public function show()
    {
        $id = $this->uri->segment(3);
        $data['header'] = $this->StockTransfer->getTransaction_history($id);
        $this->header();
        
        $data['details'] = $this->StockTransfer->getSale_Details($id);
        $this->load->view('transfer/show', $data);
        $this->footer();
    }

    public function invoice_print($id)
    {
        $data['header'] = $this->StockTransfer->getTransaction_history($id);
        $data['details'] = $this->StockTransfer->getSale_Details($id);
        
        $this->load->view('transfer/invoice_print', $data);
    }

}