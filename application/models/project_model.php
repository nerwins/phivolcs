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


        $projectid = $this->input->get('projectid');
        $location = $this->input->get('location');
        $priority = $this->input->get('priority');
        $datefrom = $this->input->get('datefrom');
        $dateto = $this->input->get('dateto') ." 23:59:59";
        $init = $this->input->get('init');

        $filters = array(
            'projectid' => $projectid,
            'location' => $location,
            'priority' => $priority,
            'datefrom'=> $datefrom,
            'dateto' => $dateto,
            'init' => $init
            );

        $projects = $this->get_projects($position,$division,$id, $filters);
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
    function get_projects($position, $division = 0, $empid = 0, $filters){
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
        if($filters['projectid'] != 0){
            $whereCondition .= " AND `id` = '".$filters['projectid'] ."' ";
        }if(strlen($filters['location']) > 1){
            $whereCondition .= " AND `locationname` = '".$filters['location'] ."' ";
        }if($filters['priority'] != 0){
            $whereCondition .= " AND `priority` = '".$filters['priority'] ."' ";
        }
        if($filters['init'] != 0)
            $whereCondition .= " AND `datefrom` >= '".$filters['datefrom'] ."' AND `dateto` <= '" .$filters['dateto'] ."' ";

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
    function get_project_list_for_budget_report(){
        $datefrom = $this->input->get('datefrom');
        $dateto = $this->input->get('dateto') ." 23:59:59";
        $division = $this->input->get('division');
        $nature = $this->input->get('nature');
        $divisionString = $division == 0? "":" AND E.`division_id` = " . $division;
        $query = "SELECT 
                P.`id`, P.`name`, CONCAT(E.`lastname`,', ', E.`firstname`, ' ', E.`middleinitial`) AS 'projecthead',
                CASE WHEN E.`division_id` = 1 THEN 'Volcanology'
                    WHEN E.`division_id` = 2 THEN 'Seismology'
                    WHEN E.`division_id` = 3 THEN 'Finance and Admin'
                    WHEN E.`division_id` = 4 THEN 'Research and Development'
                    ELSE 'Distaster Preparedness' END AS 'division',
                COALESCE(PN.`id`,0) AS `nature`
            FROM
                `project` AS P
            LEFT JOIN `employee` AS E ON E.`id` = P.`empid`
            LEFT JOIN `employee_has_skillset` AS EHS ON EHS.`employeeid` = E.`id`
            LEFT JOIN `skillset` AS S ON S.`id` = EHS.`skillsetid`
            LEFT JOIN `project_nature_has_skillset` AS PNHS ON PNHS.`id_skillset` = S.`id`
            LEFT JOIN `project_nature` AS PN ON PN.`id` = PNHS.`pid`
            WHERE P.`datefrom` >= ? 
                AND P.`dateto` <= ? " .$divisionString
            ." GROUP BY P.`id` ORDER BY `status` ASC , `priority` DESC , `modified` DESC";
        $data = array($datefrom,$dateto);
        $result = $this->db->query($query, $data);
        if ($result->num_rows() > 0) {
            $projectList = array();
            foreach ($result->result() as $row)
            {
                $totals = $this->budget_model->get_total_proposed_and_actual_project_budget($row->id);
                $project[0] = $row->id;
                $project[1] = $row->name;
                $project[2] = $row->projecthead;
                $project[3] = $row->division;
                $project[4] = $totals[0];
                $project[5] = $totals[1];
                if($nature == 0)
                    array_push($projectList,$project);
                else
                    if($row->nature == $nature)
                        array_push($projectList,$project);
            }
            return json_encode($projectList);
        }
        else
            return json_encode("error");
    }
    function get_project_list_complete(){
        $projArray = array();
        $whereCondition = "";
        $projectList = array();
        $query = "SELECT 
                        `id`,`name`,`datefrom`,`dateto`,`priority`,`locationname`,`status`,
                        DATE_FORMAT(`datefrom`, '%M %d,%Y') 'datefromformat',
                        DATE_FORMAT(`dateto`, '%M %d,%Y') 'datetoformat'
                    FROM
                        project
                    WHERE
                        `status` = 7 #whereCondition
                    ORDER BY `modified` DESC, `priority` DESC ";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
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
        }else
            return json_encode("error");

        $projects = $projectList;

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

            //$percentage = $this->get_project_percentage($proj['id']);
            $stat = "";
            $done = 0;
            $total = 0;

            $query = "  SELECT COUNT(*) AS 'done' FROM (
                            SELECT COALESCE(SUM(S.`percentage`), 0) AS 'percentage', T.`projectid`
                            FROM `task` AS T
                            LEFT JOIN `task_has_subtasks` AS S ON S.`taskid` = T.`id` AND S.`status` = 1
                            WHERE T.`projectid` = ".$proj['id']."
                            GROUP BY S.`taskid`
                        ) B 
                        WHERE B. `percentage` = 100 ";
            $result = $this->db->query($query);
            if ($result->num_rows() > 0) {
                $row = $result->row();
                $done = $row->done;
            }

            $query = " SELECT COUNT(*) AS 'total' FROM `task` WHERE `projectid` = ".$proj['id'];
            $result = $this->db->query($query);
            if ($result->num_rows() > 0) {
                $row = $result->row();
                $total = $row->total;
            }
          
            if ($done == $total)
                $stat = "<label class='label label-success'>Done</label>";
            else
                $stat = "<label class='label label-success'>Partially Completed (".$done."/".$total." tasks)</label>";
            
            array_push($project,$stat);
            array_push($projArray,$project);
        }
        return json_encode($projArray);
    }
    function get_projects_calendar(){
        $empid = $_SESSION['id'];
        $division = $_SESSION['division'];
        $position = $_SESSION['position'];

        $whereCondition = "";
        if($position == 1){
            //director
            $whereCondition = "";
        }elseif($position == 2){
            //division chief
            $whereCondition = " and (E.`division_id`=".$division.")";
        }elseif($position == 3 && $division != 3){
            //projects head projects
            $whereCondition = " and (P.`empid`=".$empid." or ET.`empid`=".$empid.")";
        }

        $query = "SELECT distinct T.id,T.name,T.datefrom,date_add(T.dateto,interval 1 day) 'dateto',P.name 'pname',P.`priority` 
                    FROM task T 
                    left join employee_has_task ET on T.id=ET.taskid 
                    left join project P on P.id=T.projectid
                    left join employee E on E.`id`=ET.`empid`
                    where (P.`status`!=3 and P.`status`>=5 and P.`status`!=7)  and ET.`status`= 0 ".$whereCondition;
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            $projectList = array();
            $i = 0;
            foreach ($result->result() as $row)
            {
                $projectList[$i]['id'] = $row->id;
                $projectList[$i]['taskname'] = $row->name;
                $projectList[$i]['datefrom'] = $row->datefrom;
                $projectList[$i]['dateto'] = $row->dateto;
                $projectList[$i]['projname'] = $row->pname;
                $projectList[$i]['priority'] = $row->priority;
                $i++;
            }
            return json_encode($projectList);
        }else
            return json_encode("error");
    }

    function get_end_of_summary($id){
        $query = "SELECT * FROM `endofsummary` where `projectid`= ".$id;
        $result = $this->db->query($query);
            if ($result->num_rows() > 0) {
                $row = $result->row();
                $datesubmitted = $row->date_submitted;
                return $datesubmitted;
            }
            else {
                return null;
            }
    }
    function get_project_details_ganttchart(){
        //try {
        $projectid = $this->input->get('id');
        $query = "SELECT p.`id`,`name`,`datefrom`,`dateto`,`priority`,`description`,`significance`,`emp_stat`,
                        `latitude`,`empid`,`longitude`,`createdby`,`background`,`locationname`,`status`,
                        date_format(`datefrom`,'%M %d,%Y') 'datefromformat',date_format(`dateto`,'%M %d,%Y') 'datetoformat',
                        CONCAT(e.lastname, ', ', e.firstname, ' ', e.middleinitial) as 'fullname'
                    FROM project p
                    LEFT JOIN employee as e on e.`id` = empid
                    WHERE p.`id`  =? ";
        $result = $this->db->query($query, array($projectid));

        ////////////////new
        if ($result->num_rows() > 0) {
            $row = $result->row();
            if ($row->status != 7) {
                $toreturn = array();
                $project = array();
                $project['id'] = $projectid;
                $project['name'] = "Project: ".$row->name;

                $disp = array();
                $disp['name'] = "Planned";
                $disp['color'] = "rgb(31, 26, 26)";
                $disp['start'] = $row->datefrom;
                $disp['end'] = $row->dateto;

                $plot = array();
                array_push($plot, $disp);
                $project['series'] = $plot;
                array_push($toreturn, $project);

                $tasks_cnt = $this->tasks_model->get_project_tasks($projectid,$row->status, $row->empid);
                $tasks_cnt = count($tasks_cnt);
                $tasks = $this->tasks_model->get_project_tasks_ganttchart($projectid);

                for ($x = 0; $x < $tasks_cnt; $x++) {
                    $jss = array();
                    $jss2 = array();
                    $jss3 = array();

                    $jss2['name'] = "Planned";
                    $jss2['color'] = "#FFFFFF";
                    $jss2['start'] = $tasks[$x]['datefrom'];
                    $jss2['end'] = $tasks[$x]['dateto'];
                    $jss2['tname'] = $tasks[$x]['name'];

                    array_push($jss3, $jss2);
                    $jss['series'] = $jss3;
                    $jss['name'] = "Task: ".$tasks[$x]['name'];

                    $jss['id'] = $tasks[$x]['id'];
                    array_push($toreturn, $jss);

                }
                return json_encode($toreturn);

            } else {
                $toreturn = array();
                $project = array();
                $project['id'] = $row->id;
                $project['name'] = "Project: ".$row->name;

                $disp = array();
                $disp['name'] = "Planned";
                $disp['color'] = "rgb(31, 26, 26)";
                $disp['start'] = $row->datefrom;
                $disp['end'] = $row->dateto;

                $jz4 = array();
                $jz4['name'] = "Actual";
                $jz4['color'] = "rgb(224, 224, 224)";
                $jz4['start'] = $row->datefrom;
                $endofsum = $this->project_model->get_end_of_summary($projectid);
                if ($endofsum == null) {
                    $jz4['end'] = $row->datefrom;
                }
                else {
                    $jz4['end'] = $endofsum;
                }
                //die(json_encode($jz4['end']));
                $jz3 = array();
                array_push($jz3,$disp);
                array_push($jz3,$jz4);
                $project['series'] = $jz3;
                array_push($toreturn,$project);

                $tasks_cnt = $this->tasks_model->get_project_tasks($projectid,$row->status, $row->empid);
                $tasks_cnt = count($tasks_cnt);
                $tasks = $this->tasks_model->get_project_tasks_ganttchart($projectid);
                //die(json_encode($tasks));
                for ($x = 0; $x < $tasks_cnt; $x++) {
                    $jss = array();
                    $jss2 = array();
                    $jss3 = array();

                    $jss2['name'] = "Planned";
                    $jss2['color'] = "#FFFFFF";
                    $jss2['start'] = $tasks[$x]['datefrom'];
                    $jss2['end'] = $tasks[$x]['dateto'];
                    $jss2['tname'] = $tasks[$x]['name'];

                    array_push($jss3, $jss2);

                    $jss4 = array();

                    $pendingtasks = $this->tasks_model->get_task_status_count($projectid,'pending');
                    $getdate = $this->tasks_model->get_task_date($tasks[$x]['id']);

                    if ($pendingtasks > 0) {
                        if ($getdate == null) {
                            $jss4['name'] = "Actual(Incomplete)";
                            $jss4['color'] = "rgb(110, 110, 110)";
                            $jss4['start'] = $tasks[$x]['datefrom'];
                            $jss4['end'] = $tasks[$x]['datefrom'];
                            $jss4['tname'] = $tasks[$x]['name'];
                            array_push($jss3, $jss4);
                        } else {
                            $jss4['name'] = "Actual(Incomplete)";
                            $jss4['color'] = "rgb(110, 110, 110)";
                            $jss4['start'] = $tasks[$x]['datefrom'];
                            $jss4['end'] = $getdate;
                            $jss4['tname'] = $tasks[$x]['name'];
                            array_push($jss3, $jss4);
                        }
                    } else {
                        if ($getdate == null) {
                            $jss4['name'] = "Actual(Completed)";
                            $jss4['color'] = "rgb(110, 110, 110)";
                            $jss4['start'] = $tasks[$x]['datefrom'];
                            $jss4['end'] = $tasks[$x]['datefrom'];
                            $jss4['tname'] = $tasks[$x]['name'];
                            array_push($jss3, $jss4);
                        } else {
                            $jss4['name'] = "Actual(Completed)";
                            $jss4['color'] = "rgb(110, 110, 110)";
                            $jss4['start'] = $tasks[$x]['datefrom'];
                            $jss4['end'] = $getdate;
                            $jss4['tname'] = $tasks[$x]['name'];
                            array_push($jss3, $jss4);
                        }
                    }

                    $jss['series'] = $jss3;
                    $jss['name'] = "Task: ".$tasks[$x]['name'];

                    $jss['id'] = $tasks[$x]['id'];
                    array_push($toreturn, $jss);
                }
                return json_encode($toreturn);
                //die(json_encode($toreturn));
            }
        }
    }
    function get_accomplished_reports_projects(){
        $datefrom = $this->input->get('datefrom');
        $dateto = $this->input->get('dateto') ." 23:59:59";
        $division = $this->input->get('division');
        $head = $this->input->get('head');
        $name = $this->input->get('name');
        $nature = $this->input->get('nature');

        $whereCondition = "";
        if($division != 0){
            $whereCondition .= " AND E.`division_id` = '". $division ."'";
        }if($head != 0){
            $whereCondition .= " AND P.`empid` = '" . $head ."'";
        }if($name != 0){
            $whereCondition .= " AND P.`id` = '". $name ."'";
        }
        $query = "SELECT 
                P.`id`,
                P.`name`,
                CONCAT(E.`lastname`,', ',E.`firstname`,' ',E.`middleinitial`) AS 'head',
                COALESCE(PN.`name`,'N/A') as 'nature',
                COALESCE(PN.`id`,0) AS `natureid`,
                CASE WHEN E.`division_id` = 1 THEN 'Volcanology'
                    WHEN E.`division_id` = 2 THEN 'Seismology'
                    WHEN E.`division_id` = 3 THEN 'Finance and Admin'
                    WHEN E.`division_id` = 4 THEN 'Research and Development'
                    ELSE 'Distaster Preparedness' END AS 'division',
                CONCAT(DATE_FORMAT(P.`datefrom`, '%M %d,%Y'),
                        ' - ',
                        DATE_FORMAT(P.`dateto`, '%M %d,%Y')) AS 'date'
                FROM
                `project` AS P
                    LEFT JOIN
                `employee` AS E ON E.`id` = P.`empid`
                    LEFT JOIN
                `employee_has_skillset` AS EHS ON EHS.`employeeid` = E.`id`
                    LEFT JOIN
                `skillset` AS S ON S.`id` = EHS.`skillsetid`
                    LEFT JOIN
                `project_nature_has_skillset` AS PNHS ON PNHS.`id_skillset` = S.`id`
                    LEFT JOIN
                `project_nature` AS PN ON PN.`id` = PNHS.`pid`
                WHERE P.`datefrom` >= ? AND P.`datefrom` <= ? 
                ".$whereCondition."
                GROUP BY P.`id`
                ORDER BY P.`status` ASC , P.`priority` DESC , P.`modified` DESC";
        $result = $this->db->query($query, array($datefrom,$dateto));
        //echo $this->db->last_query();
        if ($result->num_rows() > 0) {
            $projectList = array();
            foreach ($result->result() as $row)
            {
                $project[0] = $row->id;
                $project[1] = $row->name;
                $project[2] = $row->head;
                $project[3] = $row->nature;
                $project[4] = $row->division;
                $project[5] = $row->date;
                $project[6] = $this->tasks_model->get_project_task_count_done_vs_total($row->id);
                if($nature == 0)
                    array_push($projectList,$project);
                else
                    if($row->natureid == $nature)
                        array_push($projectList,$project);
            }
            return json_encode($projectList);
        }else{
            return json_encode("error");
        }
    }
    function get_project_name_and_heads_for_dropdown(){
        $query = "SELECT 
                    P.`id`,P.`name`,E.`id` AS 'headid',CONCAT(E.`lastname`,', ',E.`firstname`,E.`middleinitial`) AS 'head'
                FROM
                    `project` AS P
                LEFT JOIN
                    `employee` AS E ON P.`empid` = E.`id`";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            $projectsandheads = array();
            $i = 0;
            foreach ($result->result() as $row)
            {
                $projectsandheads[$i]['projects'] = array($row->id, $row->name);
                $projectsandheads[$i]['heads'] = array($row->headid, $row->head);
                $i++;
            }
            return json_encode($projectsandheads);
        }else
            return "error";
    }
    function get_project_list_dropdown(){
        $this->db->select("id,name");
        $query = $this->db->get('project');
        if ($query->num_rows() > 0) {
            $projects = array();
            foreach ($query->result() as $row){
                $project[0] = $row->id;
                $project[1] = $row->name;
                array_push($projects,$project);
            }
            return json_encode($projects);
        }else
            return json_encode("error");
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
        // $query2 = "SELECT `id` FROM `project` WHERE `name`= ?";
        // $result2 = $this->db->query($query2, array($project_name));
        // $projectid = "";
        // if ($result2->num_rows() > 0) {
        //     foreach ($result->result() as $row){
        //         $projectid = $row->id;
        //         // var_dump($a);
        //     }
        // }
        // $objectives = $this->input->post('json_objectives');
        // $data_objectives = json_decode($objectives);
        // var_dump($data_objectives);
        // $this->db->set('name', $data_objectives); 
        // $this->db->set('projectid', $projectid); 
        // $this->db->insert('objectives'); 

        // var_dump($this->db->last_query());
    }
    function get_project_heads(){
        $query = 'SELECT CONCAT_WS(", ", `lastname`, `firstname`) AS `emp_name` FROM phivolcs.employee WHERE `division_id` != 0;';
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            $arr = array();
            foreach ($result->result() as $row){
                $arr[] = $row->emp_name;  
            }
        }
        return json_encode($arr);
    }
    function propose_project(){
        $project = json_decode($this->input->post('project'), true);
        $outputs = json_decode($this->input->post('outputs'));
        $objectives = json_decode($this->input->post('objectives'));
        $budgetList = json_decode($this->input->post('budgetList'));
        $tasksList = json_decode($this->input->post('tasksList'));

        $date_from = date("Y-m-d", strtotime($this->input->post('date_from')));

        $query = 'INSERT INTO `project` (`name`, `description`, `background`, `significance`, `datefrom`, `dateto`, `empid`, `status`, `priority`, `latitude`, `longitude`, `locationname`, `createdby`, `id_nature`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $result = $this->db->query($query, array($project['project_name'], $project['description'], $project['background'], $project['significance'], date("Y-m-d", strtotime($project['date_from'])), date("Y-m-d", strtotime($project['date_to'])), $project['project_head'], -1, $project['priority'], $project['latitude'], $project['longitude'], $project['location_name'], $project['createdby'], $project['project_type']));

        // var_dump($this->db->last_query());

        $this->db->select('id');
        $this->db->where('name', $project['project_name']);
        $this->db->where('datefrom', date("Y-m-d", strtotime($project['date_from'])));
        $this->db->where('datefrom', date("Y-m-d", strtotime($project['date_to']))); 
        $temp = $this->db->get('project');
        if($temp->num_rows() > 0){
            foreach ($temp->result() as $row){
                $pid = $row->id;
            }
        }

        foreach($objectives as $o) {
            $objective = $o->objective;
            $query2 = 'INSERT INTO `objectives` (`name`, `projectid`) VALUES (?, ?)';
            $result2 = $this->db->query($query2, array($objective, $pid));
        }

        foreach($outputs as $o) {
            $expected = $o->expected;
            $pindicator = $o->pindicator;
            $query3 = 'INSERT INTO `output` (`expected`, `pindicator`, `projectid`) VALUES (?, ?, ?)';
            $result3 = $this->db->query($query3, array($expected, $pindicator, $pid));
        }

        foreach($budgetList as $b) {
            $amount = $b->amount;
            $item = $b->item;
            $qty = $b->qty;
            $reason = $b->reason;
            $type = $this->get_expense_type($b->type);
            $query4 = 'INSERT INTO `budget` (`expense`, `reason`, `expense_type`, `projectid`, `amount`, `qty`) VALUES (?, ?, ?, ?, ?, ?)';
            $result4 = $this->db->query($query4, array($item, $reason, $type, $pid, $amount, $qty));
        }

        foreach($tasksList as $t) {
            $due_date = $t->task_due_date;
            $milestone = $t->task_milestone;
            $taskname = $t->task_name;
            $output = $t->task_output;
            $priority = $t->task_priority;
            $query5 = 'INSERT INTO `propose_task` (`name`, `milestone_indicator`, `due_date`, `output`, `pid`, `priority`) VALUES (?, ?, ?, ?, ?, ?)';
            $result5 = $this->db->query($query5, array($taskname, $milestone, $due_date, $output, $pid, $priority));
        }

        // foreach($tasksList as $t) {
        //     $due_date = $t->task_due_date;
        //     $milestone = $t->task_milestone;
        //     $taskname = $t->task_name;
        //     $output = $t->task_output;
        //     $priority = $t->task_priority;
        //     $query5 = 'INSERT INTO `propose_task` (`name`, `milestone_indicator`, `due_date`, `output`, `pid`, `priority`) VALUES (?, ?, ?, ?, ?, ?)';
        //     $result5 = $this->db->query($query5, array($taskname, $milestone, $due_date, $output, $pid, $priority));
        // }


        // print_r($this->db->last_query());

        // print_r($project);
        // print_r($outputs);
        // print_r($objectives);
        // print_r($budgetList);
        // print_r($tasksList);
    }
    function get_expense_type($type){
        // $query = 
        if($type === "General Expense") {
            return 1;
        } else {
            return 2;
        }
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

}