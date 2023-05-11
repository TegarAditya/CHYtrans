<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_post extends CI_Model {



	public function insert($table,$data)
	{
		$this->db->insert($table, $data);
		$insert=$this->db->affected_rows();
		if ($insert > 0){
			 $message = [
            'status' => TRUE,
            'message' => " $table insert success"];
            return $message;
		}
		else{
			$message = [
            'status' =>false,
            'text'=>" $table insert fail"];
            return $message;
		}
	}
	


}
