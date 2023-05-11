<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_mobil extends CI_Model
{


	public function get()
	{
		$data = $this->db->get('tb_mobil')->result();
		$result = array();
		foreach ($data as $key) {
			$row = array();
			$row['id_mobil'] = $key->id_mobil;
			$row['plat_mobil'] = $key->plat_mobil;
			$row['ket_mobil'] = $key->ket_mobil;
			$row['terjual'] = $key->terjual;
			$result[] = $row;
		}
		return $result;
	}

	public function getMobil()
	{
		return $this->db->get('tb_mobil');
	}
	public function getId($id)
    {
        return $this->db->get_where('tb_mobil',['id_mobil' => (int)$id])->row();
    }
	public function tampil() {
		
		$this->db->order_by('id_mobil', 'desc')->limit(1);
		$result = $this->db->get('tb_mobil');
		return $result->result();
   
	}
	public function updateMobil($data, $id)
    {
        $this->db->update('tb_mobil', $data, ['id_mobil' => $id]);
        return $this->db->affected_rows();
    }
	public function update($post)
	{
		   $this->plat_mobil    = $post['plat_mobil']; 
			$this->ket_mobil  = $post['ket_mobil'];
			$this->terjual     = $post['terjual'];

			$this->db->update('tb_mobil', $this, array('id_mobil' => $post['id_mobil']));
	if($this->db->affected_rows()){
		return true;
	} else {
		return false;
	}
	}

	public function deleteMobil($id)
    {
        $this->db->delete('tb_mobil', ['id_mobil' => $id]);
        return $this->db->affected_rows();
    }


	
}
