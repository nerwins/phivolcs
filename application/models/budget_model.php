<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 2/18/2016
 * Time: 07:51 AM
 */

class Budget_model extends CI_Model {
	function __construct() {
        parent::__construct();
    }

    function get_total_project_budget($id){
        $this->db->select('sum(amount) AS `total`');
        $this->db->where('projectid', $id); 
        $this->db->group_by("projectid"); 
        $query = $this->db->get('budget');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return number_format($row->total,1);
        }
        return 0;
    }
    function get_project_budgets($id){
        $this->db->select("id,expense,expense_type,qty,amount");
        $this->db->where('projectid', $id); 
        $query = $this->db->get('budget');
        if($query->num_rows() > 0){
            $budgets = array();
            foreach ($query->result() as $row){
                $budget[0] = $row->id;
                $budget[1] = $row->expense;
                $expenseTypes = array("General Expenses","Equipment Expenses");
                $budget[2] = $expenseTypes[$row->expense_type - 1];
                $budget[3] = $row->qty;
                $budget[4] = "Php " . number_format($row->amount,1);
                array_push($budgets,$budget);
            }
            return $budgets;
        }else
            return "error";
    }
    function delete_budget_log_details($projectid){
        $query = "DELETE FROM `budget_logdetails`
                    WHERE `budgetlogid` IN
                    (SELECT `id` FROM budget_log WHERE `projectid`=?)";
        $this->db->query($query, array($projectid));
        return;
    }
    function delete_budget_logs($projectid){
        $this->db->delete('budget_log', array('projectid' => $projectid)); 
    }
    function add_expense($expenseName){
        $data = array(
            'expense' =>$expenseName
        );   
        $this->db->insert('general_expenses', $data); 
        return;
    }
    function get_total_proposed_and_actual_project_budget($id){
        $this->db->select('sum(proposedamount) AS `totalproposed`,sum(amount) AS `totalactual`');
        $this->db->where('projectid', $id); 
        $this->db->group_by("projectid"); 
        $query = $this->db->get('budget');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return [number_format($row->totalproposed,1),number_format($row->totalactual,1)];
        }
        return [0,0];
    }
}