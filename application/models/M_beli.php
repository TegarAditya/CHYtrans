<?php
//php intelifens
defined('BASEPATH') or exit('No direct script access allowed');

class M_beli extends CI_Model
{
    
    public function get()
    {
        $this->db->select("b.id_b,m.id_mobil,m.plat_mobil,b.harga_b,b.ket_b,b.tgl_b");
        $this->db->from('tb_beli b');
        $this->db->join('tb_mobil m', 'b.id_mobil = m.id_mobil', 'left');
        $this->db->group_by('b.id_b');


        return $this->db->get('tb_beli');
    }
   
    public function getData()
    {
        $this->db->select('
          tb_beli.*, tb_mobil.id_mobil AS id_mobil, tb_mobil.plat_mobil, 
        ');
        $this->db->join('tb_mobil', 'tb_beli.id_mobil = tb_mobil.id_mobil');
        $this->db->from('tb_beli');
        $query = $this->db->get();
        return $query->result();
    }
    public function getb()
	{
		return $this->db->get('tb_beli');
	}
	public function getId($id)
    {
        return $this->db->get_where('tb_beli',['id_b' => (int)$id])->row();
    }
    public function tampil() {
		
		$this->db->order_by('id_b', 'desc')->limit(1);
		$result = $this->db->get('tb_beli');
		return $result->result();
   
	}
    public function updateb($data, $id)
    {
        $this->db->update('tb_beli', $data, ['id_b' => $id]);
        return $this->db->affected_rows();
    }
	public function update($post)
	{
		   $this->id_mobil    = $post['id_mobil']; 
		   $this->harga_b    = $post['harga_b']; 
			$this->ket_b     = $post['ket_b'];
			$this->tgl_b     = $post['tgl_b'];

			$this->db->update('tb_beli', $this, array('id_b' => $post['id_b']));
	if($this->db->affected_rows()){
		return true;
	} else {
		return false;
	}
	}

	public function deleteb($id)
    {
        $this->db->delete('tb_beli', ['id_b' => $id]);
        return $this->db->affected_rows();
    }


	
}