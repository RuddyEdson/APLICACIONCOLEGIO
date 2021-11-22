<?php
require APPPATH . '/libraries/REST_Controller.php';
class docente extends REST_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('docente_model');
	}
		public function getlistadocente_get()
		{
			$data = $this-> docente_model->getdocente();
			$respuesta =array(
				'error' => false,
				'mensaje' => 'Correcto, datos del docente',
				'datos' => $data);
		$this->response($respuesta, REST_Controller::HTTP_OK);
	}

}
?>