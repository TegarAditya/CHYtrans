<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Beli extends REST_Controller
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
		$this->load->model('M_beli', 'b');
		$this->load->model('M_post', 'Insert');
	}
	public function index_get()
    {
      
        $id = $this->get('id_b');

        if ( $id === null )
        {
            $data = $this->b->get()->result();

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
            $data = $this->b->getId($id);

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
				'id_b' => $this->post('id_b'),
				'id_mobil' => $this->post('id_mobil'),
				'harga_b' => $this->post('harga_b'),
				// 'beli_b' => $this->post('beli_b'),
				'ket_b' => $this->post('ket_b'),
				'tgl_b' => $this->post('tgl_b'),
				
			
            ];

            $this->form_validation->set_data($data);
			$this->form_validation->set_rules('id_mobil', 'Mobil', 'required|is_unique[tb_beli.id_mobil]');
			$this->form_validation->set_rules('harga_b', 'Harga', 'required');
			// $this->form_validation->set_rules('beli_b', 'Beli', 'required');
			$this->form_validation->set_rules('ket_b', 'Keterangan', 'required');
			$this->form_validation->set_rules('tgl_b', 'Tanggal Jual Beli', 'required');
			$this->form_validation->set_message('is_unique', '{field} Tidak Boleh Sama');
            if ($this->form_validation->run() == FALSE) {
    
                $message = [
                    "status" => false,
                    "message" => validation_errors(' ', ' '),
                ];
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $respon = $this->Insert->insert('tb_beli', $data);
                $data['beli'] = $this->b->tampil();
                $this->response($data, REST_Controller::HTTP_OK);
            }
          
		}
       
		public function index_put()
		{
			$id = $this->put('id_b');
			$data = [
				'id_b'       => $this->put('id_b'),
				'id_mobil'       => $this->put('id_mobil'),
				'harga_b'          => $this->put('harga_b'),
				// 'beli_b'    => $this->put('beli_b'),
				'ket_b'    => $this->put('ket_b'),
				'tgl_b'    => $this->put('tgl_b')
	
			];
                
			if ($this->b->updateb($data, $id) ) {
               
				$this->response(array($data,'status' => 'update success'), 201);
			} else {
				$this->response(array('status' => 'update fail', 502));
			}
		}
	  
	
		public function index_delete()
		{
			$id = $this->input->get('id_b');
	
			$hapus = $this->b->deleteb($id);
	
			if ($hapus) {
						$this->response(array('status' => 'delete success'), 201);
					} else {
						$this->response(array('status' => 'delete fail', 502));
					}
		}
		
	
	}
	
