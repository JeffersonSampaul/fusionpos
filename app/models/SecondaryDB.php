<?php
class SecondaryDB extends ClientDB{	    
	function connect($host,$table){		
		$db=$this->setdb($host);	
		return $db->table($table);		
	}	
}
?>