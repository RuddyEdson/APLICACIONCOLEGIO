<?php

class UsAdministrativo_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this ->db_proyecto = $this->load->database('proyecto',TRUE);

	}
	function verificar_login($CI_admin, $username, $Contraseña)
	{
		$query=$this->db_proyecto->query("SELECT u.estado as estadouser, p.CI_Admin as CI_UsAdmin,
											p.*, u.*
											FROM tb_administrativo p, tb_usuadmin u
											WHERE p.CI_Admin = u.CI_UsAdmin
											and u.CI_UsAdmin = '".$CI_admin."'
											and u.username = '".$username."'
											and u.contraseña = '".$Contraseña."'");

		return $query->result();
	}

	function getUsAdministrativo()
	{
		$query=$this->db_proyecto->query("SELECT 
												* FROM tb_administrativo p, tb_usuadmin u
													WHERE p.CI_Admin = u.CI_UsAdmin");

		return $query->result();
	}
	
	function guardarAdministrador($data)
	{
		$this->db_proyecto->insert('tb_administrativo', $data);
		return $this->db_proyecto->insert_id();

	}
	function guardarUsAdministrador($data)
	{
		$this->db_proyecto->insert('tb_usuadmin', $data);
		return $this->db_proyecto->insert_id();
		
	}

	function getAdministrativo($idAdmin)
	{
		$query =$this->db_proyecto->query("SELECT 
												* FROM tb_administrativo p
													WHERE p.id_Admin  = ".$idAdmin);
		return $query->result();
	}
	function updateAdministrador($idAdmin,$data)
	{
		$this->db_proyecto->where('id_Admin', $idAdmin);
		return $this->db_proyecto->update('tb_administrativo',$data);
	}
	function getverificarcontraseña($idusuario,$contraseña)
	{
		$query =$this->db_proyecto->query("SELECT 
												* FROM tb_usuadmin 
													WHERE id_usuarioad  = '".$idusuario."'
													 and contraseña  = '".$contraseña."'");
		return $query->result();
	}
	function updatecontraseña($idusAdm,$data)
	{
		$this->db_proyecto->where('id_usuarioad', $idusAdm);
		return $this->db_proyecto->update('tb_usuadmin',$data);
	}
}

?>