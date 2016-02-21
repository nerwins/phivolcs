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
            $whereCondition = " where (`status`=-1 or `status`>=5) AND `empid` = " . $empid;
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
}