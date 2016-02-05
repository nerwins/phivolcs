<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 02/04/2016
 * Time: 7:41 PM
 */

class ViewProject extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("project_model");
    }
    function index(){
    	$data = array(
            "page_javascript" => "assets/js/viewproject_js.php",
        );
        $this->load->view('viewproject_view', $data);
    }

    function get_project_details_control() {  echo $this->project_model->get_project_details(); }
}