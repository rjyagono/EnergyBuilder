<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class dashboard
 *
 * @property CI_Session session
 * @property user User
 * @property General General
 * @property Menus menus
 * @property Main_model Main_model
 */
class MY_Controller extends CI_Controller
{
    var $savePermission;

    var $editPermission;

    var $deletePermission;

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        //Load Models.............
        $this->load->model('Menus');
        $this->load->model('General');
        $this->load->model('User');
        $this->load->model('StockTransfer');
        $this->load->model('PurchaseOrder');
        $this->load->model('Receiving');
        $this->load->model('Main_model');
        $this->load->model('Warehouse');
        
        $this->load->helper("url");
        $this->load->library("pagination");
        $this->load->library('ciqrcode');
        $this->load->library('logger');

        $this->_warehouse_id = $this->session->userdata('warehouse_id');
        $this->_user_id = $this->session->userdata('user_id');
        $this->_user_name = $this->session->userdata('username');

        defined('STATUS_DRAFT') OR define('STATUS_DRAFT', 1001);
        defined('STATUS_RECEIVED') OR define('STATUS_RECEIVED', 1002);
        defined('STATUS_PARTIAL') OR define('STATUS_PARTIAL', 1003);
        defined('STATUS_ISSUED') OR define('STATUS_ISSUED', 1004);
        defined('STATUS_INTRANSIT') OR define('STATUS_INTRANSIT', 1005);
        defined('STATUS_TRANSFERED') OR define('STATUS_TRANSFERED', 1006);

    }

    /*
     * check sessions user data if it exists,
     * it will go to the function requested
     * otherwise it will redirect to login*/
    public function checkUserSession(){
        if (!$this->session->userdata('user_id')) {
            redirect(base_url() . 'index.php/Users/login');
        }
    }

    //Header for Applications...................................
    public function header($title = '')
    {

        $data['parent_nav'] = $this->Menus->fetch_parent_navi();

        $data['My_Controller'] = $this;
        $data['company'] = $this->db->get_where('company_information', array('id' => 1))->row();
        $data['title'] = $data['company']->name;
        $data['title'] = $data['company']->name;
        $data['title'] = $data['company']->name;
        $data['content'] = "";

        $data['users'] = $this->General->fetch_CoustomQuery("SELECT uu.USER_ID, uu.logged_in, uu.CREATED_DATE,
                    uu.USER_NAME,uu.USER_ID, ug.GROUP_NAME,ug.GROUP_ID, uu.IS_ACTIVE FROM usr_group  as ug,
                    usr_user as uu
                   
                    WHERE ug.GROUP_ID	= uu.GROUP_ID");

        $data['content'] .= $this->load->view('members_table_view', $data, TRUE);
        $data['ajax_url'] = base_url() . 'members_online/';
        $this->load->view('_template/header', $data);


    }

    //main dashboard (Main COntent)
    public function main_content()
    {
        $month = date('m');
        $today = date('Y-m-d');

        $data['total_users'] = $this->General->count_all('usr_user');
        $data['active_users'] = $this->General->active_users();
        $data['total_employees'] = $this->General->count_all('employee_profile');
        $data['inactive_users'] = $this->General->inactive_users();
        $data['users_list'] = $this->User->usersList();
        $data['today_invoices'] = $this->Main_model->today_invoices();
        $data['thisMonth_invoices'] = $this->Main_model->thisMonth_invoices();
        $data['today_sales'] = $this->Main_model->daily_dash_board_sales($today);
        $data['month_sales'] = $this->Main_model->daily_dash_board_sales($month);
        $data['due_amounts'] = $this->Main_model->recent_purchases();
        $data["daily_st"] = $this->Main_model->get_daily_stock();
        $data['topsales'] = $this->Main_model->topsales();
        $data['topSalesYear'] = $this->Main_model->topSalesYear();
        $data['below_stock_level'] = $this->Main_model->belowStockLevel();
        $data['total_stocks_on_hand'] = $this->Main_model->StockOnHand();

        $this->load->view('_template/main', $data);
    }

    // Footer for Application
    public function footer()
    {

        $this->load->view('_template/footer');

    }

    //Fetch child Menus for sidebar by Menu Id
    public function fetchsidebar_childMenuById($child_id)
    {


        if ($this->session->userdata('group_id') == 1) {

            $query = $this->db->query("SELECT * FROM usr_menu WHERE PARENT_ID =$child_id AND SHOW_IN_MENU = 1 ORDER BY SORT_ORDER ASC");

        }


        if ($this->session->userdata('group_id') != 1) {

            $group = $this->session->userdata('group_id');

            $query = $this->db->query("SELECT * FROM usr_menu AS UM , usr_permission UP

                                        WHERE

                                        UM.MENU_ID = UP.MENU_ID

                                        AND 

                                        UP.PER_SELECT =1 

                                        AND

                                        UP.GROUP_ID = $group

                                        AND

                                        UM.PARENT_ID =$child_id AND SHOW_IN_MENU = 1 ORDER BY SORT_ORDER ASC");

        }


        return $query->result();


    }

    //SET SAVE, DELETE, UPDATE, PERMISSIONS FOR PAGES.........................
    public function Getsave_up_delPermissions()
    {


        $menu_id = $this->session->userdata("MENU_ID");

        if (!empty($menu_id) && $this->session->userdata("group_id") != 1) {

            $group_id = $this->session->userdata("group_id");

            $permissionResult = $this->General->fetch_CoustomQuery("SELECT * FROM `usr_permission`

												  WHERE GROUP_ID=$group_id AND 

												  MENU_ID=$menu_id");

            foreach ($permissionResult as $permissionResults) {


                //SET SAVE BUTTON PERMISSION...............................................................

                if ($permissionResults->PER_INSERT == 1) {


                    $this->savePermission = "<input type='submit' id='add-invoice' class='btn btn-primary' name='save' value='Process Saving'>";


                } elseif ($permissionResults->PER_INSERT == 0) {


                    $this->savePermission = "<input type='button' value='Restricted' class='btn btn-warning' >";


                }


                //SET UPDATE BUTTON PERMISSION...............................................................

                if ($permissionResults->PER_UPDATE == 1) {


                    $this->editPermission = "";


                } elseif ($permissionResults->PER_UPDATE == 0) {


                    $this->editPermission = "style='display:none;'";


                }


                //SET DELETE BUTTON PERMISSION...............................................................

                if ($permissionResults->PER_DELETE == 1) {


                    $this->deletePermission = "";


                } elseif ($permissionResults->PER_DELETE == 0) {


                    $this->deletePermission = "style='display:none;'";


                }


            }


        } elseif ($this->session->userdata("group_id") == 1) {


            $this->savePermission = "<input type='submit' value='save' class='btn btn-success' >";

            $this->editPermission = "";

            $this->deletePermission = "";


        }//End Condition......


    }


}


?>