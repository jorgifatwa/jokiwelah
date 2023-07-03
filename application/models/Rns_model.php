<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rns_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function getAllById($where = array()) {
		$this->db->select("rns.*")->from("rns");
		$this->db->where($where);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
	public function getOneBy($where = array()) {
		$this->db->select("rns.*")->from("rns");
		$this->db->where($where);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}

	public function insert($data) {
		$this->db->insert("rns", $data);
		return $this->db->insert_id();
	}

	public function insert_log($data) {
		$this->db->insert("rns_log", $data);
		return $this->db->insert_id();
	}

	public function update($data, $where) {
		$this->db->update("rns", $data, $where);
		return $this->db->affected_rows();
	}

	public function cek_data_start($where) {
		$this->db->select("count(id) as total, rns.*")->from("rns");
		$this->db->where($where);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}

	public function cek_data($tanggal, $type, $lokasi) {
		$sql = $this->db->query('SELECT count(id) as total FROM rns WHERE tanggal="' . $tanggal . '" AND type="' . $type . '" AND lokasi="' . $lokasi . '"');
		return $sql->row();
	}

	public function get_max() {
		$this->db->select('rns.*')->from('rns');
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
	}

	public function cek_stop($where) {
		$this->db->select("count(id) as total, rns.*")->from("rns");
		$this->db->where($where);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}

	function getAllBy($limit, $start, $search, $col, $dir, $where) {
		$this->db->select("rns.*")->from("rns");
		$this->db->limit($limit, $start)->order_by($col, $dir);
		if(!empty($where)){
            $this->db->where($where);
        }

        if(!empty($search)){
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);    
            }   
            $this->db->group_end();
        }

		$this->db->group_by(["rns.tanggal", "rns.lokasi"]);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		} else {
			return null;
		}
	}

	function getCountAllBy($limit, $start, $search, $order, $dir, $where) {
		$this->db->select("rns.id")->from("rns");
		 if(!empty($where)){
            $this->db->where($where);
        }

        if(!empty($search)){
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);    
            }   
            $this->db->group_end();
        }
		
		$this->db->group_by(["rns.tanggal", "rns.lokasi"]);
		$result = $this->db->get();

		return $result->num_rows();
	}

	public function getTotal($where = array()) {
		$this->db->select("count(rns.id) as total")->from("rns");
		$this->db->where($where);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}

    function detailGetAllBy($limit, $start, $search, $col, $dir, $where) {
		$this->db->select("rns.*")->from("rns");
		$this->db->limit($limit, $start)->order_by($col, $dir);
		if (!empty($search)) {
			$this->db->group_start();
			foreach ($search as $key => $value) {
				$this->db->or_like($key, $value);
			}
			$this->db->group_end();
		}
		$this->db->where($where);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		} else {
			return null;
		}
	}

	function detailGetCountAllBy($limit, $start, $search, $order, $dir, $where) {
		$this->db->select("rns.id")->from("rns");
		if (!empty($search)) {
			$this->db->group_start();
			foreach ($search as $key => $value) {
				$this->db->or_like($key, $value);
			}
			$this->db->group_end();
		}
		$this->db->where($where);
		$result = $this->db->get();

		return $result->num_rows();
	}

}
