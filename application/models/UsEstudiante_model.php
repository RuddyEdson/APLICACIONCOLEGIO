<?php

class UsEstudiante_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this ->db_proyecto = $this->load->database('proyecto',TRUE);

	}


	function verificar_loginest($CI_estu, $username, $Contraseña)
	{
		$query=$this->db_proyecto->query("SELECT u.estado as estadouser, p.CI_est  as CI_estudi,
											p.*, u.*
											FROM tb_estudiante p, tb_estusuario u
											WHERE p.CI_est = u.CI_estudi
											and u.CI_estudi = '".$CI_estu."'
											and u.username = '".$username."'
											and u.contraseña = '".$Contraseña."'");

		return $query->result();
	}
	function getUsEstudiante()
	{
		$query=$this->db_proyecto->query("SELECT 
												* FROM tb_estusuario p,  tb_estudiante u 
													WHERE p.CI_est = u.CI_estudi");

		return $query->result();
	}
	
	function guardarEstudiante($data)
	{
		$this->db_proyecto->insert('tb_estudiante', $data);
		return $this->db_proyecto->insert_id();

	}
	function guardarUsestudiante($data)
	{
		$this->db_proyecto->insert('tb_estusuario', $data);
		return $this->db_proyecto->insert_id();
		
	}

	function getEstudiante($idEStudiante)
	{
		$query =$this->db_proyecto->query("SELECT 
												* FROM tb_estudiante p
													WHERE p.id_estudiante   = ".$idEStudiante);
		return $query->result();
	}
	function updateEstudiante($idEstu,$data)
	{
		$this->db_proyecto->where('id_estudiante', $idEstu);
		return $this->db_proyecto->update('tb_estudiante',$data);
	}
	function getverificarcontraseñaE($idusuario,$contraseña)
	{
		$query =$this->db_proyecto->query("SELECT 
												* FROM tb_estusuario 
													WHERE id_usuario  = '".$idusuario."'
													 and contraseña  = '".$contraseña."'");
		return $query->result();
	}
	function updatecontraseñaEs($idusEst,$data)
	{
		$this->db_proyecto->where('id_usuario ', $idusEst);
		return $this->db_proyecto->update('tb_estusuario',$data);
	}
 }

?>