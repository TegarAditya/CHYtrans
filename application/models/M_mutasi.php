<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_mutasi extends CI_Model
{

 
	public function get()
	{
        $query = $this->db->query("SELECT * FROM mutations")->result();
    $data = [];
    foreach($query as $row){
        $detail = $this->db->query("SELECT * FROM detail_mutations WHERE mutation_id = {$row->id}")->result();
        $result = array();
        foreach ($detail as $pen) {
            array_push($result,[
                "id" => $pen->id,
                "keterangan" => $pen->keterangan,
                "harga" => $pen->harga,
                "qty" => $pen->qty,
                "total" => $pen->total,
                "mutation_id" => $pen->mutation_id
            ]);
        }
        array_push($data,[
            "id" => $row->id,
            "pendapatan_mutasi" => $row->pendapatan_mutasi,
            "tanggal_mutasi" => $row->tanggal_mutasi,
            "keterangan_mutasi" => $row->keterangan_mutasi,
            "detail_mutasi" =>$result,
            "total_mutasi" => $row->total_mutasi
        ]);
    }
        
        header('Content-Type: application/json','type : string');
        echo json_encode([ $data]);
        
	}
    
	// public function getMutasi()
	// {
	// 	return $this->db->get('tb_mutasi');
	// }

	public function getId($id)
{
    $mutasi = $this->db->get_where('mutations',['id' => (int)$id])->row();

    $detail = $this->db->query("SELECT * FROM detail_mutations WHERE id = {$mutasi->id}")->result();
        $result = array();
        foreach ($detail as $pen) {
            array_push($result,[
                "keterangan" => $pen->keterangan,
                "harga" => $pen->harga,
                "qty" => $pen->qty,
                "total" => $pen->total
            ]);
        }
    $data = [
            "id" => $mutasi->id,
            "pendapatan_mutasi" => $mutasi->pendapatan_mutasi,
            "tanggal_mutasi" => $mutasi->tanggal_mutasi,
            "keterangan_mutasi" => $mutasi->keterangan_mutasi,
            "detail_mutasi" =>$result,
            "total_mutasi" => $mutasi->total_mutasi
        ];

    return $data;
}
public function create_mutations($mutations) {
    // $myList = create_mutations($mutations);

    // Check if $myList is indeed an array or an object.
    // if (is_array($mutations) || is_object($mutations))
    // 
    // Loop through each object in the input data array
    $mutations = get_mutations();
    foreach ($mutations as $mutation) {

        if (!isset($mutation->id_mutasi)) {
            return array('status' => 'fail', 'message' => 'No mutation ID specified.');
        }

        // Get input data
        $id_mutasi = $mutation->id_mutasi;
        $pendapatan_mutasi = $mutation->pendapatan_mutasi;
        $tanggal_mutasi = $mutation->tanggal_mutasi;
        $keterangan_mutasi = $mutation->keterangan_mutasi;
        $detail_mutasi = $mutation->detail_mutasi;
        $total_mutasi = $mutation->total_mutasi;
        $keterangan = $mutation->keterangan;

        // Insert data into database
        $this->db->trans_start();

        $data =[
            "id_mutasi" => $id_mutasi,
            "pendapatan_mutasi" => $pendapatan_mutasi,
            "tanggal_mutasi" => $tanggal_mutasi,
            "keterangan_mutasi" => $keterangan_mutasi,
            "keterangan" => $keterangan,
            "total_mutasi" => $total_mutasi,
        ];
        
        $query= $this->db->insert('mutations', $data);
        return $query->result();
        $mutation_id = $this->db->insert_id();

        foreach ($detail_mutasi as $detail) {
            $datas = [
                'mutation_id' => $mutation_id,
                'keterangan' => $detail->keterangan,
                'harga' => $detail->harga,
                'qty' => $detail->qty,
                'total' => $detail->total,
                'total_mutasi' => $detail->total_mutasi,
            ];
            $query= $this->db->insert('detail_mutations', $datas);
            return $query->result();
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return array('status' => 'fail', 'message' => 'Failed to insert data into database.');
        }
    
    // }
    
    // If all mutations were inserted successfully, return success response
    return array('status' => 'success', 'message' => 'Mutations inserted successfully.');
} 
// else // If $myList was not an array, then this block is executed. 
//        {
//          echo "Unfortunately, an error occured.";
    //    }
}

	// public function tampil() {
		
	// 	$this->db->order_by('id_mutasi', 'desc')->limit(1);
	// 	$result = $this->db->get('tb_mutasi');
	// 	return $result->result();
   
	// }
	// public function updateMutasi($data, $id)
    // {
    //     $this->db->update('tb_mutasi', $data, ['id_mutasi' => $id]);
    //     return $this->db->affected_rows();
    // }
	// public function update($post)
	// {
	// 	   $this->plat_mobil    = $post['pendapatan_mutasi']; 
	// 		$this->ket_mobil  = $post['tanggal_mutasi'];
	// 		$this->terjual     = $post['keterangan_mutasi'];
	// 		$this->terjual     = $post['detail_mutasi'];
	// 		$this->terjual     = $post['total_mutasi'];

	// 		$this->db->update('tb_mutasi', $this, array('id_mutasi' => $post['id_mutasi']));
	// if($this->db->affected_rows()){
	// 	return true;
	// } else {
	// 	return false;
	// }
	// }

	public function deleteMutasi($id)
    {
        $this->db->delete('mutations', ['id' => $id]);
        return $this->db->affected_rows();
    }


	
}