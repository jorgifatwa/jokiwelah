<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Rns_plan_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("rns_plan.*")->from("rns_plan"); 
        $this->db->where($where);  
        $this->db->where("rns_plan.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    public function getAllById($where = array()){
        $this->db->select("rns_plan.*")->from("rns_plan");  
        $this->db->order_by("tanggal", "asc");
        $this->db->where($where);  
        $this->db->where("rns_plan.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("rns_plan", $data);
        return $this->db->insert_id();
    }

    public function insert_batch($data){
        $this->db->insert_batch("rns_plan", $data);
        return $this->db->affected_rows();
    }

    public function update($data,$where){
        $this->db->update("rns_plan", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("rns_plan"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir, $bulan, $tahun)
    {
        $this->db->select("rns_plan.*")->from("rns_plan");   
        $this->db->where("DATE_FORMAT(tanggal,'%m')", $bulan);
        $this->db->where("DATE_FORMAT(tanggal,'%Y')", $tahun);
        $this->db->group_by("tanggal");
        // $this->db->count('id');
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

    function getCountAllBy($limit,$start,$search,$order,$dir, $bulan, $tahun)
    { 
        $this->db->select("rns_plan.*")->from("rns_plan"); 
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

    function getAllGroupBy($where = [], $search = [])
    {
        $this->db->select("location.id, location.name,
                           SUM(rns_plan.rns) as total_rns, SUM(rns_plan.rainfall) as total_rainfall,
                           DAY(rns_plan.tanggal) as tanggal")->from("rns_plan");   
        $this->db->join("location", "location.id = rns_plan.location_id");
        $this->db->group_by("rns_plan.tanggal, location.id");
        $this->db->order_by("rns_plan.tanggal", "ASC");

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
}
