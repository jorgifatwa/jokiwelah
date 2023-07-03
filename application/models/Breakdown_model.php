<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Breakdown_model extends CI_Model 
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("breakdown.*")->from("breakdown"); 
        $this->db->where($where);  
        $this->db->where("breakdown.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    public function getAllById($where = array()){
        $this->db->select("breakdown.*")->from("breakdown");  

        $this->db->where($where);  
        $this->db->where("breakdown.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("breakdown", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("breakdown", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("breakdown"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir){
        $this->db->select("breakdown.*, unit.kode as loading_unit_name, enum_breakdown_job_status.name as job_status_name, enum_breakdown_job_status.description as job_description, location.name as location_name")->from("breakdown");   
        $this->db->join("unit", "unit.id = breakdown.unit_id");
        $this->db->join("enum_breakdown_job_status", "enum_breakdown_job_status.id = breakdown.job_status_id");
        $this->db->join("location", "location.id = breakdown.location_id");
        $this->db->where("breakdown.is_deleted",0);  
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
        $this->db->select("breakdown.*, unit.kode as loading_unit_name, enum_breakdown_job_status.name as job_status_name, enum_breakdown_job_status.description as job_description, location.name as location_name")->from("breakdown");   
        $this->db->join("unit", "unit.id = breakdown.unit_id");
        $this->db->join("enum_breakdown_job_status", "enum_breakdown_job_status.id = breakdown.job_status_id");
        $this->db->join("location", "location.id = breakdown.location_id");
        $this->db->where("breakdown.is_deleted",0);  
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

    public function getReasonData($where = array()){
        $this->db->select("enum_fleet_reason.*")->from("enum_fleet_reason");  

        $this->db->where($where);  
        $this->db->where("enum_fleet_reason.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function getTotal($where = array()){
        $this->db->select("count(breakdown.id) as total")->from("breakdown");  
        $this->db->where($where);  
        $this->db->where("breakdown.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
}
