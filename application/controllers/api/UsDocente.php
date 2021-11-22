<?php
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/CreatorJwt.php';
class UsDocente extends REST_Controller{
	public function __construct(){
		parent::__construct();
		$this->objOfJwt = new CreatorJwt();
		header('Content-Type: application/json');
		$this->load->model('UsDocente_model');
	
	}
		public function getlistaUsuarioDocente_get()
		{
			
			try
			{ 
					$received_Token = $this->input->request_headers('Authorization');
					if(array_key_exists('Authorization', $received_Token))
					{
						$jwtData =$this->objOfJwt->DecodeToken($received_Token['Authorization']);
						$iduser = $jwtData['id_usuariodoc'];
						$data = $this-> UsDocente_model->getUsDocente();
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
		public function verificaruasurioDocente_ckeck($tipo)
		{
			if ($tipo == 'docente' || $tipo == 'Docente'|| $tipo == 'DOCENTE')
			{
				return true;
			}
			else 
			{
				$this->form_validation->set_message('verificaruasurio_ckeck', 'El campo {field} Los datos no son correctos !!');
				return false;
			}
		}

		function registarDocente_post()
		{
			$received_Token = $this->input->request_headers('Authorization');
			if(array_key_exists('Authorization', $received_Token))
			{
				$jwtData =$this->objOfJwt->DecodeToken($received_Token['Authorization']);
				$iduser = $jwtData['id_usuariodoc'];
				$data = $this->post();
				if(!(array_key_exists('CI_d',$data)
					&&array_key_exists('RDA',$data)
					&&array_key_exists('nombre_Completo',$data)
					&&array_key_exists('fcha_nacimiento',$data)
					&&array_key_exists('lugarNaci',$data)
					&&array_key_exists('DireccionAct',$data)
					&&array_key_exists('telefono',$data)
					&&array_key_exists('celular',$data)
					&&array_key_exists('email',$data)
					&&array_key_exists('profession',$data)
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
					
					if($this->form_validation->run('usDocente_post'))
					{
						$respuesta = $this->registrarDocente($data);
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

		function registrarDocente($data)
		{
			$nro_documento = trim($data['CI_d']);
			$nro_rda =trim(strtoupper($data['RDA']));
			$nom_completo =trim(strtoupper($data['nombre_Completo']));
			$fecha_naci =trim(strtoupper($data['fcha_nacimiento']));
			$lugarNac =trim(strtoupper($data['lugarNaci']));
			$direccion =trim(strtoupper($data['DireccionAct']));
			$tel =trim(strtoupper($data['telefono']));
			$cel =trim(strtoupper($data['celular']));
			$correo =trim(strtoupper($data['email']));
			$profesion =trim(strtoupper($data['profession']));
			$t_usuario =$data['tipo_usuario'];
			$contraseña =$data['contraseña'];

			$nombre_user =str_replace(" ", " ", $nom_completo);
			$username = $nro_rda.".".$t_usuario;
			$contraseñamd5 = md5($contraseña);

			$dataDocente = array(
				
				'CI_d' => $nro_documento,
				'RDA' => $nro_rda,
				'nombre_Completo' => $nom_completo,
				'fcha_nacimiento' => $fecha_naci,
				'LugarNaci' => $lugarNac,
				'DireccionAct' => $direccion,
				'telefono' => $tel,
				'celular' => $cel,
				'email' => $correo,
				'profession' => $profesion,
				'estado' => 'AC');
			$iddocente = $this->UsDocente_model->guardarDocente($dataDocente);

			$dataUsDocente = array(
				'CI_doce' => $nro_documento,
				'tipo_usuario' => $t_usuario ,
				'username ' => $username,
				'contraseña' => $contraseñamd5,
				'estado' => 'EX');
			$idUsDocente = $this->UsDocente_model->guardarUsDocente($dataUsDocente);
			$respuesta = array(
						'error' => false,
						'mensaje' => 'Registro Guardado correctamente',
						'id_docente ' => $iddocente,
						'id_usuariodoc' => $idUsDocente
						);
					return $respuesta;
		}
		public function modificarDoc_post()
		{
			$received_Token = $this->input->request_headers('Authorization');
			if(array_key_exists('Authorization', $received_Token))
			{
				$jwtData =$this->objOfJwt->DecodeToken($received_Token['Authorization']);
				$iduser = $jwtData['id_usuariodoc'];
				$data = $this->post();
				if(!(array_key_exists('CI_d',$data)
					&&array_key_exists('RDA',$data)
					&&array_key_exists('nombre_Completo',$data)
					&&array_key_exists('fcha_nacimiento',$data)
					&&array_key_exists('lugarNaci',$data)
					&&array_key_exists('DireccionAct',$data)
					&&array_key_exists('telefono',$data)
					&&array_key_exists('celular',$data)
					&&array_key_exists('email',$data)
					&&array_key_exists('profession',$data)
					&&array_key_exists('id_docente',$data)))
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
					if($this->form_validation->run('ModifusDocente_post'))
					{
						$respuesta = $this->modificarDocente($data);
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
		function modificarDocente($data)
		{
			$idDocente =trim($data['id_docente']);
			if($this->UsDocente_model->getDocente($idDocente))
			{
				$nro_documento = trim($data['CI_d']);
				$nro_rda =trim(strtoupper($data['RDA']));
				$nom_completo =trim(strtoupper($data['nombre_Completo']));
				$fecha_naci =trim(strtoupper($data['fcha_nacimiento']));
				$lugarNac =trim(strtoupper($data['lugarNaci']));
				$direccion =trim(strtoupper($data['DireccionAct']));
				$tel =trim(strtoupper($data['telefono']));
				$cel =trim(strtoupper($data['celular']));
				$correo =trim(strtoupper($data['email']));
				$profesion =trim(strtoupper($data['profession']));
				
				$dataMDocente = array(
							'CI_d' => $nro_documento,
							'RDA' => $nro_rda,
							'nombre_Completo' => $nom_completo,
							'fcha_nacimiento' => $fecha_naci,
							'LugarNaci' => $lugarNac,
							'DireccionAct' => $direccion,
							'telefono' => $tel,
							'celular' => $cel,
							'email' => $correo,
							'profession' => $profesion);


			$idDocenteUpdate = $this->UsDocente_model->updateDocente($idDocente,$dataMDocente);
			$respuesta = array(
					'error' => true,
					'mensaje' => 'Datos actualizados correctamente',
					'id_docente' =>$idDocente
					);
			}
			else
			{
				$respuesta = array(
					'error' => true,
					'mensaje' => 'Error el id del Docente no se necuentra registrado!!!'
					);
			}

			return $respuesta;
		}
		function cambiarclaveDocente_post()
		{
			$received_Token = $this->input->request_headers('Authorization');
			if(array_key_exists('Authorization', $received_Token))
			{
				$jwtData =$this->objOfJwt->DecodeToken($received_Token['Authorization']);
				$iduser = $jwtData['id_usuariodoc'];
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
					
					if($this->form_validation->run('cambiarclaveDocente_post'))
					{
						$respuesta = $this->actualizarcontraseñaDocente($iduser,$data);
						
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
		function actualizarcontraseñaDocente($idusuario,$data)
		{	
			$contraseñaactual =md5($data['contraseñaActual']);
			$nuevacontraseña =md5($data['Nuevacontraseña']);
			$confir =md5($data['confirmacion']);
			if($nuevacontraseña == $confir)
			{	
				if($nuevacontraseña != $contraseñaactual)
				{
					if($this->UsDocente_model->getverificarcontraseña($idusuario, $contraseñaactual))
					{
						$dataUsDocente = array(
							
						'contraseña' => $nuevacontraseña,
						'estado' => 'AC');
						$idusuario = $this->UsDocente_model->updatecontraseña($idusuario,$dataUsDocente);
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