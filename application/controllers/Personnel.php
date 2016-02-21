<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:30 PM
 */

class Personnel extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("employee_model");
    }
    function index(){
        $data = array(
            "page_javascript" => "assets/js/personnel_js.php",
        );
        $this->load->view('personnel_view', $data);
    }
    function get_employees_list_control() { echo $this->employee_model->get_employees_list(); }
    function get_projects_and_employees_control() { echo $this->employee_model->get_projects_and_employees(); }
}