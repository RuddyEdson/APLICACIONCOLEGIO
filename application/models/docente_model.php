<?php

class docente_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this ->db_proyecto = $this->load->database('proyecto',TRUE);

	}
	function getdocente()
	{
		$query=$this->db_proyecto->query("select *from tb_docente");
		return $query->result();
	}
	
}



?>