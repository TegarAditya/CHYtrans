<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Mobil extends REST_Controller
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
        $this->load->model('M_mobil', 'tb_mobil');
        $this->load->model('M_post', 'Insert');
    }

    
    public function index_get()
    {
      
        $id = $this->get('id_mobil');

        if ( $id === null )
        {
            $data = $this->tb_mobil->get();

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
            $data = $this->tb_mobil->getId($id);

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
            "id_mobil" => $this->post('id_mobil'),
            "plat_mobil" => $this->post('plat_mobil'),
            "ket_mobil" => $this->post('ket_mobil'),
            "terjual"=>$this->post('terjual'),

        ];

        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('plat_mobil', 'Plat Mobil', 'required|is_unique[tb_mobil.plat_mobil]');
        $this->form_validation->set_rules('ket_mobil', 'Ket Mobil', 'required');
        $this->form_validation->set_message('required', '{field} Tidak Boleh Kosong');
        $this->form_validation->set_message('is_unique', '{field} Tidak Boleh Sama');
        if ($this->form_validation->run() == FALSE) {

            $message = [
                "status" => false,
                "message" => validation_errors(' ', ' '),
            ];
            $this->response($message, REST_Controller::HTTP_OK);
        } else {
            $respon = $this->Insert->insert('tb_mobil', $data);
            $data['mobil'] = $this->tb_mobil->tampil();
            $this->response($data, REST_Controller::HTTP_OK);
        }
    }
    public function index_put()
    {
        $id = $this->put('id_mobil');
        $data = [
            'id_mobil'       => $this->put('id_mobil'),
            'plat_mobil'          => $this->put('plat_mobil'),
            'ket_mobil'    => $this->put('ket_mobil'),
            'terjual'    => $this->put('terjual')

        ];

        if ($this->tb_mobil->updateMobil($data, $id) ) {
         

            $this->response(array($data,'status' => 'update success'), 201);
        } else {
            $this->response(array('status' => 'update fail', 502));
        }
    }
  

    public function index_delete()
    {
        $id = $this->input->get('id_mobil');

        $hapus = $this->tb_mobil->deleteMobil($id);

        if ($hapus) {
                    $this->response(array('status' => 'delete success'), 201);
                } else {
                    $this->response(array('status' => 'delete fail', 502));
                }
    }
    

}
