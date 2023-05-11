<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class JualBeli extends REST_Controller
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
		$this->load->model('M_jb', 'JB');
		$this->load->model('M_post', 'Insert');
	}
	public function index_get()
    {
      
        $id = $this->get('id_jb');

        if ( $id === null )
        {
            $data = $this->JB->get()->result();

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
            $data = $this->JB->getId($id);

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
				'id_jb' => $this->post('id_jb'),
				'id_mobil' => $this->post('id_mobil'),
				'harga_jb' => $this->post('harga_jb'),
				
				'ket_jb' => $this->post('ket_jb'),
				'tgl_jb' => $this->post('tgl_jb'),
				'jualOrBeli' => $this->post('jualOrBeli'),
				
			
            ];

            $this->form_validation->set_data($data);
			$this->form_validation->set_rules('id_mobil', 'Mobil', 'required|is_unique[tb_jualbeli.id_mobil]');
			$this->form_validation->set_rules('harga_jb', 'Harga', 'required');
			$this->form_validation->set_rules('ket_jb', 'Keterangan', 'required');
			$this->form_validation->set_rules('tgl_jb', 'Tanggal Jual Beli', 'required');
			$this->form_validation->set_message('is_unique', '{field} Tidak Boleh Sama');
            if ($this->form_validation->run() == FALSE) {
    
                $message = [
                    "status" => false,
                    "message" => validation_errors(' ', ' '),
                ];
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $respon = $this->Insert->insert('tb_jualbeli', $data);
                $data['jualbeli'] = $this->JB->tampil();
                $this->response($data, REST_Controller::HTTP_OK);
            }
            
		}
       
		public function index_put()
		{
			$id = $this->put('id_jb');
			$data = [
				'id_jb'       => $this->put('id_jb'),
				'id_mobil'       => $this->put('id_mobil'),
				'harga_jb'          => $this->put('harga_jb'),
			
				'ket_jb'    => $this->put('ket_jb'),
				'tgl_jb'    => $this->put('tgl_jb'),
				'jualOrBeli'    => $this->put('jualOrBeli')
	
			];
                
			if ($this->JB->updateJB($data, $id) ) {
               
				$this->response(array($data,'status' => 'update success'), 201);
			} else {
				$this->response(array('status' => 'update fail', 502));
			}
		}
	  
	
		public function index_delete()
		{
			$id = $this->input->get('id_jb');
	
			$hapus = $this->JB->deleteJB($id);
	
			if ($hapus) {
						$this->response(array('status' => 'delete success'), 201);
					} else {
						$this->response(array('status' => 'delete fail', 502));
					}
		}
		
	
	}
	
