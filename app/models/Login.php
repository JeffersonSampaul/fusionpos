<?php
class Login extends ClientDB{		
	protected $table = 'tbl_login';
	function connect($host){		
		$db=$this->setdb($host);	
		return $db->table($this->table);		
	}	
}
?>