<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Vendor extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Check if user is logged in or id exists in session
        $this->checkUserSession();
    }

    // Vendor Add Form
    public function add_vendor()
    {
        $this->header($title = 'Add New Vendor');

        $this->load->view('vendor/add_vendor');

        $this->footer();

    }

    // Get Vendor Table
    public function vend_index()
    {
        $this->Main_model->bps_table('vendor', 'vendor_id');

    }

    // List of Vendors
    public function list_vendors()
    {
        $this->vend_index();
        //$dat = array("company " => " company.company_id  = vendor.company_id");
        $data['vendor'] = $this->Main_model->select('vendor');
        //$data['company'] = $this->Main_model->select('company');
        $this->header($title = 'Vendors List');
        $this->load->view('vendor/list_vendor', $data);
        $this->footer();
    }

    // Insert new Vendor to Database
    public function insert_vendor()
    {
        $data = array(
            'vendor_name' => $this->input->post("vendor_name"),
            'vendor_address' => $this->input->post("vendor_address"),
            'phone_no' => $this->input->post("phone_no"),
            'fax_no' => $this->input->post("fax_no"),
            'email' => $this->input->post("email")
        );
        
        $response = $this->Main_model->add_record('vendor', $data);
        if ($response) {
            $this->session->set_flashdata('success', 'Record added Successfully!');
            redirect(base_url() . 'index.php/Vendor/list_vendors');
        }
    }

    // Update Vendor Details
    public function update_vendor()
    {
        $comp_id = $this->input->post('cid');

        $comp_info = array(
            'vendor_name' => $this->input->post('vendor_name'),
            'vendor_address' => $this->input->post("vendor_address"),
            'phone_no' => $this->input->post('phone_no'),
            'fax_no' => $this->input->post('fax_no'),
            'email' => $this->input->post('email')
        );

        $where = array('vendor_id' => $comp_id);
     
        $response = $this->Main_model->update_record('vendor', $comp_info, $where);
        //if ($response) {
            $this->session->set_flashdata('info', 'Record Updated Successfully!');
            redirect(base_url() . 'index.php/Vendor/list_vendors');
        //}
    }


}