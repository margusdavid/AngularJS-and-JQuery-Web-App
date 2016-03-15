<?php
/*---------------------------------

---- Margus David
---- created: 02.02.2014
---- oDesk job - Custom PHP survey application
---- file: model - global model for BS app,

---------------------------------*/

class bsData extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function getQuestions()
	{
		$return = array();

		// get data from DB
		$questions = $this->db->get('questions')->result_array();
		foreach($questions as $v){
			$return[$v['id']] = array(
				'title' => $v['title'],
				'question' => $v['question'],
			);
		}
		return $return;
	}

	function getResult($values)
	{
		$return = array();

		// get data from DB
		$orgs = $this->db->get('orgs')->result_array();
		foreach($orgs as $v){
			$org_values = json_decode($v['values']);
			$match_flag = 0;
			foreach($org_values as $o_v){
				if($o_v == $values[0] || $o_v == $values[1]) $match_flag++;
			}
			if($match_flag >= 2)
			$return[$v['id']] = array(
				"name" => $v['name'],
				"link" => $v['link'],
				"img" => $this->config->item('base_url')."contents/".strtolower(str_replace(" ", "_", $v['name'])).".jpg",
			);;
		}
		return $return;
	}

	function addNew($users, $answers, $result)
	{
		// update users table
		if(!$this->db->insert('users', $users)) return false;
		$user_id = $this->db->insert_id();
		
		// update answers table
		$data = array(
			'user_id' => $user_id,
			'answers' => $this->getJSON($answers),
			'result' => $this->getJSON($result)
		);
		if(!$this->db->insert('answers', $data)) return false;
		return true;
	}

	function getJSON($array){
		return json_encode($array);
	}

	function parseJSON($jsonString)
	{
		return json_decode($jsonString, true);
	}
}
