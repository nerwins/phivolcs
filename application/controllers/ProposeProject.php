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


}