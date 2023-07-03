<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Disposal_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("disposal.*")->from("disposal"); 
        $this->db->where($where);  
        $this->db->where("disposal.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    public function getAllById($where = array()){
        $this->db->select("disposal.*")->from("disposal");  

        $this->db->where($where);  
        $this->db->where("disposal.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("disposal", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("disposal", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("disposal"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir,$where=[])
    {
        $this->db->select("disposal.*, location.name as location_name")->from("disposal");  
        $this->db->join("location", "location.id = disposal.location_id"); 
        $this->db->where("disposal.is_deleted",0);  

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

    function getCountAllBy($limit,$start,$search,$order,$dir,$where=[])
    { 
        $this->db->select("disposal.id")->from("disposal"); 
        $this->db->join("location", "location.id = disposal.location_id");   
        $this->db->where("disposal.is_deleted",0);  
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

    public function getTotal($where = array()){
        $this->db->select("count(disposal.id) as total")->from("disposal");  
        $this->db->where($where);  
        $this->db->where("disposal.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
}
