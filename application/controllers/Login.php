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
        session_start();
        $this->load->model("login_model");
    }

    function index(){
        $data = array(
            "page_javascript" => "assets/js/login_js.js",
        );
        $this->load->view('login_view', $data);
        session_destroy();
    }
}