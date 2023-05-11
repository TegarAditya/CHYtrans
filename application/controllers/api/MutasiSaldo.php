<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class MutasiSaldo extends REST_Controller
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
        $this->load->model('M_mutasi', 'mutasi');
        $this->load->model('M_post', 'Insert');
    }
    
    public function index_get()
    {
      
        $id = $this->get('id');

        if ( $id === null )
        {
            $data = $this->mutasi->get();
            if ( isset($data) )
            {
                // Set the response and exit
                $this->response( $data, 200 );
            }
            else
            {
                // Set the response and exit
                // $this->response( [
                //     'status'    => false,
                //     'message'   => 'Not found'
                // ], 404 );
            }
        }
        else
        {
            $data = $this->mutasi->getId($id);

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
        // Read and process the raw JSON input
        $mutations = json_decode(file_get_contents('php://input'));

        // Call the create_mutations() method in the model
        $result = $this->mutasi->create_mutations($mutations);
        if ($result > 0){
            $message = [
           'status' => TRUE,
           'message' => " insert success"];
           return $message;
           $this->response($message, REST_Controller::HTTP_OK);
       }
       else{
           $message = [
           'status' =>false,
           'text'=>"  insert fail"];
           return $message;
           $this->response($message, REST_Controller::HTTP_OK);
       }
        // Return the response message based on the result
        // $this->response($result, $result['status'] === 'fail' ? 400 : 200);
    }

 
    // public function index_put()
    // {
    //     $id = $this->put('id_mutasi');
    //     $data = [
    //         'id_mutasi'       => $this->put('id_mutasi'),
    //         'pendapatan_mutasi'          => $this->put('pendapatan_mutasi'),
    //         'tanggal_mutasi'    => $this->put('tanggal_mutasi'),
    //         'keterangan_mutasi'    => $this->put('keterangan_mutasi'),
    //         'detail_mutasi'    => $this->put('detail_mutasi'),
    //         'total_mutasi'    => $this->put('total_mutasi')

    //     ];

    //     if ($this->mutasi->updateMobil($data, $id) ) {
            

    //         $this->response(array($data,'status' => 'update success'), 201);
    //     } else {
    //         $this->response(array('status' => 'update fail', 502));
    //     }
    // }
  

    public function index_delete()
    {
        $id = $this->input->get('id');

        $hapus = $this->mutasi->deleteMutasi($id);

        if ($hapus) {
                    $this->response(array('status' => 'delete success'), 201);
                } else {
                    $this->response(array('status' => 'delete fail', 502));
                }
    }
    

}