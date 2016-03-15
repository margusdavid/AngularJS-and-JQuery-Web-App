<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------

---- Margus David
---- created: 02.02.2014
---- oDesk job - Custom PHP survey application
---- file: model - ajax controller for ajax call

---------------------------------*/

class Bs_api extends CI_Controller {

	public function __construct(){
		parent::__construct();

		// load model -----------------
		$this->load->model('bsData', 'bs_data');
	}
	
	public function index()
	{
		if(!isset($_REQUEST['action']) || !$_REQUEST['action']){
			$return = array(
				"result" => array(),
				"error" => "E102"
			);
			echo $this->bs_data->getJSON($return);
			return;
		}	
		
		switch($_REQUEST['action']){
			case 'result':
				$this->result($_REQUEST);
				break;
			case 'contact':
				$this->contact($_REQUEST);
				break;
			default:
				$return = array(
					"result" => array(),
					"error" => "E102"
				);
				echo $this->bs_data->getJSON($return);
				break;
		}
		return;
	}

	function result($params)
	{
		// confirm post parameters
		if(!isset($params['values']) || !$params['values']){
			$return = array(
				"result" => array(),
				"error" => "E102"
			);
			echo $this->bs_data->getJSON($return);
			return;
		}	

		// get result...
		echo $this->bs_data->getJSON(array(
			"result" => $this->bs_data->getResult($params['values'])
		));
		return;
	}

	function contact($params)
	{		
		// confirm paramters
		if(!isset($params['gender']) || !$params['gender'] ||
			!isset($params['email']) || !$params['email'] ||
			!isset($params['hours']) || !$params['hours'] ||
			!isset($params['answers']) || !$params['answers'] ||
			!isset($params['result']) || !$params['result']){
			$return = array(
				"success" => false,
				"error" => "E102"
			);
			echo $this->bs_data->getJSON($return);
			return;
		}

		// get datas
		if($this->bs_data->addNew(
				array(
					'gender' => $params['gender'],
					'email' => $params['email'],
					'hours' => $params['hours']
				), 
				$params['answers'], 
				$params['result']
			)
		){
			$return = array("success" => true);
		} else {
			$return = array("success" => false);
		}
		echo $this->bs_data->getJSON($return);
		return;
	}
}

/* End of file ajaxbs.php */
/* Location: ./application/controllers/ajaxbs.php */