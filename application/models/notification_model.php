<?php
/**
 * Source Types redirects when clicked:
 * 1- viewproject
 * 2- task
 *
 *
 */



class Notification_model extends CI_Model {
	function __construct() {
        parent::__construct();
    }

    function get_notifications_unread_count(){
    	$id = $_SESSION['id'];
    	$query = "SELECT COUNT(*) AS 'unreadcnt' 
                FROM notification_users
                WHERE `isread` = 0 AND `receiverid` = ".$id;
        $result = $this->db->query($query);
    	if ($result->num_rows() > 0) {
    		$row = $result->row();
            return $row->unreadcnt;
    	} else
    		return 0;
    }

    function get_notifications_header(){
        $id = $_SESSION['id'];
       
        $query = "SELECT NU.`id`, N.`sourcetype`, N.`sourceid`, N.`datetime`, N.`message`, NU.`isread`
                FROM notification as N, notification_users as NU
                WHERE N.`id` = NU.`notificationid` AND NU.`receiverid` = ".$id." ORDER BY N.`datetime` DESC
                LIMIT 3";
        $result = $this->db->query($query);
        $count = $this->notification_model->get_notifications_unread_count();
        $notification = "";
        if ($count > 0) {
            $notification .= "<li><a href='#' onclick='markallread();' style='text-align:right; cursor:pointer;'>Mark All as Read</a><li>";
        }       
        $notification .= "<div class='notify-arrow notify-arrow-blue'></div>
                          <li>
                            <p class='blue' id='countstr'>You have ".$count." new notifications.</p>
                          </li>";
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row)
            {
                $sourcestr = "";
                if ($row->sourcetype == 1) {
                    $sourcestr .= "viewproject?id=".$row->sourceid;
                }
                else if ($row->sourcetype == 2) {
                    $sourcestr .= "task?id=".$row->sourceid;
                }

                $color_read = "";
                if ($row->isread == 0) {
                    $color_read .= "style='background-color:#FFFACD;'";
                }
                $notification .= "<li ".$color_read.">
                                    <a href='".$sourcestr."'>
                                        <span class='label label-primary'><i class='icon_info'></i></span>
                                        ".$row->message."
                                        <span class='small italic pull-right'>".$row->datetime."</span>
                                    </a>
                                  </li>";
            }
            $notification .= "<li>
                                <a href='notification'>See all notifications</a>
                              </li>";
        }
        return $notification;
    }

    function get_notifications(){
        $id = $_SESSION['id'];
        $datefrom = $this->input->get('datefrom');
        $dateto = $this->input->get('dateto') ." 23:59:59";

        $wherestr = "";
        if ($datefrom != "") {
            $wherestr .= " AND N.`datetime` >= ".$datefrom;
        }
        if ($dateto != "") {
            $wherestr .= " AND N.`datetime` <= ".$dateto;
        }
        
        $query = "SELECT NU.`id`, N.`sourcetype`, N.`sourceid`, N.`datetime`, N.`message`, NU.`isread`
                FROM notification as N, notification_users as NU
                WHERE N.`id` = NU.`notificationid` ".$wherestr." AND NU.`receiverid` = ".$id." ORDER BY N.`datetime` DESC";
        $result = $this->db->query($query);

        if ($result->num_rows() > 0) {
            $notification = array();
            $i = 0;
            foreach ($result->result() as $row)
            {
                $notification[$i]['sourcetype'] = $row->sourcetype;
                $notification[$i]['sourceid'] = $row->sourceid;
                $notification[$i]['datetime'] = $row->datetime;
                $notification[$i]['message'] = $row->message;
                $notification[$i]['isread'] = $row->isread;
                $i++;
            }
            return json_encode($notification);
        }else
            return "error";
    }

    function markallread_notification(){
        $id = $_SESSION['id'];
        $data = array(
            'isread' => "1",
            'datetimeread' => NOW()
        );
        $this->db->where('receiverid', $id);
        $this->db->update('notification_users',$data);
        return;
    }

    function read_notification(){
        $id = $this->input->post('id');
        $data = array(
            'isread' => "1",
            'datetimeread' => "NOW()"
        );
        //for ($x = 0; $x < count($id); $x++) {
            $this->db->where('id', $id);
            $this->db->update('notification_users',$data);
        //}
        return;
    }

    function new_notification($empid, $message, $type, $typeid, $receivers){        
        $data = array(
            'empid' => $empid,
            'message' => $message,
            'datetime' => 'NOW()',
            'sourcetype' => $type,
            'sourceid' => $typeid
        );
        $this->db->insert('notification', $data); 
        $inserted_id = $this->db->insert_id();

        for ($x = 0; $x < count($receivers); $x++) {
            $data2 = array(
                'notificationid' => $inserted_id,
                'receiverid' => $receivers[$x]
            );
            $this->db->insert('notification_users', $data2);
        }
    }
}