<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/15/2016
 * Time: 7:13 PM
 */

class Dashboard extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->database();
        //$this->load->model("login_model");
    }
    function index(){
        $data = array(
            "page_javascript" => "assets/js/dashboard_js.php",
        );
        $this->load->view('dashboard_view', $data);
    }
}