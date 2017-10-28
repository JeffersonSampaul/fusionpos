<?php
class ClientDB extends Eloquent{	
	protected $table = 'tbl_bridge';
	protected function setdb($host){
		$old=$this->table;
		$this->table='tbl_bridge';
		$conn=ClientDB::where("domain",$host)->first();
		$this->table=$old;
		if($conn){
		Config::set('database.connections.client.database', $conn->db);
		Config::set('database.connections.client.username', $conn->duser);
		Config::set('database.connections.client.password', $this->decript($conn->dpass));
		Config::set('database.connections.client.host', $conn->host);
		return DB::connection('client');
		}
		else
			return false;
	}
	private function decript($text){
		$salt='(^%(^@@&!^250691';
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
		
	}
}
?>