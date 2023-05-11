<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Perbaikan extends REST_Controller
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
		$this->load->model('M_perbaikan', 'perbaikan');
		$this->load->model('M_post', 'Insert');
	}

	public function index_get()
    {
      
        $id = $this->get('id_perbaikan');

        if ( $id === null )
        {
            $data = $this->perbaikan->get()->result();

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
            $data = $this->perbaikan->getId($id);

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
				'id_perbaikan' => $this->post('id_perbaikan'),
				'id_mobil' => $this->post('id_mobil'),
				// 'plat_mobil' => $this->post('plat_mobil'),
				'jenis_p' => $this->post('jenis_p'),
				'harga_p' => $this->post('harga_p'),
				'ket_p' => $this->post('ket_p'),
				'tgl_p' => $this->post('tgl_p'),	
				'administrasi' => $this->post('administrasi'),	
            ];

            $this->form_validation->set_data($data);
			$this->form_validation->set_rules('id_mobil', 'Mobil', 'required');
			$this->form_validation->set_rules('jenis_p', 'Harga', 'required');
			$this->form_validation->set_rules('harga_p', 'Jenis', 'required');
			$this->form_validation->set_rules('ket_p', 'Keterangan', 'required');
			$this->form_validation->set_rules('tgl_p', 'Tanggal ', 'required');
			$this->form_validation->set_rules('administrasi', 'administrasi ', 'required');
		
            if ($this->form_validation->run() == FALSE) {
    
                $message = [
                    "status" => false,
                    "message" => validation_errors(' ', ' '),
                ];
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $respon = $this->Insert->insert('tb_perbaikan', $data);
                $data['perbaikan'] = $this->perbaikan->tampil();
                $this->response($data, REST_Controller::HTTP_OK);
            }
		}
        
		public function index_put()
		{
			$id = $this->put('id_perbaikan');
			$data = [
				'id_perbaikan'       => $this->put('id_perbaikan'),
				'id_mobil'    => $this->put('id_mobil'),
				'jenis_p'    => $this->put('jenis_p'),
				'harga_p'    => $this->put('harga_p'),
				'ket_p'    => $this->put('ket_p'),
				'tgl_p'    => $this->put('tgl_p'),
				'administrasi'    => $this->put('administrasi')
	
			];
	
			if ($this->perbaikan->updateP($data, $id) ) {
				$this->response(array($data,'status' => 'update success'), 201);
			} else {
				$this->response(array('status' => 'update fail', 502));
			}
		}
	  
	
		public function index_delete()
		{
			$id = $this->input->get('id_perbaikan');
	
			$hapus = $this->perbaikan->deleteP($id);
	
			if ($hapus) {
						$this->response(array('status' => 'delete success'), 201);
					} else {
						$this->response(array('status' => 'delete fail', 502));
					}
		}
		
	
	}
	

