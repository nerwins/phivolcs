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

    function get_equipment_status(){
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
}