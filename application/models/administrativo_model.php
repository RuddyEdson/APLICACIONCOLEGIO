<?php

class administrativo_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this ->db_proyecto = $this->load->database('proyecto',TRUE);

	}
	function getadministrativo()
	{
		$query=$this->db_proyecto->query("select *from tb_administrativo");
		return $query->result();
	}
	
}



?>