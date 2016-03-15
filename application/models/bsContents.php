<?php
/*---------------------------------

---- Margus David
---- created: 02.02.2014
---- oDesk job - Custom PHP survey application
---- file: model - get contents,

---------------------------------*/

class bsContents extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function getContents()
	{
		$return = array();

		// get data from DB
		$ctns = $this->db->get('contents')->result_array();
		foreach($ctns as $v){
			$return[$v['role']] = $v['body'];
		}
		return $return;
	}
}
