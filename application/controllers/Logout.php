<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/18/2016
 * Time: 7:40 PM
 */

class Logout extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    function index(){
        $data = array(
            "page_javascript" => "assets/js/login_js.php",
        );
        $this->load->view('login_view', $data);
        session_destroy();
    }
}