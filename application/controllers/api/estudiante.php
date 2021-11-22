<?php
require APPPATH . '/libraries/REST_Controller.php';
class estudiante extends REST_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('estudiante_model');
	}
		public function getlistaestudiante_get()
		{
			$data = $this-> estudiante_model->getestudiante();
			$respuesta =array(
				'error' => false,
				'mensaje' => 'Correcto, datos del estudiante',
				'datos' => $data);
		$this->response($respuesta, REST_Controller::HTTP_OK);
	}

}
?>