<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:09 PM
 */

class EquipmentStatus extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("equipment_model");
        $this->load->model("project_model");
    }
    function index(){
        $data = array(
            "page_javascript" => "assets/js/equipmentstatus_js.php",
        );
        $this->load->view('equipmentstatus_view', $data);
    }

    function get_equipment_status_control(){ echo $this->equipment_model->get_equipment_status(); }
    function get_project_list_dropdown_control(){ echo $this->project_model->get_project_list_dropdown(); }
    function get_equipment_list_dropdown_control(){ echo $this->equipment_model->get_equipment_list_dropdown(); }
}