<?php
class calculated {
	private $c_id;
	private $person_id;
	private $person_name;
	private $wage;
	private $evening_hours;
	private $hours;
	private $overtime_hours;
	private $file_id;

	public function getC_id(){
		return $this->c_id;
	}

	public function setC_id($c_id){
		$this->c_id = $c_id;
	}

	public function getPerson_id(){
		return $this->person_id;
	}

	public function setPerson_id($person_id){
		$this->person_id = $person_id;
	}

	public function getPerson_name(){
		return $this->person_name;
	}

	public function setPerson_name($person_name){
		$this->person_name = $person_name;
	}

	public function getWage(){
		return $this->wage;
	}

	public function setWage($wage){
		$this->wage = $wage;
	}

	public function getFile_id(){
		return $this->file_id;
	}

	public function setFile_id($file_id){
		$this->file_id = $file_id;
	}
	
	public function getEvening_hours(){
		return $this->evening_hours;
	}

	public function setEvening_hours($evening_hours){
		$this->evening_hours = $evening_hours;
	}

	public function getHours(){
		return $this->hours;
	}

	public function setHours($hours){
		$this->hours = $hours;
	}

	public function getOvertime_hours(){
		return $this->overtime_hours;
	}

	public function setOvertime_hours($overtime_hours){
		$this->overtime_hours = $overtime_hours;
	}
}