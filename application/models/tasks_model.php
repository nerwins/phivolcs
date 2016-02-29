<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 2/18/2016
 * Time: 08:16 AM
 */

class Tasks_model extends CI_Model {
	function __construct() {
        parent::__construct();
    }
    function get_task_status_count($id,$status){
        $whereString = "";
        if($status == 'pending')
            $whereString = "!";
        $query = "SELECT 
                    COUNT(tasktable.name) 'count'
                FROM
                    (SELECT 
                        t1.`name`,
                            t1.`countemployees` 'c1',
                            t2.`countemployees` 'c2'
                    FROM
                        (SELECT 
                        T.`name` 'name', COUNT(`ET`.`empid`) 'countemployees'
                    FROM
                        task T
                    LEFT JOIN `employee_has_task` ET ON T.`id` = ET.`taskid`
                    WHERE
                        `projectid` = ?
                    GROUP BY T.`id`) t1
                    LEFT JOIN (SELECT 
                        T.`name` 'name', COUNT(`ET`.`empid`) 'countemployees'
                    FROM
                        task T
                    LEFT JOIN `employee_has_task` ET ON T.`id` = ET.`taskid`
                    WHERE
                        `projectid` = ? AND ET.`status` = 1
                    GROUP BY T.`id`) t2 ON t1.`name` = t2.`name`) tasktable
                WHERE
                    tasktable.c1 ".$whereString."= tasktable.c2;";
        $result = $this->db->query($query, array($id,$id));
        if ($result->num_rows() > 0){
            $row = $result->row();
            return $row->count;
        }else
            return 0;
    }
    function get_project_tasks($id,$projectstatus,$empid){
        $this->db->select("`id`,`name`,`milestone_indicator`,`datefrom`,`dateto`,`output`,`member_count`,`priority`,DATE_FORMAT(`datefrom`, '%M %d,%Y') 'dformat1',DATE_FORMAT(`dateto`, '%M %d,%Y') 'dformat2'");
        $this->db->where('projectid', $id); 
        $query = $this->db->get('task');
        if($query->num_rows() > 0){
            $tasks = array();
            foreach ($query->result() as $row){
                $task[0] = $row->id;
                $task[1] = $row->name;
                $task[2] = $row->milestone_indicator;
                $task[3] = $row->dformat1 . " to " .$row->dformat2;
                $priorityLabels = array("<label class='label label-success'>Low</label>",
                                    "<label class='label label-warning'>Medium</label>",
                                    "<label class='label label-danger'>High</label>");
                $task[4] = $row->member_count;
                $task[5] = $priorityLabels[$row->priority - 1];
                $task[6] = $row->output;
                array_push($tasks,$task);
            }
            return $tasks;
        }else
            return "error";
    }
    function delete_employee_task($id){
        $this->db->delete('employee_has_task', array('taskid' => $id));    
    }
    function delete_task_skillset($id){
        $this->db->delete('task_has_skillset', array('taskid' => $id));
    }
    function add_skillset_to_task($skillsetid, $taskid){
        $data = array(
            'skillsetid' => $skillsetid,
            'taskid' => $taskid
        );
        $this->db->insert('task_has_skillset', $data); 
        return;
    }
    function update_task($name,$milestone_indicator,$datefrom,$dateto,$member_count,$priority,$outputs,$id){
        $data = array(
                'name' => $name,
                'milestone_indicator' => $milestone_indicator,
                'datefrom' => $datefrom,
                'dateto' => $dateto,
                'member_count' => $member_count,
                'priority' => $priority,
                'output' => $outputs
            );
        if($id == 0){
            $this->db->insert('task', $data);
        }else{
            $this->db->where('id', $id);
            $this->db->update('task', $data);
        }
    }
    function delete_task($id){
        $this->db->delete('task', array('id' => $id));
    }
    function get_last_inserted_task(){
        $this->db->select("max(`id`) 'id'");
        $query = $this->db->get('task');
        if ($query->num_rows() > 0){
             $row = $query->row(); 
             return $row->id;
        }
        return 0;
    }
    function get_skillset_from_task(){
        $taskid = $this->input->get('taskid');
        $projectid = $this->input->get('id');

        $this->db->select("skillsetid");
        $this->db->where('taskid', $taskid);
        $query = $this->db->get('task_has_skillset');
        $skillsets = array();
        if ($query->num_rows() > 0){
            foreach ($query->result() as $row){
                array_push($skillsets, $row->skillsetid);
            }
        }

        $status = 0;
        $this->db->select('empid');
        $this->db->where('taskid',$taskid);
        $query = $this->db->get('employee_has_task');
        if ($query->num_rows() > 0){
            foreach ($query->result() as $row){
                if($row->empid == $_SESSION['id'])
                    $status = 1;
            }    
        }
        $involvement = $status == 1? 1:2;
        return json_encode([$skillsets,$involvement]);
    }

    function get_project_tasks_ganttchart($id){
        $this->db->select("`id`,`name`,`datefrom`,`dateto`");
        $this->db->where('projectid', $id); 
        $query = $this->db->get('task');
        if($query->num_rows() > 0){
            $tasks = array();
            foreach ($query->result() as $row){
                $task['id'] = $row->id;
                $task['name'] = $row->name;
                $task['datefrom'] = $row->datefrom;
                $task['dateto'] = $row->dateto;
                array_push($tasks,$task);
            }
            return $tasks;
        }else
            return "error";
    }
    function get_task_date($taskid){
        $query = "SELECT max(`date_finished`) 'date' FROM employee_has_task where `taskid`= ".$taskid." and `status`=1";
        $result = $this->db->query($query);
            if ($result->num_rows() > 0) {
                $row = $result->row();
                $returndate = $row->date;
                return $returndate;
            }
            else {
                return null;
            }
    }    
    function get_project_task_count_done_vs_total($projectid){
        $query = "SELECT 
                    T.`id`,T.`name`,
                    SUM(CASE WHEN THS.`date_finished` IS NOT NULL THEN 1 ELSE 0 END ) AS 'done',
                    COUNT(THS.`id`) AS 'total'
                FROM
                    `task` AS T
                LEFT JOIN `task_has_subtasks` AS THS ON THS.`taskid` = T.`id`
                WHERE T.`projectid` = ?
                GROUP BY T.`id`";
        $result = $this->db->query($query, array($projectid));
        if($result->num_rows() > 0){
            $taskstring = "";
            $total = 0;
            $done = 0;
            foreach ($result->result() as $row){
                if((int)$row->done === (int)$row->total)
                    $taskstring .="<input type='checkbox' checked disabled> ";
                else
                    $taskstring .="<input type='checkbox' disabled> ";
                $taskstring .= $row->name;
                $taskstring .="<br>";

                $done += (int)$row->done === (int)$row->total? 1: 0;
                $total ++;
            }
            $taskstring .= "<br>Tasks Done: " .$done ."/" .$total;
            return $taskstring;
        }else{
            return "No tasks under this project";
        }
    }
}