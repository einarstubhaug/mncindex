<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CurrencyIndex extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('page');
	}

	public function registerNation () {
		$this->load->model('Mncindex_model');
		$data = array(
			"macroISOCodes" => $this->Mncindex_model->getMacroISOCodes(),
			"microISOCodes" => $this->Mncindex_model->getMicroISOCodes()
		);
		$this->load->view('registerMicronation', $data);
	}

	public function submitregistrationform () {
		$this->load->model('Mncindex_model');
		$this->Mncindex_model->registerMicronationForm();
		
	}

	public function flag () {
		echo "hei";
	}
}
