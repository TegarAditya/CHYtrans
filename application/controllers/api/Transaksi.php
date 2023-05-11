<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Transaksi extends REST_Controller
{
    function __construct()
    {
        // set header CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header("Access-Control-Allow-Headers: *");
        header('Access-Control-Allow-Credentials: *');
        if ("OPTIONS" === $_SERVER['REQUEST_METHOD'] ) {die();}
        // Construct the parent class
        parent::__construct();
         
		$this->load->model('m_transaksi', 'transaksi');
		$this->load->model('M_post', 'Insert');
	}

	public function index_get()
    {
      
        $id = $this->get('id_transaksi');

        if ( $id === null )
        {
            $data = $this->transaksi->get()->result();

            // Check if the users data store contains users
            if ( isset($data) )
            {
                // Set the response and exit
                $this->response( $data, 200 );
            }
            else
            {
                // Set the response and exit
                $this->response( [
                    'status'    => false,
                    'message'   => 'Not found'
                ], 404 );
            }
        }
        else
        {
            $data = $this->transaksi->getId($id);

            if ( isset( $data ) )
            {
                $this->response( $data, 200 );
            }
            else
            {
                $this->response( [
                    'status'    => false,
                    'message'   => 'Not found'
                ], 404 );
            }
        }
    }
  
    public function index_post()
    {
        $data = [
				'id_transaksi' => $this->post('id_transaksi'),
				'id_mobil' => $this->post('id_mobil'),
				'id_supir' => $this->post('id_supir'),
				'tanggal' => $this->post('tanggal'),
				'ket_transaksi' => $this->post('ket_transaksi'),
				'tujuan' => $this->post('tujuan'),
				'ongkosan' => $this->post('ongkosan'),
				'keluar' => $this->post('keluar'),
				'sisa' => $this->post('sisa'),
				
			
            ];

            $this->form_validation->set_data($data);
			$this->form_validation->set_rules('id_mobil', 'Mobil', 'required');
			$this->form_validation->set_rules('id_supir', 'Supir', 'required');
			$this->form_validation->set_rules('ket_transaksi', 'keterangan', 'required');
			$this->form_validation->set_rules('tujuan', 'Tujuan', 'required');
			$this->form_validation->set_rules('tanggal', 'Tanggal Transaksi', 'required');
			$this->form_validation->set_rules('ongkosan', 'Ongkosan', 'required');
			$this->form_validation->set_rules('keluar', 'Keluar', 'required');
			$this->form_validation->set_rules('sisa', 'Sisa', 'required');
		
            if ($this->form_validation->run() == FALSE) {
    
                $message = [
                    "status" => false,
                    "message" => validation_errors(' ', ' '),
                ];
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $respon = $this->Insert->insert('tb_transaksi', $data);
                $data['transaksi'] = $this->transaksi->tampil();
                $this->response($data, REST_Controller::HTTP_OK);
            }
		}
		public function index_put()
		{
			$id = $this->put('id_transaksi');
			$data = [
				'id_transaksi'       => $this->put('id_transaksi'),
				'id_mobil'          => $this->put('id_mobil'),
				'id_supir'          => $this->put('id_supir'),
				'tanggal'    => $this->put('tanggal'),
				'ket_transaksi'    => $this->put('ket_transaksi'),
				'tujuan'    => $this->put('tujuan'),
				'ongkosan'    => $this->put('ongkosan'),
				'keluar'    => $this->put('keluar'),
				'sisa'    => $this->put('sisa'),
	
			];
	
			if ($this->transaksi->updateTransaksi($data, $id) ) {

				$this->response(array($data,'status' => 'update success'), 201);
			} else {
				$this->response(array('status' => 'update fail', 502));
			}
		}
	  
	
		public function index_delete()
		{
			$id = $this->input->get('id_transaksi');
	
			$hapus = $this->transaksi->deleteTransaksi($id);
	
			if ($hapus) {
						$this->response(array('status' => 'delete success'), 201);
					} else {
						$this->response(array('status' => 'delete fail', 502));
					}
		}
		
	
	}
	

