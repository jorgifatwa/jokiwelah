<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Set_bintang_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("star_price.*")->from("star_price"); 
        $this->db->where($where);  
        $this->db->where("star_price.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function getAllById($where = array()){
        $this->db->select("star_price.*, rank.name as rank_name, rank.batas_point as batas_point")->from("star_price");   
        $this->db->join("rank", "rank.id = star_price.rank_id");
        $this->db->where($where);  
        $this->db->where("star_price.is_deleted",0);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("star_price", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("star_price", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("star_price"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir)
    {
        $this->db->select("star_price.*, rank.name as rank_name")->from("star_price");   
        $this->db->join("rank", "rank.id = star_price.rank_id");
        $this->db->where("star_price.rank_id < ",6);  
        $this->db->where("star_price.is_deleted",0);  
        $this->db->order_by('rank_id');  
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
        $this->db->select("star_price.*, rank.name as rank_name")->from("star_price");   
        $this->db->join("rank", "rank.id = star_price.rank_id");
        $this->db->where("star_price.rank_id < ",6);  
        $this->db->where("star_price.is_deleted",0);  
        $this->db->order_by('rank_id');  
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
