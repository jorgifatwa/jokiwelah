<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Pencairan_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("order.*, sum(paket.harga) as gaji")->from("order");  
        $this->db->join("paket", "paket.id = order.id_paket");
        $this->db->join("joki", "joki.id = order.id_joki");
        $this->db->where("order.is_deleted",0);  
        $this->db->where("order.status_orderan",3);  
        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function getAllById($where = array()){
        $this->db->select("order.*")->from("order");  
        $this->db->join("paket", "paket.id = order.id_paket");
        $this->db->join("joki", "joki.id = order.id_joki");
        $this->db->where("order.is_deleted",0);  
        $this->db->where("order.status_orderan",3);  
        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("pencairan", $data);
        return $this->db->insert_id();
    }

    public function insert_file($data){
        $this->db->insert("bukti_pengerjaan", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("order", $data, $where);
        return $this->db->affected_rows();
    }

    public function update_pendapatan($data,$where){
        $this->db->update("pendapatan", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("order"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir)
    {
        $this->db->select("pendapatan.*, sum(pendapatan.total_pendapatan) as total_pendapatan, users.first_name as joki_name")->from("pendapatan");   
        $this->db->join("users", "users.id = pendapatan.id_user");
        $this->db->where("pendapatan.is_deleted",0);  
        $this->db->where("pendapatan.status",0);  
        $this->db->group_by("pendapatan.id_user");  
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
        $this->db->select("pendapatan.*, sum(pendapatan.total_pendapatan) as total_pendapatan, users.first_name as joki_name")->from("pendapatan");   
        $this->db->join("users", "users.id = pendapatan.id_user");
        $this->db->where("pendapatan.is_deleted",0);  
        $this->db->where("pendapatan.status",0);  
        $this->db->group_by("pendapatan.id_user");  
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
