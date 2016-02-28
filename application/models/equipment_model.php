<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 2/27/2016
 * Time: 07:22 PM
 */

class Equipment_model extends CI_Model {
	function __construct() {
        parent::__construct();
    }

    function get_equipment_status_old(){
    	$datefrom = $this->input->get('datefrom');
    	$dateto = $this->input->get('dateto') . " 23:59:59";

    	$query = "SELECT 
				    (SELECT `id`
					 FROM `inventory`
					 WHERE `name` = (SELECT `expense`
									 FROM `budget`
									 WHERE `id` = `budgetid`)) 'id',
				    (SELECT `expense`
					 FROM `budget`
					 WHERE `id` = `budgetid`) 'expense',
				    (SELECT 
				            (SELECT `name`
							 FROM `project`
							 WHERE `id` = `projectid`)
					 FROM `task`
					 WHERE `id` = `taskid`) 'project',
				    (SELECT 
				            (SELECT CONCAT(`datefrom`, ' to ', `dateto`)
							 FROM `project`
							 WHERE `id` = `projectid`)
					 FROM `task`
					 WHERE `id` = `taskid`) 'pduration',
				    (SELECT `datefrom`
					 FROM `task`
					 WHERE `id` = `taskid`) 'return',
				     `qty` - `used` 'qty',
				    (SELECT 
				            GROUP_CONCAT((SELECT CONCAT(`lastname`,' ',`firstname`,' ',`middleinitial`)
				                          FROM `employee`
										  WHERE `id` = `empid`))
					 FROM `employee_has_task`
					 WHERE `taskid` = TE.`taskid`) 'members'
				FROM `task_has_equipment` TE
				WHERE `taskid` IN (SELECT `id`
								   FROM `task`
								   WHERE `datefrom` >= ? AND `dateto` <= ?)
				AND `qty` != `used`;";
		$result = $this->db->query($query, array($datefrom,$dateto));
		if ($result->num_rows() > 0) {
			$equipments = array();
			foreach ($result->result() as $row){
				$equipment[0] = $row->id;
				$equipment[1] = $row->expense;
				$equipment[2] = $row->project;
				$equipment[3] = $row->pduration;
				$equipment[4] = $row->return;
				$equipment[5] = $row->qty;
				$equipment[6] = $row->members;
				array_push($equipments,$equipment);
			}
			return json_encode($equipments);
		}else
			return json_encode("error");
    }

    function get_equipment_status(){
    	$equipment = $this->input->get('equipment');
    	$returndate = $this->input->get('returndate');
    	$status = $this->input->get('status');
    	$project = $this->input->get('project');
    	$whereCondition = "";
    	if($equipment != 0){
    		$whereCondition .= " AND B.`id` = " .$equipment ." ";
    	}
    	if($project != 0){
    		$whereCondition .= " AND T.`projectid` = " .$project ." ";
    	}

    	$query ="SELECT 
				    B.`id`, B.`expense`,CASE WHEN THE.`taskid` IS NULL THEN 'In Stock' ELSE 'In Use' END AS 'status'
				FROM
				    `budget` AS B
				LEFT JOIN `task_has_equipment` AS THE ON THE.`budgetid` = B.`id`
				LEFT JOIN `task` AS T ON T.`id` = THE.`taskid`
				WHERE 1=1 ".$whereCondition."
				GROUP BY B.`id`";
		$result = $this->db->query($query);
		//echo $this->db->last_query();
		if ($result->num_rows() > 0) {
			$equipments = array();
			foreach ($result->result() as $row){
				if($status != 0){
					if($status == 1){
						if($row->status == "In Stock")
							array_push($equipments,array($row->id,$row->expense,$row->status));
					}elseif($status == 2){
						if($row->status == "In Use")
							array_push($equipments,array($row->id,$row->expense,$row->status));
					}
				}else
					array_push($equipments,array($row->id,$row->expense,$row->status));
			}
			return json_encode($equipments);
		}else
			return json_encode("error");
    }

    function get_equipment_list_dropdown(){
    	$this->db->select("`id`,CONCAT(`id`,' - ',`expense`) AS `equipment`");
    	$query = $this->db->get('budget');
    	if ($query->num_rows() > 0) {
    		$equipments = array();
    		foreach ($query->result() as $row){
    			$equipment[0] = $row->id;
    			$equipment[1] = $row->equipment;
    			array_push($equipments,$equipment);
    		}
    		return json_encode($equipments);
    	}else
    		return json_encode("error");
    }
}