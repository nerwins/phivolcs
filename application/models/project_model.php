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
        $query = "SELECT `id`,`name`,`datefrom`,`dateto`,`priority`,`description`,`significance`,`emp_stat`,
                        `latitude`,`empid`,`longitude`,`createdby`,`background`,`locationname`,`status`,
                        date_format(`datefrom`,'%M %d,%Y') 'datefromformat',date_format(`dateto`,'%M %d,%Y') 'datetoformat'
                    FROM project
                    WHERE `id`  =? ";
        $result = $this->db->query($query, array($projectid));
        if ($result->num_rows() > 0) {
            $row = $result->row();
            $project['id'] = $row->id;
            $project['datefromformat'] = $row->datefromformat;
            $project['datetoformat'] = $row->datetoformat;
            $project['name'] = $row->name;
            $project['datefrom'] = $row->datefrom;
            $project['dateto'] = $row->dateto;
            $project['priority'] = $row->priority;
            $project['description'] = $row->description;
            $project['significance'] = $row->significance;
            $project['emp_stat'] = $row->emp_stat;
            $project['latitude'] = $row->latitude;
            $project['empid'] = $row->empid;
            $project['longitude'] = $row->longitude;
            $project['createdby'] = $row->createdby;
            $project['background'] = $row->background;
            $project['locationname'] = $row->locationname;
            $project['status'] = $row->status;
            return json_encode($project);
        }else
            return json_encode("error");
    }
}