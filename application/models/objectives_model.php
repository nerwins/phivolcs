<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 2/18/2016
 * Time: 10:17 AM
 */

class Objectives_model extends CI_Model {
	function __construct() {
        parent::__construct();
    }
    function update_objective($name,$id){
    	$data = array(
                'name' => $name
            );
    	$this->db->where('id', $id);
        $this->db->update('objectives', $data);
    }
    function delete_objective($id){
    	$this->db->delete('objectives', array('id' => $id));
    }
    function add_objective($name, $projectid){
    	$data = array(
			'name' => $name,
			'projectid' => $projectid
		);
    	$this->db->insert('objectives', $data);
    }
}