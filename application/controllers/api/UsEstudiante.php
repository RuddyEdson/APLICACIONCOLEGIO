<?php
require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/CreatorJwt.php';
class UsEstudiante  extends REST_Controller{
	public function __construct(){
		parent::__construct();
		$this->objOfJwt = new CreatorJwt();
		header('Content-Type: application/json');
		$this->load->model('UsEstudiante_model');
	}
		public function getlistaUsuarioEst_get()
		{
			
			try
			{ 
					$received_Token = $this->input->request_headers('Authorization');
					if(array_key_exists('Authorization', $received_Token))
					{
						$jwtData =$this->objOfJwt->DecodeToken($received_Token['Authorization']);
						$idestu = $jwtData['id_usuario'];
						$data = $this-> UsEstudiante_model->getUsEstudiante();
						if($data)
						{
								$respuesta =array(
								'error' => false,
								'mensaje' => 'Correcto, datos del Usuario Estudiante',
								'datos' => $data,
								'token' => $jwtData,
								'iduser' => $idestu);
							$this->response($respuesta, REST_Controller::HTTP_OK);
						}
						else
						{
							$respuesta =array(
								'error' => true,
								'mensaje' => 'No se recupero ningun registro de los estudiantes',
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
			if ($tipo == 'estudiante' || $tipo == 'Estudiante'|| $tipo == 'ESTUDIANTE')
			{
				return true;
			}
			else 
			{
				$this->form_validation->set_message('verificaruasurio_ckeck', 'El campo {field} Los datos no son correctos !!');
				return false;
			}
		}

		function registarestudiante_post()
		{
			$received_Token = $this->input->request_headers('Authorization');
			if(array_key_exists('Authorization', $received_Token))
			{
				$jwtData =$this->objOfJwt->DecodeToken($received_Token['Authorization']);
				$iduser = $jwtData['id_estudiante'];
				$data = $this->post();
				if(!(array_key_exists('RUDE',$data)
					&&array_key_exists('CI_estudi',$data)
					&&array_key_exists('Nombres',$data)
					&&array_key_exists('Ap_paterno',$data)
					&&array_key_exists('Ap_materno',$data)
					&&array_key_exists('genero',$data)
					&&array_key_exists('fcha_nacimiento',$data)
					&&array_key_exists('LugarNac',$data)
					&&array_key_exists('direccion_act',$data)
					&&array_key_exists('celular',$data)
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
					
					if($this->form_validation->run('usEstu_post'))
					{
						$respuesta = $this->registrarEstudiante($data);
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

		function registrarEstudiante($data)
		{
			
			$nro_rude =trim(strtoupper($data['RUDE']));
			$nro_documento = trim($data['CI_estudi']);
			$nomb =trim(strtoupper($data['Nombres']));
			$paterno =trim(strtoupper($data['Ap_paterno']));
			$materno =trim(strtoupper($data['Ap_materno']));
			$genero =trim(strtoupper($data['genero']));
			$fchaNac =trim(strtoupper($data['fcha_nacimiento']));
			$lugarNac =trim(strtoupper($data['LugarNac']));
			$diract =trim(strtoupper($data['direccion_act']));
			$cel =trim(strtoupper($data['celular']));
			$correo =trim(strtoupper($data['email']));
			$t_usuario =$data['tipo_usuario'];
			$contraseña =$data['contraseña'];

			$nombre_user =str_replace(" ", " ", $nom_completo);
			$username = $cel.".".$nombre_user;
			$contraseñamd5 = md5($contraseña);

			$dataestu = array(
				'CI_est'=> $nro_documento,
				'RUDE'=> $nro_rude,
				'Nombres'=> $nomb,
				'Ap_paterno'=> $paterno,
				'Ap_materno'=> $materno,
				'genero'=> $genero,
				'fcha_nacimiento'=> $fchaNac,
				'LugarNac'=> $lugarNac,
				'direccion_act'=> $diract,
				'celular'=> $cel,
				'email'=> $correo,
				'estado' => 'AC');

			$idestudiante = $this->UsEstudiante_model->guardarEstudiante($dataestu);

			$dataUsEst = array(
				'CI_estudi' => $nro_documento,
				'tipo_usuario' => $t_usuario ,
				'username ' => $username,
				'contraseña' => $contraseñamd5,
				'estado' => 'EX');
			$idUsEstudiante = $this->UsEstudiante_model->guardarUsAdministrador($dataUsAdmin);
			$respuesta = array(
						'error' => false,
						'mensaje' => 'Registro Guardado correctamente',
						'id_estu' => $idestudiante,
						'id_usuario' => $idUsEstudiante
						);
					return $respuesta;
		}
		public function modificarEst_post()
		{
			$received_Token = $this->input->request_headers('Authorization');
			if(array_key_exists('Authorization', $received_Token))
			{
				$jwtData =$this->objOfJwt->DecodeToken($received_Token['Authorization']);
				$iduser = $jwtData['id_usuario'];
				$data = $this->post();
				if(!(array_key_exists('RUDE',$data)
					&&array_key_exists('CI_estudi',$data)
					&&array_key_exists('Nombres',$data)
					&&array_key_exists('Ap_paterno',$data)
					&&array_key_exists('Ap_materno',$data)
					&&array_key_exists('genero',$data)
					&&array_key_exists('fcha_nacimiento',$data)
					&&array_key_exists('LugarNac',$data)
					&&array_key_exists('direccion_act',$data)
					&&array_key_exists('celular',$data)
					&&array_key_exists('email',$data)
					&&array_key_exists('id_estudiante',$data)))
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
					if($this->form_validation->run('ModifusEstu_post'))
					{
						$respuesta = $this->modificarEstudiante($data);
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
		function modificarEstudiante($data)
		{
			$idestudiante =trim($data['id_estudiante']);
			if($this->UsEstudiante_model->getEstudiante($idestudiante))
			{
				$nro_documento = trim($data['CI_estudi']);
				$nro_rude =trim(strtoupper($data['RUDE']));
				$nomb =trim(strtoupper($data['Nombres']));
				$paterno =trim(strtoupper($data['Ap_paterno']));
				$materno =trim(strtoupper($data['Ap_materno']));
				$genero =trim(strtoupper($data['genero']));
				$fchaNac =trim(strtoupper($data['fcha_nacimiento']));
				$lugarNac =trim(strtoupper($data['LugarNac']));
				$diract =trim(strtoupper($data['direccion_act']));
				$cel =trim(strtoupper($data['celular']));
				$correo =trim(strtoupper($data['email']));
				$dataMEstu = array(
							'CI_estudi'=> $nro_documento,
							'RUDE'=> $nro_rude,
							'Nombres'=> $nomb,
							'Ap_paterno'=> $paterno,
							'Ap_materno'=> $materno,
							'genero'=> $genero,
							'fcha_nacimiento'=> $fchaNac,
							'LugarNac'=> $lugarNac,
							'direccion_act'=> $diract,
							'celular'=> $cel,
							'email' => $correo);

			$idestuupdate = $this->UsEstudiante_model->updateEstudiante($idestudiante,$dataMEstu);
			$respuesta = array(
					'error' => true,
					'mensaje' => 'Datos actualizados correctamente',
					'idAdmin' =>$idestudiante
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
				$iduser = $jwtData['id_usuario'];
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
					
					if($this->form_validation->run('cambiarclaveestu_post'))
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
		function actualizarcontraseñaE($idusuario,$data)
		{	
			$contraseñaactual =md5($data['contraseñaActual']);
			$nuevacontraseña =md5($data['Nuevacontraseña']);
			$confir =md5($data['confirmacion']);
			if($nuevacontraseña == $confir)
			{	
				if($nuevacontraseña != $contraseñaactual)
				{
					if($this->UsEstudiante_model->getverificarcontraseñaE($idusuario, $contraseñaactual))
					{
						$dataUsAdmin = array(
							
						'contraseña' => $nuevacontraseña,
						'estado' => 'AC');
						$idusuario = $this->UsEstudiante_model->updatecontraseñaEs($idusuario,$dataUsAdmin);
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