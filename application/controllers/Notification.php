<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 2/25/2016
 * Time: 7:34 PM
 */

class Notification extends CI_Controller {
	function __construct() {
		parent::__construct();
        $this->load->database();
        $this->load->model("notification_model");
	}
	function index(){
		$data = array(
            "page_javascript" => "assets/js/notification_js.php",
        );
        $this->load->view('notification_view', $data);
	}

	function get_notifications_control(){ echo $this->notification_model->get_notifications(); }
	function get_notifications_header_control(){ echo $this->notification_model->get_notifications_header();}
	function get_notifications_unread_count_control(){ echo $this->notification_model->get_notifications_unread_count();}
	function markallread_notification_control(){ echo $this->notification_model->markallread_notification();}
	function markread_notification_control(){ echo $this->notification_model->read_notification();}
}