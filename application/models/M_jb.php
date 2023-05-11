<?php
//php intelifens
defined('BASEPATH') or exit('No direct script access allowed');

class M_jb extends CI_Model
{
    
    public function get()
    {
        $this->db->select("jb.id_jb,m.id_mobil,m.plat_mobil,m.ket_mobil,jb.harga_jb,jb.ket_jb,jb.tgl_jb,jb.jualOrBeli");
        $this->db->from('tb_jualbeli jb');
        $this->db->join('tb_mobil m', 'jb.id_mobil = m.id_mobil', 'left');
        $this->db->group_by('jb.id_jb');


        return $this->db->get('tb_jualbeli');
    }
   
    public function getData()
    {
        $this->db->select('
          tb_jualbeli.*, tb_mobil.id_mobil AS id_mobil, tb_mobil.plat_mobil, 
        ');
        $this->db->join('tb_mobil', 'tb_jualbeli.id_mobil = tb_mobil.id_mobil');
        $this->db->from('tb_jualbeli');
        $query = $this->db->get();
        return $query->result();
    }
    public function getJB()
	{
		return $this->db->get('tb_jualbeli');
	}
	public function getId($id)
    {
        return $this->db->get_where('tb_jualbeli',['id_jb' => (int)$id])->row();
    }
    public function tampil() {
		
		$this->db->order_by('id_jb', 'desc')->limit(1);
		$result = $this->db->get('tb_jualbeli');
		return $result->result();
   
	}
    public function updateJB($data, $id)
    {
        $this->db->update('tb_jualbeli', $data, ['id_jb' => $id]);
        return $this->db->affected_rows();
    }
	public function update($post)
	{
		   $this->id_mobil    = $post['id_mobil']; 
		   $this->harga_jb    = $post['harga_jb']; 
		
			$this->ket_jb     = $post['ket_jb'];
			$this->tgl_jb     = $post['tgl_jb'];
			$this->jualOrBeli     = $post['jualOrBeli'];

			$this->db->update('tb_jualbeli', $this, array('id_jb' => $post['id_jb']));
	if($this->db->affected_rows()){
		return true;
	} else {
		return false;
	}
	}

	public function deleteJB($id)
    {
        $this->db->delete('tb_jualbeli', ['id_jb' => $id]);
        return $this->db->affected_rows();
    }


	
}