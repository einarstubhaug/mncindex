<?php
class Api extends CI_Controller {
    public function micronations () {
        $this->load->model('Mncindex_model');
        $micronations = $this->Mncindex_model->getMicronations();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($micronations));
    }

    public function fetchAndSaveCurrencies () {
        $this->load->model('Mncindex_model');
        $this->Mncindex_model->fetchAndSaveCurrencies();
    }

    public function flag ($misocode) {
        header('Content-type: image/png');
        if (file_exists(FCPATH . "assets/img/flags/" . $misocode . ".png")){
		readfile (FCPATH . "assets/img/flags/" . $misocode . ".png");
    	}
    }
}
