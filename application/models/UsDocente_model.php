<?php

class UsDocente_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this ->db_proyecto = $this->load->database('proyecto',TRUE);

	}
	
	function verificar_login($CI_doc, $username, $Contraseña)
	{
		$query=$this->db_proyecto->query("SELECT u.estado as estadouser, p.CI_d  as CI_doce ,
											p.*, u.*
											FROM tb_docente p, tb_usudoce u
											WHERE p.CI_d  = u.CI_doce 
											and u.CI_doce  = '".$CI_doc."'
											and u.username = '".$username."'
											and u.contraseña = '".$Contraseña."'");

		return $query->result();
	}
	function getUsDocente()
	{
		$query=$this->db_proyecto->query("SELECT 
												* FROM tb_docente p, tb_usudoce u
													WHERE p.CI_d  = u.CI_doce");

		return $query->result();
	}
	function guardarDocente($data)
	{
		$this->db_proyecto->insert('tb_docente', $data);
		return $this->db_proyecto->insert_id();

	}
	function guardarUsDocente($data)
	{
		$this->db_proyecto->insert('tb_usudoce', $data);
		return $this->db_proyecto->insert_id();
		
	}
	function getDocente($iddocente)
	{
		$query =$this->db_proyecto->query("SELECT 
												* FROM tb_docente p
													WHERE p.id_docente  = ".$iddocente);
		return $query->result();
	}
	function updateDocente($iddocente,$data)
	{
		$this->db_proyecto->where('id_docente', $iddocente);
		return $this->db_proyecto->update('tb_docente',$data);
	}
	function getverificarcontraseña($iddocente,$contraseña)
	{
		$query =$this->db_proyecto->query("SELECT 
												* FROM tb_usudoce 
													WHERE id_usuariodoc   = '".$iddocente."'
													 and contraseña  = '".$contraseña."'");
		return $query->result();
	}
	function updatecontraseña($idusDoc,$data)
	{
		$this->db_proyecto->where('id_usuariodoc', $idusDoc);
		return $this->db_proyecto->update('tb_usudoce',$data);
	}

}

?>