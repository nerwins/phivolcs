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
        $this->load->helper('date');
        $this->load->model("project_model");
        $this->load->model("revisions_model");
        $this->load->model("tasks_model");
        $this->load->model("skillset_model");
        $this->load->model("files_model");
    }
    function index(){
    	$data = array(
            "page_javascript" => "assets/js/viewproject_js.php",
        );
        $this->load->view('viewproject_view', $data);
    }

    function get_project_details_control() {  echo $this->project_model->get_project_details(); }
    function approve_project_control(){ echo $this->project_model->approve_project(); }
    function decline_project_control(){ echo $this->project_model->decline_project(); }

    function approve_revisions_control(){ echo $this->revisions_model->approve_revisions(); }
    function update_revisions_control(){ echo $this->revisions_model->update_revisions(); }

    function get_skillset_from_task_control(){ echo $this->tasks_model->get_skillset_from_task(); }

    function get_skillset_list_control(){ echo $this->skillset_model->get_skillset_list(); }

    function save_file_control(){ echo $this->files_model->save_file(); }
    function get_file_list_control(){ echo $this->files_model->get_file_list(); }
    function delete_file_control(){ echo $this->files_model->delete_file(); }
    function download_file_control(){ echo $this->files_model->download_file(); }
}