<?php
require APPPATH . '/libraries/REST_Controller.php';
class administrativo extends REST_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('administrativo_model');
	}
		public function getlistaAdministrativo_get()
		{
			$data = $this-> administrativo_model->getadministrativo();
			$respuesta =array(
				'error' => false,
				'mensaje' => 'Correcto, datos del administrativo',
				'datos' => $data);
		$this->response($respuesta, REST_Controller::HTTP_OK);
	}

}
?>