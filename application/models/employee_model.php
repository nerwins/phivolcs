<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/30/2016
 * Time: 4:16 PM
 */

class Employee_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function get_employees_list(){
        $id = $_SESSION['id'];
        $name = $this->input->get('name');
        $division = $this->input->get('division');
        $position = $this->input->get('position');
        $datefrom = $this->input->get('datefrom');
        $dateto = $this->input->get('dateto');

        $whereString = "";
        if(trim($name) != "")
            $whereString .= " AND CONCAT_WS(', ',`lastname`,`firstname`,`middleinitial`) LIKE '%".$name."%'";
        if($division != 0)
            $whereString .= " AND `division_id` = ". $division;
        if($position != 0)
            $whereString .= " AND `position_id` = ". $position;
        if(trim($datefrom) != "" && trim($dateto) != ""){
            $whereString .= " AND date_started >= '" .$datefrom ."'";
            $whereString .= " AND date_started <= '" .$dateto ."'";
        }
        if(trim($datefrom) != "" && trim($dateto) == "")
            $whereString .= " AND date_started = '" .$datefrom ."'";

        $query = "SELECT `id`, CONCAT_WS(', ', `lastname`,`firstname`) AS 'fullname',
                    CASE WHEN `division_id` = 1 THEN 'Volcanology'
                        WHEN `division_id` = 2 THEN 'Seismology'
                        WHEN `division_id` = 3 THEN 'Finance and Admin'
                        WHEN `division_id` = 4 THEN 'Research and Development'
                        ELSE 'Distaster Preparedness' END AS 'division',
                    CASE WHEN `position_id` = 1 THEN 'Director'
                        WHEN `position_id` = 2 THEN 'Division Chief'
                        WHEN `position_id` = 3 THEN 'Project Member' END AS 'position',
                    `date_started` AS 'datestarted'
                     FROM `employee`
                     WHERE `id` <> ? " .$whereString;
        $result = $this->db->query($query, array($id));
        if ($result->num_rows() > 0) {
            $employeesList = array();
            $i = 0;
            foreach ($result->result() as $row)
            {
                $employeesList[$i][0] = $row->id;
                $employeesList[$i][1] = $row->fullname;
                $employeesList[$i][2] = $row->division;
                $employeesList[$i][3] = $row->position;
                $employeesList[$i][4] = $row->datestarted;
                $i++;
            }
            return json_encode($employeesList);
        }else
            return json_encode("error");
    }
    function get_employee_detail(){
        $id = $this->input->get('id');
        $this->db->select('firstname, middleinitial, lastname, email, division_id, position_id');
        $this->db->where('id', $id);
        $query = $this->db->get('employee');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $employeeDetail[0] = $row->firstname;
            $employeeDetail[1] = $row->middleinitial;
            $employeeDetail[2] = $row->lastname;
            $employeeDetail[3] = $row->email;
            $employeeDetail[4] = ($row->division_id) - 1;
            $employeeDetail[5] = ($row->position_id) - 2;
            $skillsets = $this->get_employee_skillsets($id);
            $skillsets = $skillsets=="error"?[]:$skillsets;
            $employeeDetail[6] = $skillsets;
            return json_encode($employeeDetail);
        }else
            return json_encode("error");
    }
    function update_employee_detail(){
        $id = $this->input->post('employeeID');
        $fname = $this->input->post('employeeFName');
        $minitial = $this->input->post('employeeMInitial');
        $lname = $this->input->post('employeeLName');
        $email = $this->input->post('employeeEmail');
        $did = $this->input->post('employeeDID') + 1;
        $pid = $this->input->post('employeePID') + 2;
        $skillSets = $this->input->post('employeeSkillsets');
        if(!$this->check_existing_employee($id, $fname, $minitial, $lname)) {
            $this->db->trans_start();
            $data = array(
                'firstname' => $fname,
                'middleinitial' => $minitial,
                'lastname' => $lname,
                'email' => $email,
                'division_id' => $did,
                'position_id' => $pid
            );
            if ($id == 0) {
                $data['date_started'] = date("Y-m-d");
                $this->db->insert('employee', $data);
                $id = $this->db->insert_id();
            }else{
                $this->db->where('id', $id);
                $this->db->update('employee', $data);
            }
            $this->update_employee_skillset($skillSets,$id);
            $this->db->trans_complete();
        }else
            return json_encode("error");
    }
    function check_existing_employee($id, $fname, $minitial, $lname){
        if($id == 0){
            $query = "SELECT COUNT(*) AS 'exist' FROM `employee` AS E
                      WHERE E.`firstname` = ?
                      AND E.`middleinitial` = ?
                      AND E.`lastname` = ?";
            $result = $this->db->query($query, array($fname,$minitial,$lname));
        }else{
            $query = "SELECT COUNT(*) AS 'exist' FROM `employee` AS E
                      WHERE E.`firstname` = ?
                      AND E.`middleinitial` = ?
                      AND E.`lastname` = ?
                      AND E.`id` <> ?";
            $result = $this->db->query($query, array($fname,$minitial,$lname,$id));
        }
        $row = $result->row();
        return ($row->exist) > 0? true:false;
    }
    function delete_employee_detail(){
        $id = $this->input->post('employeeID');
        if(!$this->check_employee_has_task($id)){
            $this->db->trans_start();
            $this->db->where('id', $id);
            $this->db->delete('employee');
            $this->db->where('employeeid', $id);
            $this->db->delete('employee_has_skillset');
            $this->db->trans_complete();
        }else
            return json_encode("error");
    }
    function get_employee_skillsets($id){
        //$id = $this->input->get('employeeID');
        $this->db->select('skillsetid,name');
        $this->db->join('skillset', 'skillset.id = employee_has_skillset.skillsetid', 'left');
        $this->db->where('employeeid', $id);
        $this->db->group_by("skillsetid");
        $query = $this->db->get('employee_has_skillset');
        if ($query->num_rows() > 0) {
            $skillsetIDs = array();
            foreach ($query->result() as $row)
            {
                array_push($skillsetIDs,(int)$row->skillsetid);
            }
            return $skillsetIDs;
        }else
            return "error";
    }
    function update_employee_skillset($skillSets, $id){
        $data = array();
        $this->db->where('employeeid', $id);
        $this->db->delete('employee_has_skillset');
        for($x = 0; $x < count($skillSets);$x++){
            if(!empty($skillSets[$x])){
                $arr = array(
                    'employeeid' =>$id,
                    'skillsetid' =>$skillSets[$x]
                );
                array_push($data,$arr);
            }
        }
        if(count($data) > 0)
            $this->db->insert_batch('employee_has_skillset', $data);
    }
    function check_employee_has_task($id){
        $query = "SELECT SUM(CASE WHEN(status = 0)THEN 1 ELSE 0 END) AS 'hastask' FROM `employee_has_task`
                  WHERE empid = ?";
        $result = $this->db->query($query, array($id));
        $row = $result->row();
        return ($row->hastask) > 0? true:false;
    }
    function get_employee_project_load(){
        $employeeIDs = $this->input->get('employeeIDs');
        $this->db->select("id, CONCAT(`lastname`,' ',`firstname`,' ',`middleinitial`) 'name'");
        if(is_array($employeeIDs)){
            $this->db->where_in('id', $employeeIDs);
        }
        $query = $this->db->get('employee');
        if ($query->num_rows() > 0) {
            $employees = array();
            foreach ($query->result() as $row)
            {
                $employee[0] = $row->name;
                $employee[1] = $this->get_employee_projects_involved($row->id);
                array_push($employees,$employee);
            }
            return json_encode($employees);
        }else
            return "error";
    }
    function get_employee_projects_involved($id){
        $query = "SELECT 
                        P.`name`,P.`priority`,CONCAT(date_format(P.`datefrom`,'%M %d,%Y'),' - ',date_format(P.`dateto`,'%M %d,%Y')) AS 'date', P.`locationname`
                    FROM
                        `employee_has_task` AS EHT
                            LEFT JOIN
                        `task` AS T ON T.`id` = EHT.`taskid`
                            LEFT JOIN
                        `project` AS P ON P.`id` = T.`projectid`
                            AND P.`status` IN (5 , 6)
                    WHERE
                        EHT.`empid` = ?
                            AND P.`name` IS NOT NULL
                    ORDER BY P.`priority` DESC";
        $result = $this->db->query($query, array($id));
        if ($result->num_rows() > 0) {
            $project = "";
            $table = '<table style="margin-top:10px;" class="table table-bordered table-hover table-striped">';
            $table .= "<thead><tr><th>Project Name</th><th>Priority</th><th>Location</th><th>Date</th></tr></thead>";
            $table .= "<tbody>";
            foreach ($result->result() as $row)
            {
                $table .="<tr>";
                $table .="<td>" ."<b>" .$row->name . "</b></td>";
                $project .= "<b>" .$row->name . "</b> ";
                switch($row->priority){
                    case 1:
                        $table .="<td><label class='label label-success'>Low</label></td>";
                    break;
                    case 2:
                        $table .="<td><label class='label label-warning'>Medium</label></td>";
                    break;
                    case 3:
                        $table .="<td><label class='label label-danger'>High</label></td>";
                    break;
                }
                $table .="<td>" .$row->locationname . "</td>";
                $table .="<td>" .$row->date . "</td>";
                $table .="</tr>";
            }
            $table .= "</tbody>";
            $table .= "</table>";
            return $table;
        }else
            return "N/A";
    }
    function get_projects_and_employees(){
        $employeeID = $this->input->get('employeeID');
        $datefrom = $this->input->get('datefrom');
        $dateto = $this->input->get('dateto') ." 23:59:59";
        $query = "SELECT 
                    P.`id`,
                    P.`name`,
                    P.`priority`,
                    P.`locationname`,
                    CONCAT(DATE_FORMAT(P.`datefrom`, '%M %d,%Y'),
                            ' - ',
                            DATE_FORMAT(P.`dateto`, '%M %d,%Y')) AS 'date'
                FROM
                    `project` AS P
                WHERE P.`datefrom` >= ?
                AND P.`dateto` <= ?";
        $data = array($datefrom,$dateto);
        $result = $this->db->query($query, $data);
        if ($result->num_rows() > 0) {
            $projects = array();
            foreach ($result->result() as $row)
            {
                $project[0] = $row->name;
                switch($row->priority){
                    case 1:
                        $project[1] ="<td><label class='label label-success'>Low</label></td>";
                    break;
                    case 2:
                        $project[1] ="<td><label class='label label-warning'>Medium</label></td>";
                    break;
                    case 3:
                        $project[1] ="<td><label class='label label-danger'>High</label></td>";
                    break;
                }
                $project[2] = $row->locationname;
                $project[3] = $row->date;
                $project[4] = $this->get_employees_under_project($row->id,$employeeID);
                if($project[4] != "N/A")
                    array_push($projects,$project);
            }
            return json_encode($projects);
        }else
            return "error";
    }
    function get_employees_under_project($projectid,$employeeID){
        $query = "SELECT 
                    E.`id`, CONCAT(E.`lastname`, ', ', E.`firstname`, ' ', E.`middleinitial`) AS `name`
                FROM
                    `employee` AS E
                        LEFT JOIN
                    `employee_has_task` AS EHT ON EHT.`empid` = E.`id`
                        LEFT JOIN
                    `task` AS T ON T.`id` = EHT.`taskid`
                WHERE T.`projectid` = ?
                GROUP BY E.`id`
                ORDER BY `name` ASC";
        $result = $this->db->query($query, array($projectid));
        if ($result->num_rows() > 0) {
            $employees = "";     
            $x = 1;
            $ids = array();
            foreach ($result->result() as $row)
            {
                $format = $row->name."<br>";
                $employees .= $format;
                $x++;
                array_push($ids, $row->id);
            }
            $employees .= "<br>Total Employees: " .count($ids);
            if($employeeID != 0){
                if(in_array($employeeID,$ids))
                    return $employees;
                else
                    return "N/A";
            }else
                return $employees;
        }else
            return "N/A";
    }
}