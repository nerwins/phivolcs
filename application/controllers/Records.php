<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:02 PM
 */

class Records extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("records_model");
    }
    function index(){
        $data = array(
            "page_javascript" => "assets/js/records_js.php",
        );
        $this->load->view('records_view', $data);
    }

    function get_skillset_list_control(){ echo $this->records_model->get_skillset_list(); }
    function get_skillset_detail_control(){ echo $this->records_model->get_skillset_detail(); }
    function update_skillset_detail_control() {echo $this->records_model->update_skillset_detail();}
    function delete_skillset_detail_control() {echo $this->records_model->delete_skillset_detail();}
}