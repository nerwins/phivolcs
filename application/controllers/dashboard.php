<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/15/2016
 * Time: 7:13 PM
 */

class Dashboard extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("employee_model");
        $this->load->model("project_model");
        $this->load->model("inventory_model");
        $this->load->model("equipment_model");
    }
    function index(){
        $data = array(
            "page_javascript" => "assets/js/dashboard_js.php",
        );
        $this->load->view('dashboard_view', $data);
    }

    function get_projects_control(){ echo $this->project_model->get_projects(); }
    function get_projects_status_control(){ echo $this->project_model->get_projects_status(); }
    function get_tasks_status_control(){ echo $this->project_model->get_tasks_status(); }
    function get_member_tasks_status_control(){ echo $this->project_model->get_member_tasks_status(); }
    function get_projects_calendar_control(){ echo $this->project_model->get_projects_calendar(); }
    function get_project_inventory_control(){ echo $this->inventory_model->get_project_inventory(); }
    function get_project_list_dropdown_control(){ echo $this->project_model->get_project_list_dropdown(); }
    function get_inventory_list_dropdown_control(){ echo $this->inventory_model->get_inventory_list_dropdown(); }
    function get_equipment_tracking_list_control(){ echo $this->equipment_model->get_equipment_tracking_list(); }
}