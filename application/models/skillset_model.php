<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/30/2016
 * Time: 4:16 PM
 */

class Skillset_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function get_skillset_list(){
        $searchSkillset = $this->input->get('searchSkillset');
        $whereStr = "";
        if(trim($searchSkillset) != ""){
            $whereStr = " WHERE `name` LIKE '%".$searchSkillset."%' OR `description` LIKE '%".$searchSkillset."%' ";
        }
        $query = "SELECT `id`,`name`,`description` FROM `skillset`" .$whereStr;
        //print_r($query);
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            $skillSetList = array();
            $i = 0;
            foreach ($result->result() as $row)
            {
                $skillSetList[$i][0] = $row->id;
                $skillSetList[$i][1] = $row->name;
                $skillSetList[$i][2] = $row->description;
                $i++;
            }
            return json_encode($skillSetList);
        }else
            return json_encode("error");
    }
    function get_skillset_detail(){
        $id = $this->input->get('id');
        $query = "SELECT `id`,`name`,`description` FROM `skillset` WHERE `id` = ?";
        $result = $this->db->query($query, array($id));
        if ($result->num_rows() > 0) {
            $row = $result->row();
            $skillSetDetail[0] = $row->id;
            $skillSetDetail[1] = $row->name;
            $skillSetDetail[2] = $row->description;
            return json_encode($skillSetDetail);
        }else
            return json_encode("error");
    }
    function update_skillset_detail(){
        $id = $this->input->post('skillID');
        $name = $this->input->post('skillName');
        $desc = $this->input->post('skillDesc');
        if(!$this->check_existing_skillset($id,$name)) {
            $data = array(
                'name' => $name,
                'description' => $desc
            );
            if ($id == 0)
                $this->db->insert('skillset', $data);
            else {
                $this->db->where('id', $id);
                $this->db->update('skillset', $data);
            }
        }else
            return json_encode("error");
    }
    function check_existing_skillset($id, $name){
        if($id == 0) {
            $query = "SELECT COUNT(*) AS 'exist' FROM `skillset` AS S WHERE S.`name` = ? ";
            $result = $this->db->query($query, array($name));
        }else{
            $query = "SELECT COUNT(*) AS 'exist' FROM `skillset` AS S WHERE S.`name` = ? AND S.`id` <> ?";
            $result = $this->db->query($query, array($name,$id));
        }
        $row = $result->row();
        return ($row->exist) > 0? true:false;
    }
    function delete_skillset_detail(){
        $id = $this->input->post('skillID');
        $query = "SELECT CONCAT_WS(' ', `firstname`,`lastname`) AS 'fullname' FROM `employee` where `id` in
                  (SELECT `employeeid` FROM `employee_has_skillset` where `skillsetid`=?);";
        $result = $this->db->query($query, array($id));
        $employeeString = "";
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row)
            {
                $employeeString .= $row->fullname .",";
            }
            $employeeString = rtrim($employeeString, ",");
        }else{
            $this->db->delete('skillset', array('id' => $id));
        }
        return json_encode($employeeString);
    }

    //for autocomplete for propose
    function get_skillsets(){
        
        $query = "SELECT `name` FROM `skillset`";
        //print_r($query);
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            $skillSetList = array();
            foreach ($result->result() as $row)
            {
                $skillSetList[] = $row->name;
            }
            return json_encode($skillSetList);
        }else
            return json_encode("error");
    }
}