<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class dashboard
 *
 * @property CI_Session session
 * @property Main_model Main_model
 */
//Extending all Controllers from Core Controller (MY_Controller)
class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Check if user is logged in or id exists in session
        $this->checkUserSession();

        //$cms_db = $this->load->database('forum', TRUE);

        //$imran_db = $this->load->database('imran', TRUE);
        //$this->employee->imran_db = $this->load->database('imran', TRUE);
        $this->session->set_userdata("parent_name", '');
        $this->session->set_userdata("parent_url", '');
    }

    public function testing()
    {
      $data =  $this->Main_model->test();
      print_r($data);
    }

    //index function
    public function index()
    {

        $this->header($title = 'Dashboard');
        if ($this->session->userdata('group_id') == 1) {
            $this->main_content();
        } else {

        }
        $this->footer();

    }


    // Employee Searching from dashboard form via ajax
    public function getSearchData()
    {
        $sql = $this->db->query("select EMP_ID,EMP_NAME,EMP_CELL,EMP_PIC from employee_profile")->result_array();
        echo json_encode($sql);

    }

}


?>