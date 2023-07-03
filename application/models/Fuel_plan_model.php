<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Fuel_plan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct(); 
    }  

    public function getOneBy($where = array()){
        $this->db->select("fuel_plan.*")->from("fuel_plan");

        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    public function getAllById($where = array()){
        $this->db->select("fuel_plan.*, unit.kode, location.name, unit_model.name as model_name, unit_brand.name as brand_name")->from("fuel_plan");  
        $this->db->join("location", "location.id = fuel_plan.location_id");
        $this->db->join("unit", "unit.id = fuel_plan.unit_id");
        $this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
        $this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    
    public function insert($data){
        $this->db->insert("fuel_plan", $data);
        return $this->db->insert_id();
    }

    public function insert_batch($data){
        $this->db->insert_batch("fuel_plan", $data);
        return $this->db->affected_rows();
    }

    public function update($data,$where){
        $this->db->update("fuel_plan", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("fuel_plan"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    public function getAllBy($limit,$start,$search,$col,$dir,$where = [])
    {
        $this->db->select("fuel_plan.*, location.name as location_name")->from("fuel_plan");   
        $this->db->join("location", "location.id = fuel_plan.location_id");

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
        $this->db->select("fuel_plan.id")->from("fuel_plan");   
        $this->db->join("location", "location.id = fuel_plan.location_id");
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

    public function getAllGroupByUnit($where = array()){
        $this->db->select("fuel_plan.*, SUM(fuel_plan.nilai) as total, unit.kode, location.name, unit_model.name as model_name, unit_brand.name as brand_name")->from("fuel_plan");  
        $this->db->join("location", "location.id = fuel_plan.location_id");
        $this->db->join("unit", "unit.id = fuel_plan.unit_id");
        $this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
        $this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
        $this->db->where($where);  
        $this->db->group_by(["unit.id", "fuel_plan.tanggal"]);
        $this->db->order_by("unit.kode", "ASC");
        $this->db->order_by("fuel_plan.tanggal", "ASC");

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
}
