<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Plan_activity_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = [])
    {
        $this->db->select("plan_activity.*")->from("plan_activity"); 
        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function getAllById($where = [])
    {
        $this->db->select("plan_activity.*")->from("plan_activity");  

        $this->db->where($where);  
        $this->db->where("plan_activity.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function insert($data)
    {
        $this->db->insert("plan_activity", $data);
        return $this->db->insert_id();
    }

    public function insert_batch($data)
    {
        $this->db->insert_batch("plan_activity", $data);
        return $this->db->affected_rows();
    }

    public function update($data,$where = [])
    {
        $this->db->update("plan_activity", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where = [])
    {
        $this->db->where($where);
        $this->db->delete("plan_activity"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir, $where = [])
    {
        $this->db->select("plan_activity.*, location.name as location_name")->from("plan_activity");   
        $this->db->join("location", "location.id = plan_activity.location_id");
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

    function getCountAllBy($limit,$start,$search,$order,$dir, $where = [])
    { 
        $this->db->select("plan_activity.*, location.name as location_name")->from("plan_activity");   
        $this->db->join("location", "location.id = plan_activity.location_id");
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
}
