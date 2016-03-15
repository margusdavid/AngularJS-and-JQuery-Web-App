<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------

---- Margus David
---- created: 02.02.2014
---- oDesk job - Custom PHP survey application
---- file: form view controller,

---------------------------------*/

class View extends CI_Controller {

	public function __construct(){
		parent::__construct();

		// load library -----------------
		$this->load->library('parser');

		// load model -----------------
		$this->load->model('bsContents', 'bs_ctn');
		$this->load->model('bsData', 'bs_data');
	}

	public function index()
	{
		// get form data -----------------
		$data = array(
			"base_url" => $this->config->item('base_url'),
		);
		// get contents
		$data = array_merge($data, $this->bs_ctn->getContents());

		// get questions
		$data["questions"] = $this->bs_data->getQuestions();

		// create form -----------------
		$this->parser->parse('form', $data);
	}
}

/* End of file view.php */
/* Location: ./application/controllers/view.php */