<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class User extends REST_Controller
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
        $this->load->model('M_user', 'user');
        $this->load->model('M_post', 'Insert');
    }

    
    public function index_get()
    {
      
        $id = $this->get('id_user');

        if ( $id === null )
        {
            $data = $this->user->get();

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
            $data = $this->user->getId($id);

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
            "id_user" => $this->post('id_user'),
            "username" => $this->post('username'),
            "password" => password_hash($this->input->post('password'), PASSWORD_DEFAULT), 
            "status"=>$this->post('status'),

        ];

        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
        $this->form_validation->set_message('required', '{field} Tidak Boleh Kosong');
        if ($this->form_validation->run() == FALSE) {

            $message = [
                "status" => false,
                "message" => validation_errors(' ', ' '),
            ];
            $this->response($message, REST_Controller::HTTP_OK);
        } else {
            $respon = $this->Insert->insert('tb_user', $data);
            $data['user'] = $this->user->tampil();
            $this->response($data, REST_Controller::HTTP_OK);
        }
    }
    public function index_put()
    {
        $id = $this->put('id_user');
        $data = [
            'id_user'       => $this->put('id_user'),
            'username'          => $this->put('username'),
            'password'    => password_hash($this->put('password'), PASSWORD_DEFAULT), 
            'status'    => $this->put('status')

        ];

        if ($this->user->updateUser($data, $id) ) {
         

            $this->response(array($data,'status' => 'update success'), 201);
        } else {
            $this->response(array('status' => 'update fail', 502));
        }
    }
  

    public function index_delete()
    {
        $id = $this->input->get('id_user');

        $hapus = $this->user->deleteUser($id);

        if ($hapus) {
                    $this->response(array('status' => 'delete success'), 201);
                } else {
                    $this->response(array('status' => 'delete fail', 502));
                }
    }
    

}
