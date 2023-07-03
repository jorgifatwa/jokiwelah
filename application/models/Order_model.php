<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Order_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("order.*")->from("order"); 
        $this->db->where($where);  
        $this->db->where("order.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function getTotal($where = array()){
        $this->db->select("count(order.id) as total")->from("order");  
        $this->db->where($where);  
        $this->db->where("order.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    public function getAllById($where = array()){
        $this->db->select("order.*,pelayanan.name as pelayanan_name, dari_rank.name as dari_rank_name, sampai_rank.name as sampai_rank_name")->from("order");   
        $this->db->join("pelayanan", "pelayanan.id = order.id_pelayanan");
        $this->db->join("rank as dari_rank", "dari_rank.id = order.dari_rank");
        $this->db->join("rank as sampai_rank", "sampai_rank.id = order.sampai_rank");
        $this->db->where($where);  
        $this->db->where("order.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("order", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("order", $data, $where);
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

    function getAllBy($limit,$start,$search,$col,$dir, $where = array())
    {
        $this->db->select("order.*,pelayanan.name as pelayanan_name")->from("order");   
        $this->db->join("pelayanan", "pelayanan.id = order.id_pelayanan");
        $this->db->where($where);  
        $this->db->where("order.is_deleted",0);  
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

    function getCountAllBy($limit,$start,$search,$order,$dir, $where = array())
    { 
        $this->db->select("order.*, pelayanan.name as pelayanan_name")->from("order"); 
        $this->db->join("pelayanan", "pelayanan.id = order.id_pelayanan");
        $this->db->where($where);  
        $this->db->where("order.is_deleted",0);  
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

    public function make_id()
    {
        $this->db->select('RIGHT(order.id,6) as kode', FALSE);
        $this->db->order_by('id','DESC');
        $this->db->limit(1);

        $query = $this->db->get('order');

        if ($query->num_rows()<>0) {
        	$data = $query->row();
        	$kode = intval($data->kode)+1;
        }else{
        	$kode = 1;
        }
        $kode_max= str_pad($kode,6,"0",STR_PAD_LEFT);
        $kode_jadi = "NF0".$kode_max;
        return $kode_jadi;
    }
}
