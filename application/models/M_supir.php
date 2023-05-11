<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_supir extends CI_Model
{


	public function get()
	{
		$this->db->order_by('id_supir', 'desc');
		$data = $this->db->get('tb_supir')->result();
		$result = array();
		foreach ($data as $key) {
			$row = array();
			$row['id_supir'] = $key->id_supir;
			$row['nama_supir'] = $key->nama_supir;
			$row['no_hp'] = $key->no_hp;
			$row['terjual'] = $key->terjual;
			$result[] = $row;
		}
		return $result;
	}

	public function getSupir()
	{
		return $this->db->get('tb_supir');
	}
	public function getId($id)
    {
        return $this->db->get_where('tb_supir',['id_supir' => (int)$id])->row();
    }
	public function tampil() {
		
		$this->db->order_by('id_supir', 'desc')->limit(1);
		$result = $this->db->get('tb_supir');
		return $result->result();
   
	}
	public function updateSupir($data, $id)
    {
        $this->db->update('tb_supir', $data, ['id_supir' => $id]);
        return $this->db->affected_rows();
    }
	public function update($post)
	{
		   $this->nama_supir    = $post['nama_supir']; 
			$this->no_hp  = $post['no_hp'];
			$this->terjual  = $post['terjual'];

			$this->db->update('tb_supir', $this, array('id_supir' => $post['id_supir']));
	if($this->db->affected_rows()){
		return true;
	} else {
		return false;
	}
	}

	public function deleteSupir($id)
    {
        $this->db->delete('tb_supir', ['id_supir' => $id]);
        return $this->db->affected_rows();
    }


	
}
