<?php
//php intelifens
defined('BASEPATH') or exit('No direct script access allowed');

class M_transaksi extends CI_Model
{
    
    public function get()
    {
        $this->db->select("t.id_transaksi,t.id_mobil,m.plat_mobil,s.id_supir,s.nama_supir,t.tanggal,t.ket_transaksi,t.tujuan,t.ongkosan,t.keluar,t.sisa");
        $this->db->from('tb_transaksi t');
        $this->db->join('tb_mobil m', 't.id_mobil = m.id_mobil', 'left');
        $this->db->join('tb_supir s', 't.id_supir = s.id_supir', 'left');
        $this->db->group_by('t.id_transaksi');


        return $this->db->get('tb_transaksi');
    }
   
    public function getData()
    {
        $this->db->select('
        tb_transaksi.*, tb_mobil.id_mobil AS id_mobil,  tb_mobil.id_mobil,tb_mobil.plat_mobil, tb_supir.id_supir AS id_supir,tb_supir.id_supir ,tb_supir.nama_supir ');
        $this->db->join('tb_mobil', 'tb_transaksi.id_mobil = tb_mobil.id_mobil');
        $this->db->join('tb_supir', 'tb_transaksi.id_supir = tb_supir.id_supir');
        $this->db->from('tb_transaksi');
        $query = $this->db->get();
        return $query->result();
    }
    public function getId($id)
    {
        return $this->db->get_where('tb_transaksi',['id_transaksi' => (int)$id])->row();
    }
    public function tampil() {
		
		$this->db->order_by('id_transaksi', 'desc')->limit(1);
		$result = $this->db->get('tb_transaksi');
		return $result->result();
   
	}
    public function updateTransaksi($data, $id)
    {
        $this->db->update('tb_transaksi', $data, ['id_transaksi' => $id]);
        return $this->db->affected_rows();
    }
	public function update($post)
	{
		   $this->plat_mobil    = $post['plat_mobil']; 
			$this->ket_mobil  = $post['ket_mobil'];
			$this->terjual     = $post['terjual'];

			$this->db->update('tb_transaksi', $this, array('id_transaksi' => $post['id_transaksi']));
	if($this->db->affected_rows()){
		return true;
	} else {
		return false;
	}
	}

	public function deleteTransaksi($id)
    {
        $this->db->delete('tb_transaksi', ['id_transaksi' => $id]);
        return $this->db->affected_rows();
    }


	
}
