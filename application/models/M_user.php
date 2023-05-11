<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{


	public function get()
	{
		$data = $this->db->get('tb_user')->result();
		$result = array();
		foreach ($data as $key) {
			$row = array();
			$row['id_user'] = $key->id_user;
			$row['username'] = $key->username;
			$row['password'] = $key->password;
			$row['status'  ] = $key->status;
			$result[] = $row;
		}
		return $result;
	}

	public function getMobil()
	{
		return $this->db->get('tb_user');
	}
	public function getId($id)
    {
        return $this->db->get_where('tb_user',['id_user' => (int)$id])->row();
    }
	public function tampil() {
		
		$this->db->order_by('id_user', 'desc')->limit(1);
		$result = $this->db->get('tb_user');
		return $result->result();
   
	}
	public function updateUser($data, $id)
    {
        $this->db->update('tb_user', $data, ['id_user' => $id]);
        return $this->db->affected_rows();
    }
	public function update($post)
	{
		   $this->username    = $post['username']; 
			$this->password  = password_hash($post['password'], PASSWORD_DEFAULT);
			$this->status     = $post['status'];

			$this->db->update('tb_user', $this, array('id_user' => $post['id_user']));
	if($this->db->affected_rows()){
		return true;
	} else {
		return false;
	}
	}

	public function deleteUser($id)
    {
        $this->db->delete('tb_user', ['id_user' => $id]);
        return $this->db->affected_rows();
    }


	
}
