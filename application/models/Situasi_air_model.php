<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Situasi_air_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct(); 
    }  
    
    public function getOneBy($where = array())
    {
        $this->db->select("situasi_air.*")->from("situasi_air"); 
        $this->db->where($where);  
        $this->db->where("situasi_air.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function getAllById($where = array())
    {
        $this->db->select("situasi_air.*")->from("situasi_air");  

        $this->db->where($where);  
        $this->db->where("situasi_air.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function insert($data)
    {
        $this->db->insert("situasi_air", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where)
    {
        $this->db->update("situasi_air", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where)
    {
        $this->db->where($where);
        $this->db->delete("situasi_air"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir,$where=[])
    {
        $this->db->select("situasi_air.*, location.name as location_name")->from("situasi_air");   
        $this->db->join("location", "location.id = situasi_air.location_id");
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
        $this->db->select("situasi_air.*, location.name as location_name")->from("situasi_air");  
        $this->db->join("location", "location.id = situasi_air.location_id");
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
        $this->db->select("count(situasi_air.id) as total")->from("situasi_air");  
        $this->db->where($where);  
        $this->db->where("situasi_air.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function getLatest($where = array())
    {
        $this->db->select("situasi_air.*")->from("situasi_air"); 
        $this->db->where($where);  
        $this->db->where("situasi_air.is_deleted",0);  
        $this->db->order_by("situasi_air.waktu", "desc");

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
}