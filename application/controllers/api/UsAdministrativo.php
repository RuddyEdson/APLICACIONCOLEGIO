<?php
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/CreatorJwt.php';
class UsAdministrativo extends REST_Controller{
	public function __construct(){
		parent::__construct();
		$this->objOfJwt = new CreatorJwt();
		header('Content-Type: application/json');
		$this->load->model('UsAdministrativo_model');
	
	}
		public function getlistaUsuarioAdmin_get()
		{
			
			try
			{ 
					$received_Token = $this->input->request_headers('Authorization');
					if(array_key_exists('Authorization', $received_Token))
					{
						$jwtData =$this->objOfJwt->DecodeToken($received_Token['Authorization']);
						$iduser = $jwtData['id_usuarioad'];
						$data = $this-> UsAdministrativo_model->getUsAdministrativo();
						if($data)
						{
								$respuesta =array(
								'error' => false,
								'mensaje' => 'Correcto, datos del Usuario Administrativo',
								'datos' => $data,
								'token' => $jwtData,
								'iduser' => $iduser);
							$this->response($respuesta, REST_Controller::HTTP_OK);
						}
						else
						{
							$respuesta =array(
								'error' => true,
								'mensaje' => 'No se recupero ningun registro del personal administrativo',
								'datos' => null
								);
							$this->response($respuesta, REST_Controller::HTTP_NOT_FOUND);
						}
						
					}
					else
					{
						$respuesta =array(
							'error' => true,
							'mensaje' => 'Acceso denegado!!!'
							);
						$this->response($respuesta, REST_Controller::HTTP_OK);
					}
			}
			catch(Exception $e)
			{
				http_response_code('401');
				$respuesta = array(
									"status" => false,
									"message" => $e->getMessage()
									);
				echo json_encode($respuesta);
				exit;
			}
		}
		public function verificarcadena_ckeck($cadena)
		{
			$patron = "/^[a-zA-Z\sñáéíóúÁÉÍÓ]+$/";
			if (preg_match($patron, $cadena))
			{
				return true;
			}
			else
			{
				$this->form_validation->set_message('verificarcadena_ckeck', 'El campo {field} solo debe contener letras');
				return false;
			}
		}
		public function verificaruasurio_ckeck($tipo)
		{
			if ($tipo == 'administrativo' || $tipo == 'Administrativo'|| $tipo == 'ADMINISTRATIVO')
			{
				return true;
			}
			else 
			{
				$this->form_validation->set_message('verificaruasurio_ckeck', 'El campo {field} Los datos no son correctos !!');
				return false;
			}
		}

