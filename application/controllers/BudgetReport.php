<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:30 PM
 */

class BudgetReport extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("project_model");
        $this->load->model("budget_model");
        $this->load->model("nature_model");
    }
    function index(){
        $data = array(
            "page_javascript" => "assets/js/budgetreport_js.php",
        );
        $this->load->view('budgetreport_view', $data);
    }

    function get_project_list_for_budget_report_controller() {echo $this->project_model->get_project_list_for_budget_report(); }
    function get_nature_list_for_dropdown_control() {echo $this->nature_model->get_nature_list_for_dropdown(); }
}