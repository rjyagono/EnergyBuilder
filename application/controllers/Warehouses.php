<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Warehouses extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Main_model');
        $this->load->model('Warehouse');

        if ($this->session->userdata('user_id')) {
        } else {
            
            redirect(base_url() . 'index.php/Users/login');

        }
    }

    // Get Vendor Table
    public function warehouse_index()
    {
        $this->Main_model->bps_table('warehouses', 'warehouse_id');

    }

    // List of Vendors
    public function listings()
    {
        $this->warehouse_index();
       
        $data['warehouses'] = $this->Main_model->select('warehouses');

        $this->header($title = 'Warehouse List');
        $this->load->view('warehouse/index', $data);
        $this->footer();
    }

    // Insert new Vendor to Database
    public function insert_warehouse()
    {
        $data = array(
            'warehouse_name' => $this->input->post('warehouse_name'),
            'address' => $this->input->post('address'),
            'phone_no' => $this->input->post('phone_no')

        );

        $response = $this->Main_model->add_record('warehouses', $data);
        if ($response) {
            $this->session->set_flashdata('success', 'Record added Successfully..!');
            redirect(base_url() . 'index.php/warehouses/listings');
        }
    }

    // Update Vendor Details
    public function update_warehouse()
    {
        $id = $this->input->post('wid');

        $data = array(
            'warehouse_name' => $this->input->post('warehouse_name'),
            'address' => $this->input->post('address'),
            'phone_no' => $this->input->post('phone_no')
        );

        $where = array('warehouse_id' => $id);
        $response = $this->Main_model->update_record('warehouses', $data, $where);
        if ($response) {
            $this->session->set_flashdata('update', 'Record Updated Successfully..!');
            redirect(base_url() . 'index.php/warehouses/listings');
        }
    }


}