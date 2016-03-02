<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:02 PM
 */

class ProposeProject extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("project_model");
        $this->load->model("skillset_model");
    }
    function index(){
        $data = array(
            "page_javascript" => "assets/js/proposeproject_js.php",
        );
        $this->load->view('proposeproject_view', $data);
        //session_destroy();
    }


    function get_project_nature_list_control(){ echo $this->project_model->get_project_nature_list(); }
    function add_project_draft_control(){ echo $this->project_model->add_project_draft(); }
    function get_project_heads_control(){ echo $this->project_model->get_project_heads(); }
    function get_general_expenses_control(){ echo $this->budget_model->get_general_expenses(); }
    function get_equipment_expenses_control(){ echo $this->budget_model->get_equipment_expenses(); }
    function search_equipment_price_control(){ echo $this->budget_model->search_equipment_price(); }
    function get_recommendations_control(){ echo $this->employee_model->get_recommendations(); }
    function get_skillsets_control(){ echo $this->skillset_model->get_skillsets(); }

}