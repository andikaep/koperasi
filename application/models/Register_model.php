<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model
{
	private $_table= "user";

	public $id_user;
	public $username;
	public $password;
	public $nama;

	public function rules()
	{
		return [
			['field' => 'username',
				'label' => 'username',
				'rules' => 'required|max_length[20]'],

			['field' => 'password',
				'label' => 'password',
				'rules' => 'required|max_length[50]'],

			['field' => 'nama',
				'label' => 'nama',
				'rules' => 'required|max_length[225]'],

		];
	}

	

	public function save(){
		$post = $this->input->post();
		$this->username = $post["username"];
		$this->password = $post["password"];
		$this->nama = $post["nama"];
		$this->db->insert($this->_table, $this);
	}

}

/* End of file .php */
