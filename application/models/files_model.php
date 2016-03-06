<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 2/19/2016
 * Time: 06:43 PM
 */

class Files_model extends CI_Model {
	function __construct() {
        parent::__construct();
        $this->load->model("notification_model");
    }

    function save_file(){
    	$files = $this->input->post('files');
    	$projectid = $this->input->post('projectid');
    	$uploader = $_SESSION['id'];
    	$this->db->trans_start();
    	for($x = 0; $x < count($files); $x++){
    		$file = $files[$x]['name'];
    		$size = $this->formatSizeUnits((int)$files[$x]['size']);
    		$this->modify_files_in_folders($file,1);
    		$this->db->delete('project_files', array('filename' => $file,'projectid' => $projectid));
	    	$data = array(
	                'projectid' => $projectid,
	                'filename' => $file,
	                'uploader' => $uploader,
	                'filesize' => $size
	            );
	    	$this->db->set('date', 'NOW()', FALSE);
	    	$this->db->insert('project_files', $data);
	    	$this->modify_files_in_folders($file,0);
	    }
	    $this->db->trans_complete();
        //testing: $this->notification_model->new_notification($uploader, "New file uploaded!", 1, $projectid, [1,2]);
    	return;
    }
    function delete_file(){
    	$filename = $this->input->post('filename');
    	$projectid = $this->input->post('projectid');
    	$this->db->delete('project_files', array('filename' => $filename,'projectid' => $projectid));
    	return;
    }
    function get_file_list(){
    	$projectid = $this->input->get('projectid');
    	$query = "SELECT 
				    P.`id` AS 'id',
				    `filename`,
				    `filesize`,
				    CONCAT(E.`firstname`, ' ', E.`lastname`) AS 'uploader',
				    `date`
				FROM
				    `project_files` AS P
				        LEFT JOIN
				    `employee` AS E ON E.`id` = P.`uploader`
				WHERE
				    `projectid` = ?";
				    echo $this->db->last_query();
		$result = $this->db->query($query, array($projectid));
    	if ($result->num_rows() > 0){
    		$filelist = array();
    		foreach ($result->result() as $row){
    			$file[0] = $row->id;
    			$file[1] = $row->filename;
    			$file[2] = $row->filesize;
    			$file[3] = $row->uploader;
    			$file[4] = $row->date;
    			array_push($filelist,$file);
    		}
    		return json_encode($filelist);
    	}else
    		return json_encode("error");
    }
    function formatSizeUnits($bytes){
        if ($bytes >= 1073741824)
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        elseif ($bytes >= 1048576)
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        elseif ($bytes >= 1024)
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        elseif ($bytes > 1)
            $bytes = $bytes . ' bytes';
        elseif ($bytes == 1)
            $bytes = $bytes . ' byte';
        else
            $bytes = '0 bytes';
        return $bytes;
	}
	function modify_files_in_folders($filename,$action){
		switch($action){
			case 0:
				//copy
				copy("C:/Source/".$filename, 'C:/Uploads/'.$filename);
			break;
			case 1:
				//delete
				if(file_exists('C:/Uploads/'.$filename))
					unlink("C:/Uploads/".$filename);
			break;
			case 2:
				//download
				copy("C:/Uploads/".$filename, 'C:/Downloads/'.$filename);
			break;
		}
	}
	function download_file(){
		$filename = $this->input->post('filename');
		$this->modify_files_in_folders($filename,2);
	}
}