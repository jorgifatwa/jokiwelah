<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Fuel_stock_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct(); 
    }  

    public function getOneBy($where = array()){
        $this->db->select("fuel_stock.*")->from("fuel_stock");

        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    public function getAllById($where = array()){
        $this->db->select("fuel_stock.*")->from("fuel_stock");  
        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    
    public function insert($data){
        $this->db->insert("fuel_stock", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("fuel_stock", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("fuel_stock"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    public function getAllBy($limit,$start,$search,$col,$dir,$where = [])
    {
        $this->db->select("fuel_stock.*, location.name as location_name")->from("fuel_stock");   
        $this->db->join("location", "location.id = fuel_stock.location_id");

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
        $this->db->select("fuel_stock.id")->from("fuel_stock");   
        $this->db->join("location", "location.id = fuel_stock.location_id");
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

    public function getTotal($where)
    {
        $this->db->select("SUM(nilai) as total")->from("fuel_stock");
        $this->db->where($where);  
        $this->db->where("is_deleted", 0);
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row()->total; 
        } 
        return 0;
    }

    public function getStockLatest($where)
    {
        $this->db->select("fuel_stock.current_stock, fuel_stock.id")->from("fuel_stock");
        $this->db->order_by("updated_at", "desc");
        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
}
