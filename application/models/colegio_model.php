<?php

class colegio_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this ->db_proyecto = $this->load->database('proyecto',TRUE);

	}
	function getcolegio()
	{
		$query=$this->db_proyecto->query("select *from Tb_colegio");
		return $query->result();
	}
	
}



?>