<?php
class raw_data {
	private $data_id;
	private $person_name;
	private $person_id;
	private $date;
	private $start;
	private $end;
	private $file_id;

	public function getData_id(){
		return $this->data_id;
	}

	public function setData_id($data_id){
		$this->data_id = $data_id;
	}

	public function getPerson_name(){
		return $this->person_name;
	}

	public function setPerson_name($person_name){
		$this->person_name = $person_name;
	}

	public function getPerson_id(){
		return $this->person_id;
	}

	public function setPerson_id($person_id){
		$this->person_id = $person_id;
	}

	public function getDate(){
		return $this->date;
	}

	public function setDate($date){
		$this->date = $date;
	}

	public function getStart(){
		return $this->start;
	}

	public function setStart($start){
		$this->start = $start;
	}

	public function getEnd(){
		return $this->end;
	}

	public function setEnd($end){
		$this->end = $end;
	}

	public function getFile_id(){
		return $this->file_id;
	}

	public function setFile_id($file_id){
		$this->file_id = $file_id;
	}
}