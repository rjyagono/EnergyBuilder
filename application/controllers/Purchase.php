<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchase extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Check if user is logged in or id exists in session
        $this->checkUserSession();
    }

    // Get item by search
    function get_items()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);

        }
        $results = $this->Main_model->get_search_results();
        echo $results;

    }

    // Loading New Purchase form
    public function new_purchase()
    {
        $warehouse_id = $this->_warehouse_id;
        $data['purchase'] = $this->Main_model->item_cat();
        $data['products'] = $this->db->query("SELECT * FROM stock AS s, item AS i WHERE  s.stock_qty >= 0 AND i.`item_id` = s.`item_id` AND s.`warehouse_id` = $warehouse_id")->result();
        $data['vendors'] = $this->Main_model->select('vendor');
        $data['warehouses'] = $this->Main_model->select('warehouses');

        $this->header();
        $this->load->view('purchase/new', $data);
        $this->footer();
    }

    public function edit()
    {
        $warehouse_id = $this->_warehouse_id;
        $purchase_id = $this->uri->segment(3);
        $where = array('purchase_id' => $purchase_id);

        $data['header'] = $this->Main_model->single_row('purchase', $where);
        $data['details'] = $this->Main_model->select('purchase_details', 'purchase_id = $purchase_id');
        $data['products'] = $this->db->query("SELECT * FROM stock AS s, item AS i WHERE  s.stock_qty >= 0 AND i.`item_id` = s.`item_id` AND s.`warehouse_id` = $warehouse_id")->result();
        $data['vendors'] = $this->Main_model->select('vendor');
        $data['warehouses'] = $this->Main_model->select('warehouses');

        $this->header();
        $this->load->view('purchase/edit', $data);
        $this->footer();
    }
    // Daily Purchase Report
    public function daily_purchase_report()
    {
        $id = $this->uri->segment(3);
        $data["purchase_item_daily"] = $this->Main_model->get_purchase_daily_report($id);
        $this->header($title = 'Daily Purchase report');
        $this->load->view('purchase/daily_purchase_report', $data);
        $this->footer();
    }

    // Daily Purchases on Dashboard
    public function daily_dash_board_purchase()
    {
        $this->header($title = 'Daily Dashboard Purchase');
        $data["daily_p"] = $this->Main_model->daily_dash_board_purchase();
        $this->load->view('purchase/daily_dash_board_purchase', $data);
        $this->footer();
    }

    // Get Products by Search
    public function get_products()
    {
        $keyword = $this->input->post('keyword');
        $keyword = strtolower($keyword);
        $data = $this->Main_model->GetRow($keyword);
        echo json_encode($data);
    }

    // Daily Dashboard Stock
    public function daily_dash_board_stock()
    {
        $this->header($title = 'Daily Dashboard Stock');
        $data["daily_st"] = $this->inventory_model->daily_dash_board_stock();
        $this->load->view('daily_dash_board_stock', $data);
        $this->footer();
    }

    // Get data for purchased
    public function get_data_for_purchased()
    {
        $item_id = $this->input->post('id');
        $count = $this->input->post('total');
        $this->load->model('Main_model');

        $where = array('item_id' => $item_id);
        $data = $this->Main_model->get_purchased($item_id);

        if ($item_id != 0) {
            $output = '';
            $output .= '<tr id="entry_row_' . $count . '">';
            $output .= '<td id="serial_' . $count . '">' . $count . '</td>';
            $output .= '<td><input type="hidden" name="item_id[]" value="' . $data->item_id . '"> ' . $data->item_id . '</td>';
            $output .= '<input type="hidden" name="category_id[]" value="' . $data->category_id . '">';
            $output .= '<td>' . $data->item_name . '</td>';
            $output .= '<td><div id="spinner4">

            <input type="text" name="quantity[]" tabindex="1" id="quantity_' . $count . '" onclick="calculate_single_entry_sum(' . $count . ')" size="2" value="1" class="form-control col-lg-2" onkeyup="calculate_single_entry_sum(' . $count . ')">

                                    </div>
                                </div></td>';
                $output .= '<td><input type="text" class="form-control col-lg-2" name="unit_price[]" id="unit_price_' . $count . '" size="6" value="' . $data->purchase_rate . ' "onkeyup="calculate_single_entry_sum(' . $count . ')"></td>';
                $output .= '<td>
            <input type="text" class="form-control col-lg-2" name="purchase_amount[]" readonly="readonly" id="single_entry_total_' . $count . '" size="6" value="' . $data->purchase_rate . '">
            </td>';
                $output .= '<td>
            <i style="cursor: pointer;" id="delete_button_' . $count . '" onclick="delete_row(' . $count . ')" class="fa fa-trash"></i>
    				</td>';
                $output .= '</tr>';

            echo $output;
        } else {
            echo $output = 0;
        }
    }

    public function save_purchase()
    {
        extract($_POST);

        $this->load->helper('date');
        $item_id = $this->input->post('item_id'); 
        $rates = $this->input->post('rates');
        $quantity = $this->input->post('cartons');
        $purchase_id = $this->input->post('purchase_id');
        $purchase_amount = $this->input->post('totals');
        $where = array('purchase_id' => $purchase_id);

        $warehouse_id = $this->_warehouse_id;
        $user_id = $this->_user_id;

        // Todo  change to local timezone & move to global settings
        $timezone = 'Asia/Karachi';
        date_default_timezone_set($timezone);
        // end todo

        $purchase_date = $this->input->post('purchase_date');
        $delivery_date = $this->input->post('delivery_date');

        $vendor_id = $this->input->post('vendor_id');
        $destination_warehouse_id = $this->input->post('warehouse_id');
        $paymentTotal = $this->input->post('paymentTotal');
        $discount = $this->input->post('discount');
        $due_amount = $this->input->post('due_amount');
        $total_amount = $this->input->post('total_amount');
        $status = STATUS_DRAFT; // define in global config


        $Purchase_comp_Ins = array(
            'purchase_date' => $purchase_date,
            'vendor_id' => $vendor_id,
            'destination_warehouse_id' => $destination_warehouse_id,
            'purchase_amount_total' => $paymentTotal,
            'purchase_discount' => $discount,
            'due_amount' => $due_amount,
            'grand_total' => $total_amount,
            'status' => $status,
            'warehouse_id' => $destination_warehouse_id,
            'user_id' => $user_id,
            'delivery_date' => $delivery_date,
        );

        if($purchase_id){
            $where = array('purchase_id' => $purchase_id);
            $this->Main_model->update_record('purchase', $Purchase_comp_Ins, $where);
        } else {
            $record = $this->Main_model->get_purchase_max();
            $ddd = $record->purchase_id;
            $purchase_no = $ddd + 1;

            $Purchase_comp_Ins['pur_no'] = "PO-" . $purchase_no; 
            $purchase_id = $this->Main_model->add_record('purchase', $Purchase_comp_Ins);
        }

        $this->session->set_userdata("purchase_id", $purchase_id);


        // log create
            $this->logger
                ->user($user_id)
                ->user_name($this->_user_name)
                ->transaction_id($this->session->userdata("purchase_id"))
                ->transaction_date(date('Y-m-d'))
                ->warehouse($this->_warehouse_id)
                ->type('PO')
                ->supplier_customer($Purchase_comp_Ins['vendor_id'])
                ->remarks('Purchase Order to Supplier')
                ->balance($Purchase_comp_Ins['grand_total'])
                ->log();
        // end log

        for ($i = 0; $i < count($item_id); $i++) {

            $purchase_data = array(
                'item_id' => $item_id[$i],
                'purchase_id' => $this->session->userdata("purchase_id"),
                'purchase_qty' => $quantity[$i],
                'purchase_amount' => $purchase_amount[$i],
                'purchase_rate' => $rates[$i]
            );
             
            if($detail_ids[$i]){
               $where = array('purchase_detail_id' => $detail_ids[$i]);
               $datail_entry = $this->Main_model->update_record('purchase_details', $purchase_data, $where);
            } else {
               $datail_entry = $this->Main_model->add_record('purchase_details', $purchase_data);
            }

            // log details
            // $this->logger
            //         ->item($purchase_data['item_id'])
            //         ->user($user_id)
            //         ->user_name($this->_user_name)
            //         ->transaction_id($purchase_data['purchase_id'])
            //         ->transaction_date(date('Y-m-d'))
            //         ->warehouse($this->_warehouse_id)
            //         ->type('PO')
            //         ->supplier_customer($Purchase_comp_Ins['vendor_id'])
            //         ->remarks('Purchase Order Items from Supplier')
            //         ->balance($purchase_data['purchase_amount'])
            //         ->stock_in($purchase_data['purchase_qty'])
            //         ->quantity($purchase_data['purchase_qty'])
            //         ->log();
            // end log details 
        } 


        //if ($datail_entry) {
            $this->session->set_flashdata('success', 'Record Saved Successfully!');
            redirect(Base_url() . 'index.php/purchase/show/' . $this->session->userdata("purchase_id") . '');
        // } else {
        //     $this->session->set_flashdata('warning', 'No Changes or Check Again!');
        //     redirect(Base_url() . 'index.php/Purchase/purchase_history');
        // } 
    }

    // Purchase History
    public function listings()
    {
        $this->header($title = 'Purchase History');
        $data['purchase'] = $this->Main_model->select_purchases();
        $this->load->view('purchase/listings', $data);
        $this->footer();
    }

    // Show single Purchase Invoice details
    public function show()
    {
        $id = $this->uri->segment(3);
        $data['history'] = $this->Main_model->get_purchaseHistory($id);

        $sql = $this->db->query("select * from purchase as p,vendor as v, warehouses as w where purchase_id=$id AND p.vendor_id =v.vendor_id and p.warehouse_id = w.warehouse_id");
        $data['amount'] = $sql->row();
   
        $this->header($title = "Invoice");
        $this->load->view('purchase/show', $data);
        $this->footer();
    }


    // Show single Purchase Invoice details
    public function invoice_print()
    {
        $id = $this->uri->segment(3);
        $data['history'] = $this->Main_model->get_purchaseHistory($id);

        $sql = $this->db->query("select * from purchase as p,vendor as v, warehouses as w where purchase_id=$id AND p.vendor_id =v.vendor_id and p.warehouse_id = w.warehouse_id");
        $data['amount'] = $sql->row();
   
        $this->header($title = "Invoice");
        $this->load->view('purchase/print', $data);
        $this->footer();
    }
    // Take Payments if due
    public function take_payments()
    {
        $id = $this->input->post('id');
        $p_no = $this->input->post('p_no');

        if ($id == 2) {
            $query = $this->db->query("select grand_total, due_amount from purchase_company where purchase_no = $p_no")->row();
            $grand = $query->grand_total;
            $due = $query->due_amount;
            $update = $this->db->query("update purchase_company set due_amount = '0.00', grand_total = $grand + $due where purchase_no = $p_no");
            $data = '';
            if ($update) {
                $data = array("status" => 1, "confirm" => "Record Updated");
            }
            json_encode($data);
 
        }

    }

}