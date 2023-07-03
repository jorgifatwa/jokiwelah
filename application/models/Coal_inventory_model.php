<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Coal_inventory_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct(); 
    }  

    public function getOneBy($where = array()){
        $this->db->select("coal_inventory.*")->from("coal_inventory");

        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    public function getAllById($where = array()){
        $this->db->select("coal_inventory.*")->from("coal_inventory");  
        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    
    public function insert($data){
        $this->db->insert("coal_inventory", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("coal_inventory", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("coal_inventory"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    public function getAllBy($limit,$start,$search,$col,$dir,$where = [])
    {
        $this->db->select("coal_inventory.*, location.name as location_name, pit.name as pit_name")->from("coal_inventory");   
        $this->db->join("location", "location.id = coal_inventory.location_id");
        $this->db->join("pit", "pit.id = coal_inventory.pit_id");

        $this->db->limit($limit,$start)->order_by($col,$dir);
        $this->db->where($where);
        if(!empty($search)){
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);    
            }   
            $this->db->group_end();
        } 

        $result = $this->db->get();
        if($result->num_rows()>0)
        {
            return $result->result();  
        }
        else
        {
            return null;
        }
    }

    public function getCountAllBy($limit,$start,$search,$order,$dir,$where = [])
    { 
        $this->db->select("coal_inventory.id")->from("coal_inventory");   
        $this->db->join("location", "location.id = coal_inventory.location_id");
        $this->db->join("pit", "pit.id = coal_inventory.pit_id");
        $this->db->where($where);
        if(!empty($search)){
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);    
            }   
            $this->db->group_end();
        } 
 
        $result = $this->db->get();
    
        return $result->num_rows();
    } 

    public function getAllByPit($where = [])
    {
        $this->db->select("SUM(coal_inventory.tonase) as total_tonase, pit.name as pit_name")->from("coal_inventory"); 
        $this->db->join("pit", "pit.id = coal_inventory.pit_id");
        $this->db->where($where);  
        $this->db->order_by("pit.name", "ASC");
        $this->db->group_by("pit.name");

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
}
