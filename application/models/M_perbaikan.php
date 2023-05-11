<?php
//php intelifens
defined('BASEPATH') or exit('No direct script access allowed');

class M_perbaikan extends CI_Model
{
    
    public function get()
    {
        $this->db->select("jb.id_perbaikan,m.id_mobil,m.plat_mobil,jb.jenis_p, jb.harga_p,jb.ket_p,jb.tgl_p,jb.administrasi");
        $this->db->from('tb_perbaikan jb');
        $this->db->join('tb_mobil m', 'jb.id_mobil = m.id_mobil', 'left');
        $this->db->group_by('jb.id_perbaikan');


        return $this->db->get('tb_perbaikan');
    }
   
    public function getData()
    {
        $this->db->select('
        tb_perbaikan.*, tb_mobil.id_mobil AS id_mobil, tb_mobil.plat_mobil, 
        ');
        $this->db->join('tb_mobil', 'tb_perbaikan.id_mobil = tb_mobil.id_mobil');
        $this->db->from('tb_perbaikan');
        $query = $this->db->get();
        return $query->result();
    }
    public function getId($id)
    {
        return $this->db->get_where('tb_perbaikan',['id_perbaikan' => (int)$id])->row();
    }
    public function tampil() {
        $this->db->select("jb.id_perbaikan,m.id_mobil,m.plat_mobil,jb.jenis_p, jb.harga_p,jb.ket_p,jb.tgl_p,jb.administrasi");
        $this->db->from('tb_perbaikan jb');
        $this->db->join('tb_mobil m', 'jb.id_mobil = m.id_mobil', 'left');
        $this->db->group_by('jb.id_perbaikan');
		$this->db->order_by('id_perbaikan', 'desc')->limit(1);
		$result = $this->db->get('tb_perbaikan');
		return $result->result();
   
	}
    public function updateP($data, $id)
    {
        $this->db->update('tb_perbaikan', $data, ['id_perbaikan' => $id]);
        return $this->db->affected_rows();
    }
	public function update($post)
	{
		   $this->id_mobil    = $post['id_mobil']; 
			$this->jenis_p  = $post['jenis_p'];
			$this->harga_p     = $post['harga_p'];
			$this->ket_p     = $post['ket_p'];
			$this->tgl_p     = $post['tgl_p'];
			$this->administrasi     = $post['administrasi'];

			$this->db->update('tb_perbaikan', $this, array('id_perbaikan' => $post['id_perbaikan']));
	if($this->db->affected_rows()){
		return true;
	} else {
		return false;
	}
	}

	public function deleteP($id)
    {
        $this->db->delete('tb_perbaikan', ['id_perbaikan' => $id]);
        return $this->db->affected_rows();
    }


	
}