		function registar_post()
		{
			$received_Token = $this->input->request_headers('Authorization');
			if(array_key_exists('Authorization', $received_Token))
			{
				$jwtData =$this->objOfJwt->DecodeToken($received_Token['Authorization']);
				$iduser = $jwtData['id_usuarioad'];
				$data = $this->post();
				if(!(array_key_exists('CI_Admin',$data)
					&&array_key_exists('RDA',$data)
					&&array_key_exists('nombre_Completo',$data)
					&&array_key_exists('fcha_nacimiento',$data)
					&&array_key_exists('LugarNac',$data)
					&&array_key_exists('direccion',$data)
					&&array_key_exists('cargo',$data)
					&&array_key_exists('celular',$data)
					&&array_key_exists('telefono',$data)
					&&array_key_exists('email',$data)
					&&array_key_exists('tipo_usuario',$data)
					&&array_key_exists('username',$data)
					&&array_key_exists('contraseña',$data)))
				{
					$respuesta =array(
						'error' => true,
						'mensaje' => 'debe introducir los parametros Correctos',
							);
				
						$this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);


				}
				else
				{
					$this->load->library('form_validation');
					$this->form_validation->set_data($data);
					/*$this->form_validation->set_rules('RDA','RDA','required');
					$this->form_validation->set_rules('nombre_Completo','nombre_Completo','required');
					$this->form_validation->set_rules('fcha_nacimiento','fcha_nacimiento','required');
					$this->form_validation->set_rules('Lugar / Nac','Lugar / Nac','required');
					$this->form_validation->set_rules('direccion','direccion','required');
					$this->form_validation->set_rules('celular','celular','required');
					$this->form_validation->set_rules('telefono','telefono','required');
					$this->form_validation->set_rules('tipo_usuario','tipo_usuario','required');
					$this->form_validation->set_rules('username','username','required');
					$this->form_validation->set_rules('contraseña','contraseña','required');*/
					//if($this->form_validation->run()==false)
					if($this->form_validation->run('usadmin_post'))
					{
						$respuesta = $this->registrarAdministrativo($data);
					}
					else
					{
						
						$respuesta = array(
						'error' => false,
						'mensaje' => 'datos incorrectos',
						'errores' => $this->form_validation->get_errores_arreglo(),
						);
					}

					
					
					$this->response($respuesta, REST_Controller::HTTP_OK);
				}

				
			}
			else
			{
				$respuesta = array(
					'error' => true,
					'mensaje' => 'Acceso denegado!!!'
					);
				$this->response($respuesta, REST_Controller::HTTP_OK);
			}
		}

		function registrarAdministrativo($data)
		{
			$nro_documento = trim($data['CI_Admin']);
			$nro_rda =trim(strtoupper($data['RDA']));
			$nom_completo =trim(strtoupper($data['nombre_Completo']));
			$fecha_naci =trim(strtoupper($data['fcha_nacimiento']));
			$lugarNac =trim(strtoupper($data['LugarNac']));
			$direccion =trim(strtoupper($data['direccion']));
			$cargo =trim(strtoupper($data['cargo']));
			$cel =trim(strtoupper($data['celular']));
			$tel =trim(strtoupper($data['telefono']));
			$correo =trim(strtoupper($data['email']));
			$t_usuario =$data['tipo_usuario'];
			$contraseña =$data['contraseña'];

			$nombre_user =str_replace(" ", " ", $nom_completo);
			$username = $cel.".".$nombre_user;
			$contraseñamd5 = md5($contraseña);

			$dataAdmin = array(
				'CI_Admin' => $nro_documento,
				'RDA' => $nro_rda,
				'nombre_Completo' => $nom_completo,
				'fcha_nacimiento' => $fecha_naci,
				'LugarNac' => $lugarNac,
				'direccion' => $direccion,
				'cargo' => $cargo,
				'celular' => $cel,
				'telefono' => $tel,
				'email' => $correo,
				'estado' => 'AC');
			$idAdministrativo = $this->UsAdministrativo_model->guardarAdministrador($dataAdmin);

			$dataUsAdmin = array(
				'CI_UsAdmin' => $nro_documento,
				'tipo_usuario' => $t_usuario ,
				'username ' => $username,
				'contraseña' => $contraseñamd5,
				'estado' => 'EX');
			$idUsAdministrativo = $this->UsAdministrativo_model->guardarUsAdministrador($dataUsAdmin);
			$respuesta = array(
						'error' => false,
						'mensaje' => 'Registro Guardado correctamente',
						'id_Admin' => $idAdministrativo,
						'id_usuarioad' => $idUsAdministrativo
						);
					return $respuesta;
		}
		public function modificarAdmin_post()
		{
			$received_Token = $this->input->request_headers('Authorization');
			if(array_key_exists('Authorization', $received_Token))
			{
				$jwtData =$this->objOfJwt->DecodeToken($received_Token['Authorization']);
				$iduser = $jwtData['id_usuarioad'];
				$data = $this->post();
				if(!(array_key_exists('CI_Admin',$data)
					&&array_key_exists('RDA',$data)
					&&array_key_exists('nombre_Completo',$data)
					&&array_key_exists('fcha_nacimiento',$data)
					&&array_key_exists('LugarNac',$data)
					&&array_key_exists('direccion',$data)
					&&array_key_exists('cargo',$data)
					&&array_key_exists('celular',$data)
					&&array_key_exists('telefono',$data)
					&&array_key_exists('email',$data)
					&&array_key_exists('id_Admin',$data)))
				{
					$respuesta =array(
						'error' => true,
						'mensaje' => 'debe introducir los parametros Correctos',
							);
				
						$this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);


				}
				else
				{
					$this->load->library('form_validation');
					$this->form_validation->set_data($data);
					
					if($this->form_validation->run('modificarusAdmin_post'))
					{
						$respuesta = $this->modificarAdministrativo($data);
					}
					else
					{
						
						$respuesta = array(
						'error' => false,
						'mensaje' => 'datos incorrectos',
						'errores' => $this->form_validation->get_errores_arreglo(),
						);
					}

					
					
					$this->response($respuesta, REST_Controller::HTTP_OK);
				}

				
			}
			else
			{
				$respuesta = array(
					'error' => true,
					'mensaje' => 'Acceso denegado!!!'
					);
				$this->response($respuesta, REST_Controller::HTTP_OK);
			}
		}
		function modificarAdministrativo($data)
		{
			$idAdmin =trim($data['id_Admin']);
			if($this->UsAdministrativo_model->getAdministrativo($idAdmin))
			{
				$nro_documento = trim($data['CI_Admin']);
				$nro_rda =trim(strtoupper($data['RDA']));
				$nom_completo =trim(strtoupper($data['nombre_Completo']));
				$fecha_naci =trim(strtoupper($data['fcha_nacimiento']));
				$lugarNac =trim(strtoupper($data['LugarNac']));
				$direccion =trim(strtoupper($data['direccion']));
				$cargo =trim(strtoupper($data['cargo']));
				$cel =trim(strtoupper($data['celular']));
				$tel =trim(strtoupper($data['telefono']));
				$correo =trim(strtoupper($data['email']));
				$dataMAdmin = array(
							'CI_Admin' => $nro_documento,
							'RDA' => $nro_rda,
							'nombre_Completo' => $nom_completo,
							'fcha_nacimiento' => $fecha_naci,
							'LugarNac' => $lugarNac,
							'direccion' => $direccion,
							'cargo' => $cargo,
							'celular' => $cel,
							'telefono' => $tel,
							'email' => $correo);

			$idAdminupdate = $this->UsAdministrativo_model->updateAdministrador($idAdmin,$dataMAdmin);
			$respuesta = array(
					'error' => true,
					'mensaje' => 'Datos actualizados correctamente',
					'idAdmin' =>$idAdmin
					);
			}
			else
			{
				$respuesta = array(
					'error' => true,
					'mensaje' => 'Error el id del administrador no se necuentra registrado!!!'
					);
			}

			return $respuesta;
		}
		function cambiarclave_post()
		{
			$received_Token = $this->input->request_headers('Authorization');
			if(array_key_exists('Authorization', $received_Token))
			{
				$jwtData =$this->objOfJwt->DecodeToken($received_Token['Authorization']);
				$iduser = $jwtData['id_usuarioad'];
				$data = $this->post();
				if(!(array_key_exists('contraseñaActual',$data)
					&&array_key_exists('Nuevacontraseña',$data)
					&&array_key_exists('confirmacion',$data)))
				{
					$respuesta =array(
						'error' => true,
						'mensaje' => 'debe introducir los parametros Correctos',
							);
				
						$this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);


				}
				else
				{
					$this->load->library('form_validation');
					$this->form_validation->set_data($data);
					
					if($this->form_validation->run('cambiarclave_post'))
					{
						$respuesta = $this->actualizarcontraseña($iduser,$data);
						
					}
					else
					{
						
						$respuesta = array(
						'error' => false,
						'mensaje' => 'datos incorrectos',
						'errores' => $this->form_validation->get_errores_arreglo(),
						);
					}

					
					
					$this->response($respuesta, REST_Controller::HTTP_OK);
				}

				
			}
			else
			{
				$respuesta = array(
					'error' => true,
					'mensaje' => 'Acceso denegado!!!'
					);
				$this->response($respuesta, REST_Controller::HTTP_OK);
			}
		}
		function actualizarcontraseña($idusuario,$data)
		{	
			$contraseñaactual =md5($data['contraseñaActual']);
			$nuevacontraseña =md5($data['Nuevacontraseña']);
			$confir =md5($data['confirmacion']);
			if($nuevacontraseña == $confir)
			{	
				if($nuevacontraseña != $contraseñaactual)
				{
					if($this->UsAdministrativo_model->getverificarcontraseña($idusuario, $contraseñaactual))
					{
						$dataUsAdmin = array(
							
						'contraseña' => $nuevacontraseña,
						'estado' => 'AC');
						$idusuario = $this->UsAdministrativo_model->updatecontraseña($idusuario,$dataUsAdmin);
						$respuesta = array(
						'error' => false,
							'mensaje' => 'Contraseña Actualizada correctamente',
							'estado' => 'AC',
							'idusuario' => $idusuario);
					}
					else
					{
						$respuesta = array(
						'error' => true,
						'mensaje' => 'error la  contraseña actual no es correcta');
					}
				}
				else
				{
					$respuesta = array(
					'error' => true,
					'mensaje' => 'error la nueva contraseña debe ser diferente a la actual');
				}
			}
			else
			{
				$respuesta = array(
				'error' => true,
				'mensaje' => 'error no coicide la nueva contraseña');
			}
			return $respuesta;
		}
	}	

?>