<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 2/23/2016
 * Time: 11:13 AM
 */

class Nature_model extends CI_Model {
	function __construct() {
        parent::__construct();
    }

    function get_nature_list_for_dropdown(){
    	$this->db->select('id, name');
    	$query = $this->db->get('project_nature');
    	if ($query->num_rows() > 0) {
    		$natures = array();
    		foreach ($query->result() as $row)
            {
            	$nature[0] = $row->id;
            	$nature[1] = $row->name;
            	array_push($natures,$nature);
            }
            return json_encode($natures);
    	}else
    		return "error";
    }

    function get_nature_list(){
        $type = $this->input->get('type');
        $id = $this->input->get('id');
        $this->db->select('id, name, description');
        $skillsets = array();
        if ($type == 2) {
            $this->db->where('id', $id);

            $query = "SELECT `id_skillset` FROM `project_nature_has_skillset` where `pid`=? ";
            $result = $this->db->query($query, array($id));
            if ($result->num_rows() > 0) {
               
            foreach ($result->result() as $row)
                {
                    array_push($skillsets,$row->id_skillset);
                }
            }
        }
        $query = $this->db->get('project_nature');
        if ($query->num_rows() > 0) {
            $natures = array();
            foreach ($query->result() as $row)
            {
                $nature[0] = $row->id;
                $nature[1] = $row->name;
                $nature[2] = $row->description;
                array_push($natures,$nature);
            }
                $natureskill = array();
            if ($type == 2) {
                array_push($natureskill,$natures,$skillsets);
            }
            else {
                array_push($natureskill,$natures);
            }
            return json_encode($natureskill);
        }else
            return "error";
    }

    function update_nature(){
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $desc = $this->input->post('description');
        $type = $this->input->post('type');
        $skills = $this->input->post('skills');
        
        if(!$this->check_existing_nature($id,$name)) {
            $data = array(
                'name' => $name,
                'description' => $desc
            );
            if ($type == 0) {
                $this->db->insert('project_nature', $data);
                $inserted_id = $this->db->insert_id();
                for ($x = 0; $x < count($skills); $x++) {
                    $data2 = array(
                        'pid' => $inserted_id,
                        'id_skillset' => $skills[$x]
                    );
                    $this->db->insert('project_nature_has_skillset', $data2);
                }
            }
            else {
                $this->db->where('id', $id);
                $this->db->update('project_nature', $data);
                $this->db->delete('project_nature_has_skillset', array('pid' => $id));
                for ($x = 0; $x < count($skills); $x++) {
                    $data2 = array(
                        'pid' => $id,
                        'id_skillset' => $skills[$x]
                    );
                    $this->db->insert('project_nature_has_skillset', $data2);
                }
            }
            return json_encode("1");
        }else
            return json_encode("Project Nature already exists!");
    }

    function check_existing_nature($id, $name){
        if($id == 0) {
            $query = "SELECT COUNT(*) AS 'exist' FROM `project_nature` AS S WHERE S.`name` = ? ";
            $result = $this->db->query($query, array($name));
        }else{
            $query = "SELECT COUNT(*) AS 'exist' FROM `project_nature` AS S WHERE S.`name` = ? AND S.`id` <> ?";
            $result = $this->db->query($query, array($name,$id));
        }
        $row = $result->row();
        return ($row->exist) > 0? true:false;
    }

    function delete_nature(){
        $id = $this->input->post('id');
        $this->db->delete('project_nature', array('id' => $id));
        $this->db->delete('project_nature_has_skillset', array('pid' => $id));
        return json_encode('1');
    }
}