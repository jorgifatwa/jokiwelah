<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class equipment_event_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct(); 
    }  

    public function getOneBy($where = array()){
        $this->db->select("equipment_event.*")->from("equipment_event");

        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    public function getAllById($where = array()){
        $this->db->select("equipment_event.*, unit.kode, enum_equipment_event.name as event_name")->from("equipment_event");  
        $this->db->join("dewatering_pump", "dewatering_pump.id = equipment_event.dewatering_pump_id");
        $this->db->join("unit", "unit.id = equipment_event.unit_id");
        $this->db->join("enum_equipment_event", "enum_equipment_event.id = equipment_event.equipment_id");
        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    
    public function insert($data){
        $this->db->insert("equipment_event", $data);
        return $this->db->insert_id();
    }

    public function insert_batch($data){
        $this->db->insert_batch("equipment_event", $data);
        return $this->db->affected_rows();
    }

    public function update($data,$where){
        $this->db->update("equipment_event", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("equipment_event"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    public function getAllBy($limit,$start,$search,$col,$dir,$where = [])
    {
        $this->db->select("equipment_event.*")->from("equipment_event");   

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
        $this->db->select("equipment_event.*")->from("equipment_event");   
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
