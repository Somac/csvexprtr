<?php
class files {
	private $file_id;
	private $file_name;
	private $user_id;
	private $wage_time;
	private $upload_time;
	private $employees;
	private $hourly;
	private $evening;
	private $otf;
	private $ots;
	private $ott;

	public function getFile_id(){
		return $this->file_id;
	}

	public function setFile_id($file_id){
		$this->file_id = $file_id;
	}

	public function getFile_name(){
		return $this->file_name;
	}

	public function setFile_name($file_name){
		$this->file_name = $file_name;
	}

	public function getUser_id(){
		return $this->user_id;
	}

	public function setUser_id($user_id){
		$this->user_id = $user_id;
	}

	public function getWage_time(){
		return $this->wage_time;
	}

	public function setWage_time($wage_time){
		$this->wage_time = $wage_time;
	}
	
	public function getEmployees(){
		return $this->employees;
	}

	public function setEmployees($employees){
		$this->employees = $employees;
	}
	
	public function getUpload_time(){
		return $this->upload_time;
	}

	public function setUpload_time($upload_time){
		$this->upload_time = $upload_time;
	}
	
	public function getHourly(){
		return $this->hourly;
	}

	public function setHourly($hourly){
		$this->hourly = $hourly;
	}

	public function getEvening(){
		return $this->evening;
	}

	public function setEvening($evening){
		$this->evening = $evening;
	}

	public function getOtf(){
		return $this->otf;
	}

	public function setOtf($otf){
		$this->otf = $otf;
	}

	public function getOts(){
		return $this->ots;
	}

	public function setOts($ots){
		$this->ots = $ots;
	}

	public function getOtt(){
		return $this->ott;
	}

	public function setOtt($ott){
		$this->ott = $ott;
	}
}