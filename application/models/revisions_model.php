<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 2/18/2016
 * Time: 08:10 AM
 */

class Revisions_model extends CI_Model {
	function __construct() {
        parent::__construct();
        $this->load->model("tasks_model");
        $this->load->model("employee_model");
        $this->load->model("objectives_model");
        $this->load->model("outputs_model");
        $this->load->model("project_model");
    }

    function get_director_comments($projectid,$position,$projectstatus){
        $this->db->select("`section`,`comment`");
        $this->db->where('pid',$projectid);
        $query = $this->db->get('director_revisions');
        if($query->num_rows() > 0){
            $comments = array();
            if($position == 1 || $position == 2 && $projectstatus == 2)
                foreach ($query->result() as $row){
                    $comment[0] = $row->section;
                    $comment[1] = $row->comment;
                    array_push($comments,$comment);
                }
            return $comments;
        }else
            return "error";
    }
    function add_revision_comments($section,$comment,$projectid){
        $data = array(
            'section' => $section,
            'comment' => $comment,
            'pid' => $projectid,
        );
        $this->db->insert('director_revisions', $data); 
        return;
    }
    function delete_director_revisions($projectid){
        $this->db->delete('director_revisions', array('pid' => $projectid));    
    }
    function approve_revisions(){
        $projectid = $this->input->post('id');
        $revisions = json_decode($this->input->post('revisions'));
        $this->project_model->update_project_status(2,$projectid);
        for($x = 0; $x < count($revisions); $x++){
            $comment = $revisions[$x]->comment;
            $section = $revisions[$x]->id;
            $this->add_revision_comments($section,$comment,$projectid);
        }
    }
    function update_revisions(){
        $projectid = $this->input->post('id');
        $employeeid = $_SESSION['id'];
        $description = $this->input->post('description');
        $background = $this->input->post('background');
        $significance = $this->input->post('significance');
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');
        $locationname = $this->input->post('locationname');
        $oldworkplans = json_decode($this->input->post('oldworkplans'),true);
        $newworkplans = json_decode($this->input->post('newworkplans'),true);
        $oldobjectives = json_decode($this->input->post('oldobjective'));
        $newobjectives = json_decode($this->input->post('newobjective'));
        $oldoutputs = json_decode($this->input->post('oldoutputs'));
        $newoutputs = json_decode($this->input->post('newoutputs'));
        if($oldworkplans != ""){
            for($x = 0; $x < count($oldworkplans); $x++){
                $owp = $oldworkplans[$x];
                $this->tasks_model->delete_employee_task($owp['id']);
                $this->tasks_model->delete_task_skillset($owp['id']);
                if((int)$owp['type'] == 1){
                    if((int)$owp['inv'] == 1)
                        $this->employee_model->add_task_to_employee($owp['id']);
                    for($y = 0; $y < count($oldworkplans[$x]['workskills']); $y++){
                        $ws = $owp['workskills'][$y];
                        $this->tasks_model->add_skillset_to_task($ws,$owp['id']);
                    }
                    $fromto = $this->convertFormattedDate($owp['taskfrom'],$owp['taskto']);
                    $this->tasks_model->update_task($owp['name'],$owp['milestone'],$fromto[0],$fromto[1],(int)$owp['numemp'],(int)$owp['priority'],$owp['outputs'],(int)$owp['id']);
                }else
                    $this->tasks_model->delete_task($owp['id']);
            }
        }
        if($newworkplans != ""){
            for($x = 0; $x < count($newworkplans); $x++){
                $nwp = $newworkplans[$x];
                $fromto = $this->convertFormattedDate($nwp['taskfrom'],$owp['taskto']);
                update_task($nwp['name'],$nwp['milestone'],$fromto[0],$fromto[1],(int)$nwp['numemp'],(int)$nwp['priority'],$nwp['outputs'],0);
                $id = $this->task_model->get_last_inserted_task();
                for($y = 0; count($nwp->workskills); $y++){
                    $ws = $nwp['workskills'][$y];
                    $this->tasks_model->add_skillset_to_task($ws,$nwp['id']);
                }
                if((int)$nwp['inv'] == 1)
                        $this->employee_model->add_task_to_employee($id);
            }
        }
        if($oldobjectives != ""){
            for($x = 0; $x < count($oldobjectives); $x++){
                $oo = $oldobjectives[$x];
                if((int)$oo->stat == 1)
                    $this->objectives_model->update_objective($oo->value,$oo->id);
                else
                    $this->objectives_model->delete_objective($oo->id);
            }
        }
        if($newobjectives != ""){
            for($x = 0; $x < count($newobjectives); $x++){
                $no = $newobjectives[$x];
                $this->objectives_model->add_objective($oo->value, $projectid);
            }
        }
        if($oldoutputs != ""){
            for($x = 0; $x < count($oldoutputs); $x++){
                $oo = $oldoutputs[$x];
                if((int)$oo->type == 1)
                    $this->outputs_model->update_output($oo->eoutput, $oo->pindicator, (int)$oo->id);
                else
                    $this->outputs_model->delete_output((int)$oo->id);
            }
        }
        if($newoutputs != ""){
            for($x = 0; $x < count($newoutputs); $x++){
                $no = $newoutputs[$x];
                $this->outputs_model->update_output($no->eoutput, $no->pindicator, 0, $projectid);
            }
        }
        /*$this->project_model->update_project_details($description,$background,$significance,$latitude,$longitude,$locationname,$projectid);
        $this->delete_director_revisions($projectid);*/
    }

    function convertFormattedDate($datefrom, $dateto){
        //converts the pair of formatted dates to a format accepted by the database.
        $months = ['January','February','March','April','May',
                'June','July','August','September','October','November','December'];
        $dates = array($datefrom, $dateto);
        $formattedDates = array();
        for($x = 0; $x < count($dates); $x++){
            $date = $dates[$x];
            $datearray = explode(" ",$date);
            $datekey = array_search($datearray[0],$months);
            $month = sprintf("%02d", $datekey);
            $day = str_replace(",","",$datearray[1]);
            $year = $datearray[2];
            $formattedDate = $year .'-' .$month .'-' .$day;
            array_push($formattedDates, $formattedDate);
        }
        return $formattedDates;
    }
}
