<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
| -----------------------------------------------------
| PRODUCT NAME: 	STOCK MANAGER ADVANCE 
| -----------------------------------------------------
| AUTHER:			MIAN SALEEM 
| -----------------------------------------------------
| EMAIL:			saleem@tecdiary.com 
| -----------------------------------------------------
| COPYRIGHTS:		RESERVED BY TECDIARY IT SOLUTIONS
| -----------------------------------------------------
| WEBSITE:			http://tecdiary.net
| -----------------------------------------------------
|
| MODULE: 			Waiters
| -----------------------------------------------------
| This is waiters module's model file.
| -----------------------------------------------------
*/


class Waiters_model extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();

	}
	
	public function getAllWaiters() 
	{
		$q = $this->db->get('waiters');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
	
	public function waiters_count() {
        return $this->db->count_all("waiters");
    }

    public function fetch_waiters($limit, $start) {
        $this->db->limit($limit, $start);
		$this->db->order_by("id", "desc"); 
        $query = $this->db->get("waiters");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	
	public function getCustomerByID($id) 
	{

		$q = $this->db->get_where('waiters', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function getCustomerByEmail($email) 
	{

		$q = $this->db->get_where('waiters', array('email' => $email), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
	
	public function addCustomer($data = array())
	{
		
		// Customer data
		$customerData = array(
		    'nama'	     	   => $data['name'],
		    'alamat' 			=> $data['address'],
			'kontak'	     	  => $data['phone'],
		);

		if($this->db->insert('waiters', $customerData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateCustomer($id, $data = array())
	{
		
		// Customer data
		$customerData = array(
		    'nama'	     	   => $data['name'],
		    'alamat' 			=> $data['address'],
			'kontak'	     	  => $data['phone'],
		);
		
		$this->db->where('id', $id);
		if($this->db->update('waiters', $customerData)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function add_waiters($data = array())
	{
		
		if($this->db->insert_batch('waiters', $data)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function deleteCustomer($id) 
	{
		if($this->db->delete('waiters', array('id' => $id))) {
			return true;
		}
	return FALSE;
	}
	
	public function getCustomerNames($term)
    {
	   	$this->db->select('name');
	    $this->db->like('name', $term, 'both');
   		$q = $this->db->get('waiters');
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data; 
		}
    }

}
