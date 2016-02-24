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
}