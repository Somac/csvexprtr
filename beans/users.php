<?php
class users {
	private $user_id;
	private $hash;

	public function getUser_id(){
		return $this->user_id;
	}

	public function setUser_id($user_id){
		$this->user_id = $user_id;
	}

	public function getHash(){
		return $this->hash;
	}

	public function setHash($hash){
		$this->hash = $hash;
	}
}