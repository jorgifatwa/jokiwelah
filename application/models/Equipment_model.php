<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Equipment_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("enum_equipment_event.*")->from("enum_equipment_event"); 
        $this->db->where($where);  
        $this->db->where("enum_equipment_event.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function getTotal($where = array()){
        $this->db->select("count(enum_equipment_event.id) as total")->from("enum_equipment_event");  
        $this->db->where($where);  
        $this->db->where("enum_equipment_event.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    public function getAllById($where = array()){
        $this->db->select("enum_equipment_event.*")->from("enum_equipment_event");  

        $this->db->where($where);  
        $this->db->where("enum_equipment_event.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("enum_equipment_event", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("enum_equipment_event", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("enum_equipment_event"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir)
    {
        $this->db->select("enum_equipment_event.*, location.name as location_name, seam.name as seam_name")->from("enum_equipment_event");   
        $this->db->join("seam", "seam.id = enum_equipment_event.seam_id");
        $this->db->join("location", "location.id = enum_equipment_event.location_id");
        $this->db->where("enum_equipment_event.is_deleted",0);  
        $this->db->limit($limit,$start)->order_by($col,$dir);
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

    function getCountAllBy($limit,$start,$search,$order,$dir)
    { 
        $this->db->select("enum_equipment_event.*, location.name as location_name, seam.name as seam_name")->from("enum_equipment_event");   
        $this->db->join("seam", "seam.id = enum_equipment_event.seam_id");
        $this->db->join("location", "location.id = enum_equipment_event.location_id");
        $this->db->where("enum_equipment_event.is_deleted",0);  
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
}
