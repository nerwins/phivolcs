<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:01 PM
 */

class ProjectArchive extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("project_model");
    }
    function index(){
        $data = array(
            "page_javascript" => "assets/js/projectarchive_js.php",
        );
        $this->load->view('projectarchive_view', $data);
    }

    function get_project_list_control() {echo $this->project_model->get_project_list(); }
}