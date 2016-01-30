<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/13/2016
 * Time: 6:54 PM
 */

class Login_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function check_username() {
        $username = $this->input->get('username');
        $password = $this->input->get('password');

        $query = "SELECT
                    A.`id`,
                    `password`,
                        CONCAT_WS(' ',E.`firstname`,E.`lastname`) AS 'fullname',
                    E.`position_id` AS 'position',
                    E.`division_id` AS 'division'
                FROM
                    `accounts` AS A
                        LEFT JOIN
                    `employee` AS E ON A.`id` = E.`id`
                WHERE
                    username = ?";
        $result = $this->db->query($query, array($username));
        if ($result->num_rows() > 0) {
            $row = $result->row();
            $dbpassword = $row->password;
            if ($dbpassword == $password) {
                $eid = $row->id;
                $dbfullname = $row->fullname;
                $position = $row->position;
                $division = $row->division;
                $_SESSION['id'] = $eid;
                $_SESSION['fullname'] = $dbfullname;
                $_SESSION['username'] = $username;
                $_SESSION['position'] = $position;
                $_SESSION['division'] = $division;
                return json_encode(array("eid"=>$eid));
            }
            else
                return json_encode("error");
        }
        else
            return json_encode("error");
    }
}