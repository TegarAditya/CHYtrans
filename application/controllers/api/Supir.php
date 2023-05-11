<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Supir extends REST_Controller
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
        $this->load->model('M_supir', 'supir');
        $this->load->model('M_post', 'Insert');
    }

    // public function index_get()
    // {
    //     $data = $this->supir->get();
    //     $this->set_response([
    //         'status' => true,
    //         'data' => $data,
    //     ], REST_Controller::HTTP_OK);
    // }
    public function index_get()
    {
      
        $id = $this->get('id_supir');

        if ( $id === null )
        {
            $data = $this->supir->get();

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
                    'message'   => 'not found'
                ], 404 );
            }
        }
        else
        {
            $data = $this->supir->getId($id);

            if ( isset( $data ) )
            {
                $this->response( $data, 200 );
            }
            else
            {
                $this->response( [
                    'status'    => false,
                    'message'   => ' not found'
                ], 404 );
            }
        }
    }
    public function index_post()
    {
        $data = [
            "id_supir" => $this->post('id_supir'),
            "nama_supir" => $this->post('nama_supir'),
            "no_hp" => $this->post('no_hp'),
            "terjual" => $this->post('terjual'),
        ];

        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('nama_supir', 'Nama Supir', 'required|is_unique[tb_supir.nama_supir]');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required');
        $this->form_validation->set_message('required', '{field} Tidak Boleh Kosong');
        $this->form_validation->set_message('is_unique', '{field} Tidak Boleh Sama');

        if ($this->form_validation->run() == FALSE) {

            $message = [
                "status" => false,
                "message" => validation_errors(' ', ' '),
            ];
            $this->response($message, REST_Controller::HTTP_OK);
        } else {
            $respon = $this->Insert->insert('tb_supir', $data);
            $data['supir'] = $this->supir->tampil();
            $this->response(array($data,'status' => 'insert success'), 201);
        }
    }
   
    public function index_put()
    {
        $id = $this->put('id_supir');
        $data = [
            'id_supir'       => $this->put('id_supir'),
            'nama_supir'          => $this->put('nama_supir'),
            'no_hp'    => $this->put('no_hp'),
            'terjual'    => $this->put('terjual'),

        ];

        if ($this->supir->updateSupir($data, $id) ) {
            $this->response(array($data,'status' => 'update success'), 201);
        } else {
            $this->response(array('status' => 'update fail', 502));
        }
    }
  

    public function index_delete()
    {
        $id = $this->input->get('id_supir');

        $hapus = $this->supir->deleteSupir($id);

        if ($hapus) {
                    $this->response(array('status' => 'delete success'), 201);
                } else {
                    $this->response(array('status' => 'delete fail', 502));
                }
    }
    

}
