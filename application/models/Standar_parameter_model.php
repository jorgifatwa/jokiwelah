<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Standar_parameter_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct(); 
    }  
    public function getOneBy($where = array()){
        $this->db->select("standar_parameter.*")->from("standar_parameter"); 
        $this->db->where($where);

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function getTotal($where = array()){
        $this->db->select("count(standar_parameter.id) as total")->from("standar_parameter");  
        $this->db->where($where);

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    public function getAllById($where = array()){
        $this->db->select("standar_parameter.*, MONTH(tanggal) as bulan")->from("standar_parameter");  
        $this->db->where($where);  
        // $this->db->where("standar_parameter.is_deleted",0);  
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    public function insert($data){
        $this->db->insert("standar_parameter", $data);
        return $this->db->insert_id();
    }

    public function insert_batch($data){
        $this->db->insert_batch("standar_parameter", $data);
        return $this->db->affected_rows();
    }

    

    public function update($data,$where){
        $this->db->update("standar_parameter", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("standar_parameter"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir)
    {
        $this->db->select("YEAR(tanggal) as tahun, MONTH(tanggal) as bulan")->from("standar_parameter");
        $this->db->group_by(['YEAR(tanggal)', 'MONTH(tanggal)']);   
        $this->db->order_by('tanggal');   
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
        $this->db->select("standar_parameter.id")->from("standar_parameter");
        $this->db->group_by(['YEAR(tanggal)', 'MONTH(tanggal)']);  
        $this->db->order_by('tanggal');
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
