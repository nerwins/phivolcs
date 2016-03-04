<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 2/18/2016
 * Time: 07:51 AM
 */

class Inventory_model extends CI_Model {
	function __construct() {
        parent::__construct();
    }

    function check_existing_inventory($expenseName,$type){
        $this->db->select("count(`id`) AS 'count'");
        if($type == 0){
            $this->db->where('name',$expenseName);
            $query = $this->db->get('inventory');
        }elseif($type == 1){
            $this->db->where('expense',$expenseName);
            $query = $this->db->get('general_expenses');
        }
        $row = $query->row();
        return $row->count;
    }
    function update_inventory_in_use($qty,$expenseName){
        $query = "UPDATE `inventory`  
                        SET `qtyinuse`=`qtyinuse` + ? 
                    WHERE `name`= ? 
                        AND not (`qtyinuse` + ? >`qty`)";
        $this->db->query($query, array($qty,$expenseName,$qty));
        return;
    }
    function update_inventory($qty,$expenseName){
        $query = "UPDATE `inventory`
                        SET `qty` = `qty` + ?
                    WHERE `name` = ? ";
        $this->db->query($query, array($qty,$expenseName));
        return;
    }
    function add_inventory($qty,$expenseName){
        $data = array(
            'name' =>$expenseName,
            'qty' =>$qty,
            'qtyinuse' =>$qty
            );
        $this->db->insert('inventory', $data); 
        return;
    }
    function get_project_inventory(){
        $equipment = $this->input->get('equipment');
        $whereCondition = "";
        if(strlen($equipment) > 1)
            $whereCondition .= " AND I.`name` LIKE '%" .$equipment ."%' ";

        $query = "SELECT 
                    I.`id`,I.`name` AS 'inv',I.`qty`,I.`qtyinuse`,(I.`qty` + I.`qtyinuse`) AS 'totalqty',I.`average_price`
                FROM
                    `inventory` AS I
                WHERE 1=1 ".$whereCondition;
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            $inventories = array();
            foreach ($result->result() as $row){
                $inventory[0] = $row->id;
                $inventory[1] = $row->inv;
                $inventory[2] = $row->qty;
                $inventory[3] = $row->qtyinuse;
                $inventory[4] = $row->totalqty;
                $inventory[5] = number_format($row->average_price,1);
                array_push($inventories,$inventory);
            }
            return json_encode($inventories);
        }else
            return json_encode("error");
    }
    function get_inventory_list_dropdown(){
        $this->db->select("id,name");
        $this->db->group_by("name"); 
        $query = $this->db->get('inventory');
        if ($query->num_rows() > 0) {
            $equipments = array();
            foreach ($query->result() as $row){
                $equipment[0] = $row->id;
                $equipment[1] = $row->name;
                array_push($equipments,$equipment);
            }
            return json_encode($equipments);
        }else
            return json_encode("error");
    }
}