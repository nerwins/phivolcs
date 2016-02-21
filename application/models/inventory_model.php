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
}