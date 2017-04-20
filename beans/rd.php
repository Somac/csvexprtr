<?php
class rd {
	private $date;
	private $start;
	private $end;
	private $hours;
	private $oth;
	private $eh;
	private $nw;
	private $ew;
	private $otw;

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

	public function getHours(){
		return $this->hours;
	}

	public function setHours($hours){
		$this->hours = $hours;
	}

	public function getOth(){
		return $this->oth;
	}

	public function setOth($oth){
		$this->oth = $oth;
	}

	public function getEh(){
		return $this->eh;
	}

	public function setEh($eh){
		$this->eh = $eh;
	}

	public function getNw(){
		return $this->nw;
	}

	public function setNw($nw){
		$this->nw = $nw;
	}

	public function getEw(){
		return $this->ew;
	}

	public function setEw($ew){
		$this->ew = $ew;
	}

	public function getOtw(){
		return $this->otw;
	}

	public function setOtw($otw){
		$this->otw = $otw;
	}
}