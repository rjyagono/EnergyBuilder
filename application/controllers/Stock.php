<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Stock extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Check if user is logged in or id exists in session
        $this->checkUserSession();
        $this->Main_model->bps_table('stock', 'stock_no');
    }


    // company detail form

    public function list_stock()
    {
        //$warehouse_id = $this->_warehouse_id;
        //$data['stock'] = $this->Main_model->stock_cat($warehouse_id);
        //$data['category'] = $this->Main_model->select('category');
        $data['warehouses'] = $this->Main_model->select('warehouses');

        $this->header();
        $this->load->view('stock/list_stock', $data);
        $this->footer();

    }

    public function list_stock_json()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $warehouse_id = intval($this->input->get("warehouse_id"));
        $searchValue = $this->input->get('search')['value']; // Search value

        if($warehouse_id == 0){
            $warehouse_id = $this->_warehouse_id;
        }
        

        $data = $this->Main_model->ajax_stock_cat($searchValue, $warehouse_id);
        $data['draw'] = $draw;


      echo json_encode($data);
      exit();    
  }


    public function update_stock()
    {
        error_reporting(E_ALL);
        $stock_id = $this->input->post('stock_no');

        $stock = array(
            'stock_qty' => $this->input->post('stock_qty'),
            'purchase_rate' => $this->input->post('purchase_rate'),
            'stock_rate' => $this->input->post('stock_rate'),
        );
        $where = array('stock_no' => $stock_id);
        $this->load->model('Main_model');
        $response = $this->Main_model->update_record('stock', $stock, $where);
        if ($response) {
            $this->session->set_flashdata('success', '<div class="alert alert-success alert-dismissable">
               <button type="button" class="close" data-dismiss="alert"
                  aria-hidden="true">
                  &times;
               </button>
               <span>Record Updated Successfully..!</span>
            </div>');

        }
        redirect(base_url() . 'index.php/Stock/list_stock');
    }


}