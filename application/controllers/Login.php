<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/13/2016
 * Time: 6:52 PM
 */
class Login extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("login_model");
    }

    function index(){
        $data = array(
            "page_javascript" => "assets/js/login_js.php",
        );
        $this->load->view('login_view', $data);
        session_destroy();
    }
    function check_username_control() {  echo $this->login_model->check_username(); }
}