<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transfer extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Main_model');
        $this->load->model('StockTransfer');

        if ($this->session->userdata('user_id')) {
            //
        } else {


            redirect(base_url() . 'index.php/Users/login');

        }

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
        $post_data = array(
            'transfer_date' => $date,
            'source_warehouse_id' => $source_warehouse_id,
            'destination_warehouse_id' => $destination_warehouse_id,
            'transfer_status' => 1,
            'transfer_order_no' => $transfer_order_no,
            'customer_id' => $customer_id
        );


        $this->db->insert("stock_transfers", $post_data);
        $invoice_id = $this->db->insert_id();


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
                $data1 = $this->Main_model->check_stock_record($id, $category_id[$key]);

                if ($data1 == 1) {
                    $data = $this->Main_model->get_stock_qty($id, $category_id[$key]);
                    $ids = $data->stock_qty;
                    $new_id = $ids - $cartons[$key];

                    $data = array(
                        "stock_qty" => $new_id,
                    );
                    $where = array('item_id' => $id, 'category_id' => $category_id[$key]);
                    $this->Main_model->update_record('stock', $data, $where);

                } else {
                    $data = array(
                        "item_id" => $id,
                        "category_id" => $category_id[$key],
                        "stock_qty" => $cartons[$key],
                    );
                    $this->Main_model->add_record('stock', $data);
                }
            }

            $row['stock_transfer_id'] = $invoice_id;
            $row['item_id'] = $id;
            $row['transfer_qty'] = $cartons[$key];
            $row['status'] = 1;
            $data = $row;

            $res = $this->db->insert("stock_transfer_details", $data);

        }

        $this->session->set_flashdata("message", "Invoice #($transfer_order_no) Added Successfully!");
        redirect(base_url() . "index.php/transfer/transfer_history");


    }

    // Sales Table
    public function transfer_index()
    {
        $this->Main_model->bps_table('stock_transfers', 'stock_transfer_id');

    }

    // Sales History or Sales List
    public function transfer_history()
    {
        $this->transfer_index();
        $dat = array(
            "warehouses " => " warehouses.warehouse_id = stock_transfers.source_warehouse_id"
        );

        $data['transfer'] = $this->Main_model->get_join($dat);

        $this->header();
        $this->load->view('transfer/transfer_history', $data);
        $this->footer();
    }

    // Sale Items Table
    public function transferItems()
    {
        $this->Main_model->bps_table('sales', 'sales_no');

    }

    // Show single sales history in invoice
    public function show_transfer_history()
    {
        $id = $this->uri->segment(3);
        $data['header'] = $this->StockTransfer->getTransaction_history($id);
        $this->header();
        
        $data['details'] = $this->StockTransfer->getSale_Details($id);
        $this->load->view('transfer/item_transfer_historynew', $data);
        $this->footer();
    }

    public function invoice_print($id)
    {
        $data['header'] = $this->StockTransfer->getTransaction_history($id);
        $data['details'] = $this->StockTransfer->getSale_Details($id);
        
        $this->load->view('transfer/invoice_print', $data);
    }
}