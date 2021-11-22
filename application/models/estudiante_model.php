<?php

class estudiante_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this ->db_proyecto = $this->load->database('proyecto',TRUE);

	}
	function getestudiante()
	{
		$query=$this->db_proyecto->query("select *from tb_estudiante");
		return $query->result();
	}
	
}



?>