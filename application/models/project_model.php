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
    }

    function get_project_list(){
        $id = $_SESSION['id'];
        $division = $_SESSION['division'];
        $position = $_SESSION['position'];
        $projArray = array();
        if($position == 1){
            //director projects
            $projects = $this->get_projects_director();
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
                $buttons = "";
                if($proj['status'] == 2)
                    $stat = "<label class='label label-warning'>For Revision</label>";
                elseif($proj['status'] == 3)
                    $stat = "<label class='label label-danger'>Scrapped</label>";
                elseif($proj['status'] == 4)
                    $stat = "<label class='label label-default'>For Approval</label>";
                elseif($proj['status'] == 5)
                    $stat = "<label class='label label-primary'>Approved Project</label>";
                elseif($proj['status'] == 6){
                    $stat = "<div class=\"progress\">\n"
                                . "  <div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"" .$percentage. "\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: " .$percentage. "%;\">\n"
                                . "    " .$percentage. "%\n"
                                . "  </div>\n"
                                . "</div>";
                }elseif($proj['status'] == 7){
                    if($percentage == 100)
                        $stat = "<label class='label label-success'>Done</label>";
                    else
                        $stat = "<label class='label label-success'>Done but only " .$percentage. "% Completed</label>";
                    $buttons .= "<button class='btn btn-success' title='View End of Summary Report' onclick='viewSreport(" .$proj['id']. ")'><i class='icon_datareport_alt'></i></button>";
                }
                if($proj['status'] >= 6)
                    $buttons .= "<button class='btn btn-warning' title='View tasks for project' onclick='showTasks(" .$proj['id']. ")'><i class='icon_lightbulb_alt'></i></button><button class='btn btn-danger' title='View Progress Reports' onclick='showProgressReports(" .$proj['id']. ")'><i class='icon_percent_alt'></i></button>";
                array_push($project,$stat);
                array_push($project,$buttons);
                array_push($projArray,$project);
            }
        }elseif($position == 2){
            //division chief projects
        }elseif($division == 3 && $position == 3){
            //budget section projects
        }elseif($division != 3 && $position == 3){
            //projects head projects
        }
        return json_encode($projArray);
    }

    function get_projects_director(){
        $query = "SELECT 
                        `id`,`name`,`datefrom`,`dateto`,`priority`,`locationname`,`status`,
                        DATE_FORMAT(`datefrom`, '%M %d,%Y') 'datefromformat',
                        DATE_FORMAT(`dateto`, '%M %d,%Y') 'datetoformat'
                    FROM
                        project
                    WHERE
                        `status` >= 2
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
    function get_projects_division_chief(){

    }
    function get_projects_budget_section(){

    }
    function get_projects_project_head(){

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
}