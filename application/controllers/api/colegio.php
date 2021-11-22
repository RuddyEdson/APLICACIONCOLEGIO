<?php
require APPPATH . '/libraries/REST_Controller.php';
class colegio extends REST_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('colegio_model');
	}
		public function getlistacolegio_get()
		{
			$data = $this-> colegio_model->getcolegio();
			$respuesta =array(
				'error' => false,
				'mensaje' => 'Correcto, datos del colegio',
				'datos' => $data);
		$this->response($respuesta, REST_Controller::HTTP_OK);
	}

}
?>