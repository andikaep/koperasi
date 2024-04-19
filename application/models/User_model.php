<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
	public function get($username){
		$this->db->where('username', $username);
		$result = $this->db->get('user')->row();
		return $result;
	}

	public function get_user_level($username) {
		$this->db->select('level');
		$this->db->where('username', $username);
		$query = $this->db->get('user');
		return $query->row()->level;
	}

	public function get_last_login($username) {
        $this->db->select('last_login');
        $this->db->where('username', $username);
        return $this->db->get('user')->row()->last_login;
    }

    public function update_last_login($username) {
		$this->db->set('last_login', 'NOW()', false); // Gunakan NOW() untuk mendapatkan waktu sekarang
		$this->db->where('username', $username);
		$this->db->update('user');
	}

}

/* End of file .php */
