<?php
//php intelifens
defined('BASEPATH') or exit('No direct script access allowed');

class M_administrasi extends CI_Model
{
    
    public function get()
    {
        $this->db->select("jb.id_ad,m.id_mobil,m.plat_mobil,jb.jenis_ad, jb.harga_ad,jb.ket_ad,jb.tgl_ad");
        $this->db->from('tb_administrasi jb');
        $this->db->join('tb_mobil m', 'jb.id_mobil = m.id_mobil', 'left');
        $this->db->group_by('jb.id_ad');


        return $this->db->get('tb_administrasi');
    }
   
    public function getData()
    {
        $this->db->select('
        tb_administrasi.*, tb_mobil.id_mobil AS id_mobil, tb_mobil.plat_mobil, 
        ');
        $this->db->join('tb_mobil', 'tb_administrasi.id_mobil = tb_mobil.id_mobil');
        $this->db->from('tb_administrasi');
        $query = $this->db->get();
        return $query->result();
    }
    public function getId($id)
    {
        return $this->db->get_where('tb_administrasi',['id_ad' => (int)$id])->row();
    }
    public function tampil() {
        $this->db->select("jb.id_ad,m.id_mobil,m.plat_mobil,jb.jenis_ad, jb.harga_ad,jb.ket_ad,jb.tgl_ad");
        $this->db->from('tb_administrasi jb');
        $this->db->join('tb_mobil m', 'jb.id_mobil = m.id_mobil', 'left');
        $this->db->group_by('jb.id_ad');
		$this->db->order_by('id_ad', 'desc')->limit(1);
		$result = $this->db->get('tb_administrasi');
		return $result->result();
   
	}
    public function updateP($data, $id)
    {
        $this->db->update('tb_administrasi', $data, ['id_ad' => $id]);
        return $this->db->affected_rows();
    }
	public function update($post)
	{
		   $this->id_mobil    = $post['id_mobil']; 
			$this->jenis_ad  = $post['jenis_ad'];
			$this->harga_ad     = $post['harga_ad'];
			$this->ket_ad    = $post['ket_ad'];
			$this->tgl_ad    = $post['tgl_ad'];

			$this->db->update('tb_administrasi', $this, array('id_ad' => $post['id_ad']));
	if($this->db->affected_rows()){
		return true;
	} else {
		return false;
	}
	}

	public function deleteP($id)
    {
        $this->db->delete('tb_administrasi', ['id_ad' => $id]);
        return $this->db->affected_rows();
    }


	
}