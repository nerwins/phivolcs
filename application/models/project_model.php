<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/31/2016
 * Time: 10:08 AM
 */

class Project_model extends CI_Model {
    function __construct() {
        parent::__construct();

        $this->load->model("inventory_model");
        $this->load->model("budget_model");
        $this->load->model("revisions_model");
        $this->load->model("tasks_model");
        $this->load->model("outputs_model");

    }
    function get_project_list(){
        $id = $_SESSION['id'];
        $division = $_SESSION['division'];
        $position = $_SESSION['position'];
        $projArray = array();
        $projects = $this->get_projects($position,$division,$id);
        if($projects == "error")
            return json_encode("error");
        else
        foreach($projects as $obj =>$proj){
            $project = array();
            array_push($project,$proj['id']);
            array_push($project,$proj['name']);
            array_push($project,$proj['datefromformat'] ." to ".$proj['datetoformat']);
            $lbl = "";
            if($proj['priority'] == 1)
                $lbl = "<label class='label label-success'>Low</label>";
            elseif($proj['priority'] == 2)
                $lbl = "<label class='label label-warning'>Medium</label>";
            elseif($proj['priority'] == 3)
                $lbl = "<label class='label label-danger'>High</label>";
            array_push($project,$lbl);
            array_push($project,$proj['locationname']);
            $percentage = $this->get_project_percentage($proj['id']);
            $stat = "";
            if ($proj['status'] == -1) 
                $stat = "<label class='label label-default'>Waiting for Employee Approval</label>";
            elseif ($proj['status'] == 0){
                if($position == 2)
                    $stat = "<label class='label label-default'>Pending</label>";
                elseif($division == 3 && $position == 3)
                    $stat = "<label class='label label-default'>Pending for Approval</label>";
            }elseif ($proj['status'] == 1){
                if($position == 2)
                    $stat = "<label class='label label-warning'>For revision by budget section</label>";
                elseif($division == 3 && $position == 3)
                    $stat = "<label class='label label-warning'>Needs Revision</label>";
            }elseif ($proj['status'] == 2)
                if($position == 1)
                    $stat = "<label class='label label-warning'>For Revision</label>";
                else
                    $stat = "<label class='label label-warning'>For revision by director</label>";
            elseif ($proj['status'] == 3)
                $stat = "<label class='label label-danger'>Scrapped</label>";
            elseif ($proj['status'] == 4){
                if($position == 1)
                    $stat = "<label class='label label-default'>For Approval</label>";
                elseif($position == 2)
                    $stat = "<label class='label label-primary'>Approved by Budget</label>";
                elseif($division == 3 && $position == 3)
                    $stat = "<label class='label label-primary'>Approved Budget</label>";
            }elseif ($proj['status'] == 5){
                if($position == 1)
                    $stat = "<label class='label label-primary'>Approved Project</label>";
                else
                    $stat = "<label class='label label-primary'>Approved by Director</label>";
            }elseif ($proj['status'] == 6){
                $stat = "<div class=\"progress\">\n"
                        . "  <div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"" . $percentage . "\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: " . $percentage . "%;\">\n"
                        . "    " . $percentage . "%\n"
                        . "  </div>\n"
                        . "</div>";
            }else if ($proj['status'] == 7) {
                if ($percentage == 100)
                    $stat = "<label class='label label-success'>Done</label>";
                else
                    $stat = "<label class='label label-success'>Done but only " . $percentage . "% Completed</label>";
            }
            array_push($project,$stat);
            array_push($projArray,$project);
        }
        return json_encode($projArray);
    }
    function get_projects($position, $division = 0, $empid = 0){
        $whereCondition = "";
        if($position == 1){
            //director
            $whereCondition = " `status` >= 2 ";
        }elseif($position == 2){
            //division chief
            $whereCondition = " `createdby` = " . $empid;
        }elseif($position == 3 && $division != 3){
            //projects head projects
            $whereCondition = " (`status`=-1 or `status`>=5) AND `empid` = " . $empid;

        }
        $query = "SELECT 
                        `id`,`name`,`datefrom`,`dateto`,`priority`,`locationname`,`status`,
                        DATE_FORMAT(`datefrom`, '%M %d,%Y') 'datefromformat',
                        DATE_FORMAT(`dateto`, '%M %d,%Y') 'datetoformat'
                    FROM
                        project
                    WHERE
                        ".$whereCondition."
                    ORDER BY `status` ASC , `priority` DESC , `modified` DESC";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            $projectList = array();
            $i = 0;
            foreach ($result->result() as $row)
            {
                $projectList[$i]['id'] = $row->id;
                $projectList[$i]['name'] = $row->name;
                $projectList[$i]['datefrom'] = $row->datefrom;
                $projectList[$i]['dateto'] = $row->dateto;
                $projectList[$i]['priority'] = $row->priority;
                $projectList[$i]['locationname'] = $row->locationname;
                $projectList[$i]['status'] = $row->status;
                $projectList[$i]['datefromformat'] = $row->datefromformat;
                $projectList[$i]['datetoformat'] = $row->datetoformat;
                $i++;
            }
            return $projectList;
        }else
            return "error";
    }
    function get_project_percentage($id){
        $query = "SELECT 
                        ROUND((SUM((SELECT 
                                        COALESCE(SUM(`percentage`), 0)
                                    FROM
                                        `task_has_subtasks`
                                    WHERE
                                        `taskid` = T.`id` AND `status` = 1)) / (COUNT(*) * 100)) * 100) 'total'
                    FROM
                        `task` T
                    WHERE
                        `projectid` = ?;";
        $result = $this->db->query($query, array($id));
        $row = $result->row();
        return $row->total;
    }
    function get_project_details(){
        $projectid = $this->input->get('projectid');
        $query = "SELECT p.`id`,`name`,`datefrom`,`dateto`,`priority`,`description`,`significance`,`emp_stat`,
                        `latitude`,`empid`,`longitude`,`createdby`,`background`,`locationname`,`status`,
                        date_format(`datefrom`,'%M %d,%Y') 'datefromformat',date_format(`dateto`,'%M %d,%Y') 'datetoformat',
                        CONCAT(e.lastname, ', ', e.firstname, ' ', e.middleinitial) as 'fullname'
                    FROM project p
                    LEFT JOIN employee as e on e.`id` = empid
                    WHERE p.`id`  =? ";
        $result = $this->db->query($query, array($projectid));
        if ($result->num_rows() > 0) {
            $row = $result->row();
            $project['id'] = $row->id;
            $project['datefromformat'] = $row->datefromformat;
            $project['datetoformat'] = $row->datetoformat;
            $project['name'] = $row->name;
            $project['datefrom'] = $row->datefrom;
            $project['dateto'] = $row->dateto;
            $priorityLabels = array("<label class='label label-success'>Low</label>",
                                    "<label class='label label-warning'>Medium</label>",
                                    "<label class='label label-danger'>High</label>");
            $project['priority'] = $priorityLabels[$row->priority - 1];
            $project['description'] = $row->description;
            $project['significance'] = $row->significance;
            $project['emp_stat'] = $row->emp_stat;
            $project['latitude'] = $row->latitude;
            $project['empid'] = $row->empid;
            $project['longitude'] = $row->longitude;
            $project['createdby'] = $row->createdby;
            $project['background'] = $row->background;
            $project['locationname'] = $row->locationname;
            $status = "";


            $percentage = $this->get_project_percentage($projectid);
            $totalbudget = $this->budget_model->get_total_project_budget($projectid);
            $tasks = $this->tasks_model->get_project_tasks($projectid,$row->status, $row->empid);
            $budgets = $this->budget_model->get_project_budgets($projectid);
            $outputs = $this->outputs_model->get_project_outputs($projectid);
            $directorComments = $this->revisions_model->get_director_comments($projectid,$_SESSION['position'],$row->status);

            $percentage = $this->get_project_percentage($projectid);

            switch($row->status){
                case -1: $status = "Waiting for employee approval"; break;
                case 0: $status = "Pending"; break;
                case 1: $status = "For revision by budget section"; break;
                case 2: $status = "For revision by director"; break;
                case 3: $status = "Scrapped"; break;
                case 4: $status = "Approved by Budget"; break;
                case 5: $status = "Approved by Director"; break;
                case 6: $status = $percentage."% Complete"; break;
                case 7: $status = $percentage == 100?"Done":"Done but only " .$percentage."% Completed"; break;
            }
            $project['status'] = $status;
            $project['projectheadname'] = $row->fullname;

            $project['budgettotal'] = (($row->status >= 0 && $row->status <= 3)?"Proposed Budget: ":"Project Budget: ").$totalbudget;
            $project['pendingtaskcount'] = $this->tasks_model->get_task_status_count($projectid,'pending');
            $project['completedtaskcount'] = $this->tasks_model->get_task_status_count($projectid,'completed');

            $budget = $this->get_project_budget($projectid);
            $project['budget'] = (($row->status >= 0 && $row->status <= 3)?"Proposed Budget: ":"Project Budget: ").$budget;
            $project['pendingtaskcount'] = $this->get_task_status_count($projectid,'pending');
            $project['completedtaskcount'] = $this->get_task_status_count($projectid,'completed');
            $tasks = $this->get_project_tasks($projectid,$row->status, $row->empid);

            $project['totaltaskcount'] = $tasks != "error"?count($tasks):0;
            $project['percentage'] = $percentage;
            $project['statusnum'] = $row->status;
            $project['tasks'] = $tasks;

            $project['budgets'] = $budgets;
            $project['outputs'] = $outputs;
            $project['directorcomments'] = $directorComments;

            return json_encode($project);
        }else
            return json_encode("error");
    }

    function approve_project(){
        $projectid = $this->input->post('id');
        $budgets = $this->budget_model->get_project_budgets($projectid);
        if(count($budgets) > 0){
            for($x = 0; $x < count($budgets); $x++){
                $budget = $budgets[$x];
                if($budget[2] == 'Equipment Expenses'){
                    if($this->inventory_model->check_existing_inventory($budget[1],0) > 0){
                        $amount = (int)explode(" ",$budget[4])[1];
                        if($amount != 0)
                            $this->inventory_model->update_inventory($budget[3],$budget[1]);
                        $this->inventory_model->update_inventory_in_use($budget[3],$budget[1]);
                    }else
                        $this->add_inventory($budget[3],$budget[1]);
                }else{
                    if($this->inventory_model->inventory_model->check_existing_inventory($budget[1],1) > 0)
                        $this->budget_model->add_expense($expenseName);
                }
            }
            $this->update_project_status(5,$projectid);
        }else
            return "error";
    }
    function decline_project(){
        $projectid = $this->input->post('id');
        $reason = $this->input->post('reason');
        $this->db->trans_start();
        $this->budget_model->delete_budget_log_details($projectid);
        $this->budget_model->delete_budget_logs($projectid);
        $this->revisions_model->delete_director_revisions($projectid);
        $this->update_project_status(3,$projectid);
        $this->update_project_reason($reason,$projectid);
        $this->db->trans_complete();
        return;
    }
    function update_project_status($status, $projectid){
        $data = array(
            'status' =>$status,
            );
        $this->db->where('id', $projectid);
        $this->db->set('modified', 'NOW()', FALSE);
        $this->db->update('project', $data);
        return;
    }
    function update_project_reason($reason,$projectid){
        $data = array(
            'reason' =>$reason,
            );
        $this->db->where('id', $projectid);
        $this->db->update('project', $data);
        return;
    }
    function update_project_details($description,$background,$significance,$latitude,$longitude,$locationname,$pid){
        $data = array(
                'description' => $description,
                'background' => $background,
                'significance' => $significance,
                'status' => 4,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'locationname' => $locationname
            );
        $this->db->where('id', $pid);
        $this->db->update('project', $data);
    }   
    function get_project_budget($id){
        $this->db->select('sum(amount) AS `total`');
        $this->db->where('projectid', $id); 
        $this->db->group_by("projectid"); 
        $query = $this->db->get('budget');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }
        return 0;
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
                $task[1] = $row->member_count;
                $task[2] = $row->datefrom;
                $task[3] = $row->dateto;
                $task[4] = $row->name;
                $task[5] = $row->dformat1;
                $task[6] = $row->dformat2;
                $task[7] = $row->milestone_indicator;
                $task[8] = $row->priority;
                $task[9] = $row->output;
                if($projectstatus == -1)
                    $task[10] = $this->check_task($empid,$id,$row->id);
                array_push($tasks,$task);
            }
            return $tasks;
        }else
            return "error";
    }
    function check_task($empid,$projectid,$taskid){
        $query = "SELECT 
                    (CASE
                        WHEN
                            (SELECT 
                                    COUNT(*)
                                FROM
                                    `employee_has_task`
                                WHERE
                                    `taskid` = T.`id` AND `empid` = ?
                                        AND `isApproved` = 0)
                        THEN
                            1
                        ELSE 0
                    END) 'check'
                FROM
                    task T
                WHERE
                    `projectid` = ? AND `id` = ?;";
        $result = $this->db->query($query, array($empid,$projectid,$taskid));
        if ($result->num_rows() > 0) {
            $row = $result->row();
            return $row->check;
        }else
            return 0;
    }
    function get_project_nature_list(){
    	$this->db->select('id,name');
        $query = $this->db->get('project_nature');
        if ($query->num_rows() > 0) {
        	$arr = array();
            foreach ($query->result() as $row){
                $arr[] = $row;  
            }
        }
        return json_encode($arr);
    }
    function get_projects_status(){
        $arr = array();
        $empid = $this->session->userdata('id');
        $createdby = $this->session->userdata('id');

        $query1 = "SELECT P.`id` 
        FROM `project` P 
        JOIN  `task` T ON P.`id`=T.`projectid` 
        JOIN `employee_has_task` ET ON ET.`taskid`=T.`id` 
        WHERE 
        (P.`status`>=5 and P.`status`!=3 and P.`status`!=7) 
        AND 
        (ET.`empid` = ? or P.`empid` = ? or P.`createdby`= ?)  
        GROUP BY P.`id`";

        $result = $this->db->query($query1, array($empid, $empid, $createdby));

        $arr['count_project_inProgress'] = $result->num_rows();

        //completed projects
        $query2 = "SELECT P.`id` 
        FROM `project` P 
        JOIN  `task` T ON P.`id`=T.`projectid` 
        JOIN `employee_has_task` ET ON ET.`taskid`=T.`id` 
        WHERE 
        (P.`status`!=3 and P.`status`=7) 
        AND 
        (ET.`empid` = ? or P.`empid` = ? or P.`createdby`= ?)  
        GROUP BY P.`id`";

        $result = $this->db->query($query2, array($empid, $empid, $createdby));
        $arr['count_project_completed'] = $result->num_rows();

        //total
        $arr['count_project_total'] = $arr['count_project_inProgress'] + $arr['count_project_completed'];

        return json_encode($arr);
    }
    function get_member_tasks_status(){
        $arr = array();
        $empid = $this->session->userdata('id');
        $division = $this->session->userdata('division');

        //pending tasks
        $query1 = "SELECT count(*) 'id' FROM task T 
        left join  employee_has_task ET on T.id=ET.taskid 
        left join project P on P.id=T.projectid 
        left join employee E on E.`id`=ET.`empid` 
        where (P.`status`!=3 and P.`status`>=5 and P.`status`!=7) 
        and ET.`status`= 0 and E.`division_id`= ? and E.`id`!= ?";

        $result = $this->db->query($query1, array($division, $empid));
        foreach ($result->result() as $row){
           $a = $row->id;
           // var_dump($a);
       }

        $arr['count_task_inProgress'] = $a;
        // var_dump($arr['count_task_inProgress']);

        //completed tasks
        $query2 = "SELECT count(*) 'id' FROM task T 
        left join  employee_has_task ET on T.id=ET.taskid 
        left join project P on P.id=T.projectid 
        left join employee E on E.`id`=ET.`empid` 
        where (P.`status`!=3 and P.`status`>=5) 
        and ET.`status`= 1 
        and (P.`empid`!= ? or ET.`empid`!= ?)";

        $result = $this->db->query($query2, array($empid, $empid));
        foreach ($result->result() as $row){
           $b = $row->id;
           // var_dump($a);
       }

       $arr['count_task_completed'] = $b;
       $arr['count_task_total'] = $arr['count_task_inProgress'] + $arr['count_task_completed'];

       return json_encode($arr);
    }
    function get_tasks_status(){
        $arr = array();
        $empid = $this->session->userdata('id');
        $division = $this->session->userdata('division');

        //pending tasks
        $query1 = "SELECT count(*) 'id' FROM task T 
        left join  employee_has_task ET on T.id=ET.taskid 
        left join project P on P.id=T.projectid 
        left join employee E on E.`id`=ET.`empid` 
        where (P.`status`!=3 and P.`status`>=5 and P.`status`!=7) 
        and ET.`status`= 0 and E.`division_id`= ? and E.`id`!= ?" ;


        $result = $this->db->query($query1, array($division, $empid));
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row){
                $a = $row->id;
                // var_dump($a);
            }
        } else
            $a = 0;

        $arr['count_task_inProgress'] = $a;
        // var_dump($arr['count_task_inProgress']);


        $query2 = "SELECT count(*) 'id' FROM task T 
        left join  employee_has_task ET on T.id=ET.taskid 
        left join project P on P.id=T.projectid 
        left join employee E on E.`id`=ET.`empid` 
        where (P.`status`!=3 and P.`status`>=5) 
        and ET.`status`= 1 and E.`division_id`= ? and E.`id`!= ?";

        $result = $this->db->query($query2, array($division, $empid));
        foreach ($result->result() as $row){
           $b = $row->id;
           // var_dump($a);
       }
       
       $arr['count_task_completed'] = $b;
       $arr['count_task_total'] = $arr['count_task_inProgress'] + $arr['count_task_completed'];

       return json_encode($arr);
    }
    function add_project_draft(){
        $project_name = $this->input->post('project_name');
        $project_type = $this->input->post('project_type');
        $date_from = date("Y-m-d", strtotime($this->input->post('date_from')));
        $date_to = date("Y-m-d", strtotime($this->input->post('date_to')));
        $project_head = $this->input->post('project_head');
        $priority = $this->input->post('priority');
        $description = $this->input->post('description');
        $background = $this->input->post('background');
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');
        $location_name = $this->input->post('location_name');
        $significance = $this->input->post('significance');
        $draft_name = $this->input->post('draft_name');
        $createdby = $this->input->post('createdby');

        $query = "INSERT INTO `project_draft` 
        (`draft_name`,  `pname`, `significance`, `background`, `description`, 
            `datefrom`, `dateto`, `empid`, `priority`, `latitude`, `longitude`, `locationname`, `createdby`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $result = $this->db->query($query, array($draft_name, $project_name, $significance, $background, $description, 
            $date_from, $date_to, $project_head, $priority, $latitude, $longitude, $location_name, $createdby));

        //add objectives
        // var_dump($this->db->last_query());
        $query2 = "SELECT `id` FROM `project` WHERE `name`= ?";
        $result2 = $this->db->query($query2, array($project_name));
        $projectid = "";
        if ($result2->num_rows() > 0) {
            foreach ($result->result() as $row){
                $projectid = $row->id;
                // var_dump($a);
            }
        }
        $objectives = $this->input->post('json_objectives');
        $data_objectives = json_decode($objectives);
        var_dump($data_objectives);
        $this->db->set('name', $data_objectives); 
        $this->db->set('projectid', $projectid); 
        $this->db->insert('objectives'); 

        // var_dump($this->db->last_query());
    }
}