<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Item extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Check if user is logged in or id exists in session
        $this->checkUserSession();
    }

    // Create Barcodes Form
    public function create_barcodes()
    {
        $data['items'] = $this->Main_model->item_cat();
        $this->load->view('item/print_barcodes', $data);
    }

    // Getting Specific Item by Id
    public function get_items()
    {
        $item_id = $this->input->post('id');
        $data['items'] = $this->Main_model->items($item_id);
        $this->load->view('item/pop_item', $data);

    }

    // Getting data for barcodes
    public function get_data_for_barcodes()
    {
        $item_id = $this->uri->segment(3);
        $count = $this->uri->segment(4);
        $this->load->model('Main_model');

        $where = array('item_id' => $item_id);
        $data = $this->Main_model->get_purchased($item_id);
        if ($item_id != 0) {
            $output = '';
            $output .= '<tr id="entry_row_' . $count . '">';
            $output .= '<td id="serial_' . $count . '">' . $count . '</td>';
            $output .= '<td><input type="hidden" name="item_id" value="' . $data->item_id . '"> ' . $data->item_id . '</td>';
            $output .= '<input type="hidden" name="category_id[]" value="' . $data->category_id . '">';
            $output .= '<td>' . $data->item_name . '</td>';
            $output .= '<td><div id="spinner4">

     <input type="text" name="quantity" tabindex="1"  id="quantity_' . $count . '" size="2" value="1" class="form-control col-lg-2">

                                </div>
                            </div></td>';
            $output .= '<td><input type="text" class="form-control"  name="unit_price[]" readonly="readonly" id="unit_price_' . $count . '" size="6" value="' . $data->purchase_rate . '"></td>';
            $output .= '<td>
        <input type="text" name="purchase_amount[]" class="form-control" readonly="readonly" id="single_entry_total_' . $count . '" size="6" value="' . $data->purchase_rate . '">
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

    // Printing Barcodes
    public function printBarcodes()
    {
        $item = $this->input->post('item_id');
        $qty = $this->input->post('quantity');
        $data['barcodes'] = $this->db->query("select * from item where item_id = $item")->result();
        $data['quantity'] = $qty;
        $data['products'] = $this->db->query("SELECT * FROM stock AS s, item AS i WHERE  s.stock_qty > 0 AND i.`item_id` = s.`item_id`")->result();
        $data['items'] = $this->Main_model->item_cat();
        $this->load->view('item/print_barcodesItems', $data);

    }

    // Generate Barcodes
    public function generate_barcodes()
    {
        $data['products'] = $this->db->query("SELECT * FROM stock AS s, item AS i WHERE  s.stock_qty > 0 AND i.`item_id` = s.`item_id`")->result();
        $data['items'] = $this->Main_model->item_cat();
        $this->load->view('item/print_barcodesItems', $data);
    }

    // Get Category wise Items
    public function get_catItems()
    {
        $cat = $this->input->post('category');
        $data['items'] = $this->Main_model->item_cat($cat);
        $this->load->view('item/print_barcodes', $data);

    }

    // List Items
    public function list_items()
    {

        $data['items'] = $this->Main_model->item_cat();
        $data['category'] = $this->Main_model->select('category');

        $where = array('type' => 'units');
        $data['units'] = $this->Main_model->single_row('settings', $where);
        $data['units'] = explode (",", $data['units']->value); 

        $this->header();
        $this->load->view('item/list_items', $data);
        $this->footer();

    }

    public function price_history(){
        $item_id = $this->uri->segment(3);
        $data['items'] = $this->db->query("SELECT l.transaction_date, v.vendor_name, l.unit_cost, l.selling_price FROM logger as l Join vendor as v ON v.vendor_id = l.supplier_customer_id where item_id = $item_id")->result();


        // echo $this->db->last_query();
        // echo $this->db->insert_id();
        // exit;
        $this->header();
        $this->load->view('item/price_history', $data);
        $this->footer();    
    }

    // Inserting new Item to Database
    public function insert_item()
    {
        $item_name = $this->input->post('item_name');
        $description = $this->input->post('description');
        $color = $this->input->post('color');
        $size = $this->input->post('size');
        $unit = $this->input->post('unit');
        $article_no = $this->input->post('article_no');
        $qrCode = $this->input->post('qrCode');
        $purchase_rate = $this->input->post('purchase_rate');
        $stock_qty = $this->input->post('stock_qty');
        $stock_rate = $this->input->post('stock_rate');
        $stock_limit = $this->input->post('stock_limit') ?: 0;
        
        $this->load->model('Main_model');
        $result = $this->Main_model->select_same($item_name, $color, $size, $article_no);
        if ($result) {
            $this->session->set_flashdata('warning', 'Product already Exists. Please try something different.');
            redirect(base_url() . 'index.php/Item/list_items');
        } else {
            if ($qrCode == '') {
                $abc = "SELECT LPAD(IFNULL(MAX(`item_id`),'1000')+1,9,0) AS qrcode FROM `item`";
                $query = $this->db->query($abc);
                $qrCode = $query->row();
                $id = $qrCode->qrcode;
            } else {

                $id = $this->input->post('qrCode');
            }
            
            if($purchase_rate == ''){
                $purchase_rate = 0;
            }
            if($stock_qty == ''){
                $stock_qty = 0;
            }
            if($stock_rate == ''){
                $stock_rate = 0;
            }
            $data = array(
                'item_id' => $id,
                'item_name' => $this->input->post("item_name"),
                'description' => $this->input->post("description"),
                'size' => $this->input->post("size"),
                'color' => $this->input->post("color"),
                'flag' => 1,
                'article_no' => $this->input->post("article_no"),
                'category_id' => $this->input->post("category_id"),
                'purchase_rate' => $purchase_rate,
                'unit' => $unit,
                'stock_rate' => $stock_rate,
                'stock_limit' => $stock_limit
            );
            $data2 = array(
                'item_id' => $id,
                'category_id' => $this->input->post('category_id'),
                'stock_qty' => $stock_qty,
                'purchase_rate' => $purchase_rate,
                'stock_rate' => $stock_rate,
                'warehouse_id' => $this->session->userdata('warehouse_id'),
                'user_id' => $this->session->userdata('user_id')
            );
            $response = $this->Main_model->add_record('item', $data);
            $stock = $this->Main_model->add_record('stock', $data2);

            // log create
                $this->logger
                    ->user($this->_user_id)
                    ->user_name($this->_user_name)
                    ->transaction_date(date('Y-m-d'))
                    ->warehouse($this->_warehouse_id)
                    ->type('Item')
                    ->remarks('Added initial qty')
                    ->stock_in($stock_qty)
                    ->quantity($stock_qty)
                    ->log();
            // end log

            if ($stock) {
                // $barc = $id;
                // $params['data'] = $barc;
                // $params['level'] = 'H';
                // $params['size'] = 10;
                //$params['savename'] = FCPATH . 'uploads/images/qrcodes/' . $id . '.png';
                //$params = $this->ciqrcode->generate($params);

                $this->session->set_flashdata('success', 'Item details have been saved.');
                redirect(base_url() . 'index.php/Item/list_items');

            }
        }
    }

    // Update existing item details
    public function update_item()
    {
        $custid = $this->input->post('cid');
        $category_id = $this->input->post('category_id');
        $cust_info = array(
            'item_name' => $this->input->post('item_name'),
            'description' => $this->input->post("description"),
            'size' => $this->input->post('size'),
            'purchase_rate' => $this->input->post('purchase_rate'),
            'color' => $this->input->post('color'),
            'category_id' => $this->input->post('category_id'),
            'article_no' => $this->input->post("article_no"),
            'unit' => $this->input->post("unit"),
            'stock_limit' => ($this->input->post("stock_limit") ?: 0)
        );
        $where = array('item_id' => $custid);
        $this->Main_model->update_record('item', $cust_info, $where);

        $cat_data = array('category_id' => $category_id);
        $this->Main_model->update_record('stock', $cat_data, $where);

        // log create
            $this->logger
                ->user($this->_user_id)
                ->user_name($this->_user_name)
                ->transaction_date(date('Y-m-d'))
                ->warehouse($this->_warehouse_id)
                ->type('Item')
                ->remarks('Update item')
                ->log();
        // end log

        $this->session->set_flashdata('success', 'Item details have been updated.');
        redirect(base_url() . 'index.php/Item/list_items');
    }

}