<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Mine_pump_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = [])
    {
        $this->db->select("mine_pump.*")->from("mine_pump"); 
        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function getAllById($where = [])
    {
        $this->db->select("mine_pump.*")->from("mine_pump");  

        $this->db->where($where);  
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function insert($data)
    {
        $this->db->insert("mine_pump", $data);
        return $this->db->insert_id();
    }

    public function insert_batch($data)
    {
        $this->db->insert_batch("mine_pump", $data);
        return $this->db->affected_rows();
    }

    public function update($data,$where = [])
    {
        $this->db->update("mine_pump", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where = [])
    {
        $this->db->where($where);
        $this->db->delete("mine_pump"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir, $where = [])
    {
        $this->db->select("mine_pump.*")->from("mine_pump");   
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
        $this->db->select("mine_pump.*")->from("mine_pump");   
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
