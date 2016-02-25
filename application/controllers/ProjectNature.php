<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:06 PM
 */

class ProjectNature extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("nature_model");
        $this->load->model("skillset_model");
    }
    function index(){
        $data = array(
            "page_javascript" => "assets/js/projectnature_js.php",
        );
        $this->load->view('projectnature_view', $data);
        //session_destroy();s
    }

    function get_nature_list_control(){ echo $this->nature_model->get_nature_list(); }
    function update_nature_control(){ echo $this->nature_model->update_nature(); }
    function delete_nature_control(){ echo $this->nature_model->delete_nature(); }
}