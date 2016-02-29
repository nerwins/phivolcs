<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 2/25/2016
 * Time: 7:34 PM
 */

class AccomplishReport extends CI_Controller {
	function __construct() {
		parent::__construct();
        $this->load->database();
        $this->load->model("project_model");
        $this->load->model("nature_model");
	}
	function index(){
		$data = array(
            "page_javascript" => "assets/js/accomplishreport_js.php",
        );
        $this->load->view('accomplishreport_view', $data);
	}

	function get_accomplished_reports_projects_control(){ echo $this->project_model->get_accomplished_reports_projects(); }
	function get_nature_list_for_dropdown_control() { echo $this->nature_model->get_nature_list_for_dropdown(); }
	function get_project_name_and_heads_for_dropdown_control() {echo $this->project_model->get_project_name_and_heads_for_dropdown(); }
}