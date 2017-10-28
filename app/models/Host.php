<?php
class Host extends ClientDB{	
	private $db;	
	function __construct($host){
		$ClientDB=new ClientDB();
		$this->db=$ClientDB->setdb($host);
	}
	function table($table){	
		return $this->db->table($table);		
	}	
}
?>