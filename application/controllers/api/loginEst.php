<?php
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/CreatorJwt.php';
class loginEst extends REST_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->objOfJwt = new CreatorJwt();
		header('Content-Type: application/json');

		$this->load->model('UsEstudiante_model');
	}
	public function index_post()
	{
		$data = $this->post();
		if(array_key_exists('CI_estudi',$data)&&array_key_exists('username', $data)&& array_key_exists('contraseña',$data))
		{

			$CI_est = $this->post("CI_estudi");
			$username = $this->post("username");
			$Contraseña = $this->post("contraseña");
			$Contraseñamd5 = md5($Contraseña);

			$login = $this->UsEstudiante_model->verificar_loginest($CI_est, $username, $Contraseñamd5);
			if($login)
			{
				if($login[0]->estadouser == 'AC')
				{
				
					$date = new DateTime();
					$tokenData['id_usuario']= $login[0] -> id_usuario ;
					$tokenData['fecha']= date('Y-m-d H-i:s');
					$tokenData['iat']= $date->getTimestamp();
					$tokenData['exp']= $date->getTimestamp()+$this->config->item('jwt_token_expire');
					$jwtToken = $this->objOfJwt->GenerateToken($tokenData);

					$respuesta =array(
						'error' => true,
						'mensaje' => 'Correcto, datos del estudiante',
						'fecha' => date('Y-m-d H-i:s'),
						'Token' => $jwtToken
						);
			
					$this->response($respuesta, REST_Controller::HTTP_OK);
				}
				elseif($login[0]->estadouser == 'EX')
				{
					$date = new DateTime();
					$tokenData['id_usuario ']= $login[0] -> id_usuario ;
					$tokenData['fecha']= $date->getTimestamp();
					$jwtToken = $this->objOfJwt->GenerateToken($tokenData);

					$respuesta =array(
						'error' => true,
						'mensaje' => 'Actualice la contraseña',
						'fecha' => $date->getTimestamp(),
						'Token_Actualizacion' => $jwtToken
						//'login' => $login
						);
			
					$this->response($respuesta, REST_Controller::HTTP_OK);
				}
				elseif($login[0]->estadouser == 'BA')
				{
					$respuesta =array(
						'error' => TRUE,
						'mensaje' => 'Usuario desabilitado',
						//'login' => $login
						);
			
					$this->response($respuesta, REST_Controller::HTTP_NOT_FOUND);
				}
			}
			else
			{
				$respuesta =array(
					'error' => true,
					'mensaje' => 'Datos del Administrativo no existente',
				);
			
				$this->response($respuesta, REST_Controller::HTTP_NOT_FOUND);
			}
		}
		else
		{
			$respuesta =array(
					'error' => true,
					'mensaje' => 'debe introducir los parametros Correctos',
				);
			
			$this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
		}
	}
}
?>