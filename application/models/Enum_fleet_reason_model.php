<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Enum_fleet_reason_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct(); 
    }  

    public function getAllById($where = array()){
        $this->db->select("enum_fleet_reason.*, enum_fleet_status.name as status_name")->from("enum_fleet_reason");
        $this->db->join("enum_fleet_status", "enum_fleet_status.id = enum_fleet_reason.fleet_status_id");
        $this->db->where($where);  
        $this->db->order_by('enum_fleet_status.name', 'ASC'); 
        $this->db->order_by('enum_fleet_reason.name', 'ASC'); 

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function getOneBy($where = array()){
        $this->db->select("enum_fleet_reason.*")->from("enum_fleet_reason");  
        $this->db->where($where);  
        $this->db->order_by('enum_fleet_reason.name', 'ASC'); 

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    
    public function insert($data){
        $this->db->insert("enum_fleet_reason", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("enum_fleet_reason", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("enum_fleet_reason"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit = null,$start= null,$search= null,$col= null,$dir= null,$where=array())
    {
        $this->db->select("enum_fleet_reason.*")->from("enum_fleet_reason");
        $this->db->limit($limit,$start)->order_by($col,$dir) ;
        if(!empty($search)){
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);    
            }   
            $this->db->group_end();     
        }
        $this->db->where($where); 

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

    function getCountAllBy($limit = null,$start= null,$search= null,$col= null,$dir= null,$where=array())
    { 
        $this->db->select("enum_fleet_reason.*")->from("enum_fleet_reason");
        if(!empty($search)){
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);    
            }   
            $this->db->group_end();     
        }
        $this->db->where($where); 
        
        $result = $this->db->get();
    
        return $result->num_rows();
    } 
}
