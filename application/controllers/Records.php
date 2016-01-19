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
        //$this->load->model("login_model");
    }
    function index(){
        $data = array(
            "page_javascript" => "assets/js/records_js.php",
        );
        $this->load->view('records_view', $data);
        //session_destroy();
    }
}