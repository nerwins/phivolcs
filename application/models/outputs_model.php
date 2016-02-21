<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 2/18/2016
 * Time: 08:20 AM
 */

class Outputs_model extends CI_Model {
	function __construct() {
        parent::__construct();
    }
	function get_project_outputs($id){
        $this->db->select("id,expected,pindicator");
        $this->db->where('projectid', $id); 
        $query = $this->db->get('output');
        if($query->num_rows() > 0){
            $outputs = array();
            foreach ($query->result() as $row){
                $output[0] = $row->id;
                $output[1] = $row->expected;
                $output[2] = $row->pindicator;
                array_push($outputs,$output);
            }
            return $outputs;
        }else
            return "error";
    }
    function update_output($expected, $pindicator, $id, $projectid = 0){
        $data = array(
                'expected' => $expected,
                'pindicator' => $pindicator
            );
        if($id == 0){
            $data['projectid'] = $projectid;
            $this->db->insert('output', $data);
        }else{
            $this->db->where('id', $id);
            $this->db->update('output', $data);
        }
    }
    function delete_output($id){
        $this->db->delete('output', array('id' => $id));
    }
}