<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Administrasi extends REST_Controller
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
		$this->load->model('M_administrasi', 'ad');
		$this->load->model('M_post', 'Insert');
	}

	public function index_get()
    {
      
        $id = $this->get('id_ad');

        if ( $id === null )
        {
            $data = $this->ad->get()->result();

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
            $data = $this->ad->getId($id);

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
				'id_ad' => $this->post('id_ad'),
				'id_mobil' => $this->post('id_mobil'),
				'jenis_ad' => $this->post('jenis_ad'),
				'harga_ad' => $this->post('harga_ad'),
				'ket_ad' => $this->post('ket_ad'),
				'tgl_ad' => $this->post('tgl_ad'),	
            ];

            $this->form_validation->set_data($data);
			$this->form_validation->set_rules('id_mobil', 'Mobil', 'required');
			$this->form_validation->set_rules('jenis_ad', 'jenis', 'required');
			$this->form_validation->set_rules('harga_ad', 'harga', 'required');
			$this->form_validation->set_rules('ket_ad', 'Keterangan', 'required');
			$this->form_validation->set_rules('tgl_ad', 'Tanggal ', 'required');
		
            if ($this->form_validation->run() == FALSE) {
    
                $message = [
                    "status" => false,
                    "message" => validation_errors(' ', ' '),
                ];
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $respon = $this->Insert->insert('tb_administrasi', $data);
                $data['administrasi'] = $this->ad->tampil();
                $this->response($data, REST_Controller::HTTP_OK);
            }
		}
        
		public function index_put()
		{
			$id = $this->put('id_ad');
			$data = [
				'id_ad'       => $this->put('id_ad'),
				'id_mobil'    => $this->put('id_mobil'),
				'jenis_ad'    => $this->put('jenis_ad'),
				'harga_ad'    => $this->put('harga_ad'),
				'ket_ad'    => $this->put('ket_ad'),
				'tgl_ad'    => $this->put('tgl_ad')
	
			];
	
			if ($this->ad->updateP($data, $id) ) {
				$this->response(array($data,'status' => 'update success'), 201);
			} else {
				$this->response(array('status' => 'update fail', 502));
			}
		}
	  
	
		public function index_delete()
		{
			$id = $this->input->get('id_ad');
	
			$hapus = $this->ad->deleteP($id);
	
			if ($hapus) {
						$this->response(array('status' => 'delete success'), 201);
					} else {
						$this->response(array('status' => 'delete fail', 502));
					}
		}
		
	
	}
	

