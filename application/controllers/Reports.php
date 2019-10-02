<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Reports extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Check if user is logged in or id exists in session
        $this->checkUserSession();
    }

    //Purchase Report  Form
    public function purchase()
    {
        $data['items'] = $this->Main_model->select('item');        
        $this->header($title = 'Purchase Report');
        $this->load->view('reports/purchase',$data);
        $this->footer();

    }
     // Purchase Report Details
    public function purchaseReportOld()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));
        $data['purchases'] = $this->Main_model->purchases($start_date1,$end_date1);
//echo "<pre>";print_r($data['purchases']);exit;       
	   $data['start'] = $start_date;
        $data['end'] = $end_date;
        $data['items'] = $this->Main_model->select('item');
        $this->header();
        $this->load->view('reports/purchase',$data);
        $this->footer();
    }
	function purchaseReport(){
		$start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

        $invoice = $this->Main_model->get_invoice_by_date1($start_date1, $end_date1);
               //echo "<pre>";print_r($invoice);exit;
        if (!empty($invoice)) {
            $this->bps_table();
            foreach ($invoice as $v_invoice) {
                $data['invoice_details'][$v_invoice->purchase_id] = $this->Main_model->p_detail(array('purchase_id' => $v_invoice->purchase_id));
                $data['order'][] = $v_invoice;
            }
        }

       // echo "<pre>";print_r($data);exit;
        //$data['purchases'] = $this->Main_model->getSales($start_date1,$end_date1);
        $data['start'] = $start_date;
        $data['end'] = $end_date;
        $data['items'] = $this->Main_model->select('item');
        $this->header();
        //print_r($data);
        $this->load->view('reports/p_report',$data);
        $this->footer();
	}

    // Sales Report Form
    public function sales_report()
    {
        $data['items'] = $this->Main_model->select('item');
        $this->header($title = 'Sales Report');
        $this->load->view('reports/sales_report',$data);
        $this->footer();

    }

    public function bps_table()
    {
       $this->Main_model->bps_table('sales_detail','sales_id');
    }
    // Get Sales Report Details
    public function salesReport()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

        $invoice = $this->Main_model->get_invoice_by_date($start_date1, $end_date1);
               //echo "<pre>";print_r($invoice);exit;
        if (!empty($invoice)) {
            $this->bps_table();
            foreach ($invoice as $v_invoice) {
                $data['invoice_details'][$v_invoice->invoice_no] = $this->Main_model->sales_detail(array('sales_no' => $v_invoice->sales_no));
                $data['order'][] = $v_invoice;
            }
        }

       // echo "<pre>";print_r($data);exit;
        //$data['purchases'] = $this->Main_model->getSales($start_date1,$end_date1);
        $data['start'] = $start_date;
        $data['end'] = $end_date;
        $data['items'] = $this->Main_model->select('item');
        $this->header();
        //print_r($data);
        $this->load->view('reports/sales_report',$data);
        $this->footer();
    }

    public function stock_summary(){
        $data['items'] = $this->General->fetch_CoustomQuery("SELECT s.item_id, i.item_name, SUM(s.stock_qty) as qty, s.stock_rate ,SUM(s.stock_qty * s.stock_rate) as total FROM stock as s, item as i where s.item_id = i.item_id Group by s.item_id ");
        
        $this->header();
        $this->load->view('reports/inventory_summary', $data);
        $this->footer();   
    }

    public function stock_level(){
        $data['items'] = $this->General->fetch_CoustomQuery("SELECT s.item_id, i.item_name, SUM(s.stock_qty) as qty, s.stock_rate , i.stock_limit FROM stock as s, item as i where s.item_id = i.item_id AND s.stock_qty < i.stock_limit Group by s.item_id ");
        
        $this->header();
        $this->load->view('reports/stock_level', $data);
        $this->footer();   
    }

}