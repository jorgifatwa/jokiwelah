<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Fuel_consumtion_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct(); 
    }  

    public function getOneBy($where = array()){
        $this->db->select("fuel_consumtion.*")->from("fuel_consumtion");

        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }
    public function getAllById($where = array()){
        $this->db->select("fuel_consumtion.*")->from("fuel_consumtion");  
        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
    
    public function insert($data){
        $this->db->insert("fuel_consumtion", $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update("fuel_consumtion", $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete("fuel_consumtion"); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    public function getAllBy($limit,$start,$search,$col,$dir,$where = [])
    {
        $this->db->select("fuel_consumtion.*, location.name as location_name, pit.name as pit_name,
                           pic.first_name as pic_name, unit.kode, unit_model.name as model_name, unit_brand.name as brand_name,
                           disposal.name as lokasi_pengisian_name")->from("fuel_consumtion");   
        $this->db->join("location", "location.id = fuel_consumtion.location_id");
        $this->db->join("pit", "pit.id = fuel_consumtion.pit_id");
        $this->db->join("users pic", "pic.id = fuel_consumtion.pic_id");
        $this->db->join("unit", "unit.id = fuel_consumtion.unit_id");
        $this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
        $this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
        $this->db->join("disposal", "disposal.id = fuel_consumtion.lokasi_pengisian");

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
        $this->db->select("fuel_consumtion.id")->from("fuel_consumtion");   
        $this->db->join("location", "location.id = fuel_consumtion.location_id");
        $this->db->join("pit", "pit.id = fuel_consumtion.pit_id");
        $this->db->join("users pic", "pic.id = fuel_consumtion.pic_id");
        $this->db->join("unit", "unit.id = fuel_consumtion.unit_id");
        $this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
        $this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
        $this->db->join("disposal", "disposal.id = fuel_consumtion.lokasi_pengisian");
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
        $this->db->select("SUM(qty_out) as total")->from("fuel_consumtion");
        $this->db->where($where);  
        $this->db->where("is_deleted", 0);
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            if(empty($query->row()->total)){
                return 0;
            }else{
                return $query->row()->total; 
            }
        } 
        return 0;
    }

    public function getStockLatest($where)
    {
        $this->db->select("fuel_consumtion.current_stock, fuel_consumtion.id")->from("fuel_consumtion");
        $this->db->order_by("updated_at", "desc");
        $this->db->where($where);  

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function getTotalPerTanggal($where)
    {
        $this->db->select("SUM(fuel_consumtion.qty_out) as total, DATE_FORMAT(fuel_consumtion.tanggal, '%d') as tanggal")->from("fuel_consumtion");
        $this->db->where($where);  
        $this->db->where("is_deleted", 0);
        $this->db->group_by("DATE_FORMAT(fuel_consumtion.tanggal, '%d')");
        $this->db->order_by("fuel_consumtion.tanggal", "asc");

        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
}
