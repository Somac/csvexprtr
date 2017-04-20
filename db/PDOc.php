<?php
require_once "../beans/calculated.php";
require_once "../beans/files.php";
require_once "../beans/raw.php";
require_once "../beans/users.php";
require_once "../beans/additional.php";
require_once "../beans/rd.php";
header ( 'Content-Type: text/html; charset=iso-8859-1' );
class PDOc {
	private $db;	
	//PDO construct
	function __construct($dsn = "mysql:host=localhost;dbname=solinordb", $username = "root", $password = "") {
		$this->db = new PDO ( $dsn, $username, $password );
		$this->db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
		$this->db->setAttribute ( PDO::ATTR_EMULATE_PREPARES, false );
	}

	function insertUser($hash) {
		$sql = "INSERT INTO users (hash) 
				VALUES(:hash)";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue (":hash",$hash);
		$stmt->execute();
		$result = $this->db->lastInsertId();
		return $result;
	}
	
	function getUser($hash) {
		$sql = "SELECT user_id FROM users
				WHERE hash = :hash";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":hash",$hash);
		$stmt->execute();
		if($stmt == NULL){
			$result = 0;
		} else {
			$result = $stmt->fetchObject()->user_id;
		}
		return $result;
	}
	
	function updateSeenTime($seen_id) {
		$sql = "UPDATE seen_history 
				SET seen_time_end = NOW() 
				WHERE seen_id = :sid";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":sid",$seen_id);
		$stmt->execute();
		return null;
	}
	
	function addSeenTime($user_id) {
		$sql = "INSERT INTO seen_history (seen_time_start, seen_time_end, user_id)
				VALUES(NOW(), NOW(), :uid)";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":uid", $user_id);
		$stmt->execute();
		$result = $this->db->lastInsertId();
		return $result;
	}
	
	function addFile($fn, $uid, $hw, $ec, $of, $ot, $oth) {
		$sql = "INSERT INTO files (file_name, user_id, hourly_wage, evening_compensation, overtime_first, overtime_second, overtime_third)
				VALUES(:fn, :uid, :hw, :ec, :of, :ot, :oth)";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":fn", $fn);
		$stmt->bindValue(":uid", $uid);
		$stmt->bindValue(":hw", $hw);
		$stmt->bindValue(":ec", $ec);
		$stmt->bindValue(":of", $of);
		$stmt->bindValue(":ot", $ot);
		$stmt->bindValue(":oth", $oth);
		$stmt->execute();
		$result = $this->db->lastInsertId();
		return $result;
	}
	
	function updateFileWtime($fid, $wtime) {
		$sql = "UPDATE files SET wage_time = :wtime WHERE file_id = :fid";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":fid", $fid);
		$stmt->bindValue(":wtime", $wtime);
		$stmt->execute();
	}
	
	function checkFileName($fn, $uid) {
		$sql = "SELECT count(file_id) FROM files WHERE user_id = :uid AND file_name = :fn";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":fn", $fn);
		$stmt->bindValue(":uid", $uid);
		$stmt->execute();
		if($stmt == NULL){
			$result = false;
		} else {
			$result = true;
		}
		return $result;
	}

	function addRawData($pn, $pid, $date, $start, $end, $fid) {
		$sql = "INSERT INTO raw_data (person_name, person_id, date, start, end, file_id)
				VALUES(:pn, :pid, :date, :start, :end, :fid)";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":pn", $pn);
		$stmt->bindValue(":pid", $pid);
		$stmt->bindValue(":date", $date);
		$stmt->bindValue(":start", $start);
		$stmt->bindValue(":end", $end);
		$stmt->bindValue(":fid", $fid);
		$stmt->execute();
		$result = $this->db->lastInsertId();
		return $result;
	}
	
	function getRawData($fid, $uid) {
		$sql = "SELECT person_name, person_id, date, start, end
				FROM raw_data rd
				JOIN files f ON f.file_id = rd.file_id
				WHERE rd.file_id = :fid
				AND f.user_id = :uid";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":fid", $fid);
		$stmt->bindValue(":uid", $uid);
		$stmt->execute();
		$result = array ();
		while ( $row = $stmt->fetchObject()) {
			$raw_data = new raw_data();
			
			$raw_data->setPerson_id($row->person_id);
			$raw_data->setPerson_name($row->person_name);
			$raw_data->setDate($row->date);
			$raw_data->setStart($row->start);
			$raw_data->setEnd($row->end);
			
			$result[] = $raw_data;
		}
		return $result;
	}
	
	function getRawDataPerson($fid, $uid, $pid) {
		$sql = "SELECT rdata_id, person_name, person_id, date, start, end
				FROM raw_data rd
				JOIN files f ON f.file_id = rd.file_id
				WHERE rd.file_id = :fid
				AND f.user_id = :uid
				AND rd.person_id = :pid";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":fid", $fid);
		$stmt->bindValue(":uid", $uid);
		$stmt->bindValue(":pid", $pid);
		$stmt->execute();
		$result = array ();
		while ( $row = $stmt->fetchObject()) {
			$raw_data = new raw_data();
			
			$raw_data->setData_id($row->rdata_id);
			$raw_data->setPerson_id($row->person_id);
			$raw_data->setPerson_name($row->person_name);
			$raw_data->setDate($row->date);
			$raw_data->setStart($row->start);
			$raw_data->setEnd($row->end);
			
			$result[] = $raw_data;
		}
		return $result;
	}
	
	function addAdditionalData($rdata_id, $eh, $oth, $h, $nw, $ow, $ew) {
		$sql = "INSERT INTO additional_info(hours, overtimehours, evening_hours, normal_wage, evening_wage, overtime_wage, rdata_id)
				VALUES(:h, :oth, :eh, :nw, :ew, :ow, :rdata_id)";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":h", $h);
		$stmt->bindValue(":oth", $oth);
		$stmt->bindValue(":eh", $eh);
		$stmt->bindValue(":nw", $nw);
		$stmt->bindValue(":ow", $ow);
		$stmt->bindValue(":ew", $ew);
		$stmt->bindValue(":rdata_id", $rdata_id);
		$stmt->execute();
		$result = $this->db->lastInsertId();
		return $result;
	}
	
	function getFirstAndLastDate($file_id) {
		$sql = "SELECT MIN(date) AS mini, MAX(date) AS maxi FROM raw_data WHERE  file_id = :fid";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":fid", $file_id);
		$stmt->execute();
		while ( $row = $stmt->fetchObject()) {
			$min = date("m / Y",strtotime($row->mini));
			$max = date("m / Y",strtotime($row->maxi));
			if($min == $max) {
				$result = $min;	
			} else {
				$result = $min . " - " . $max;
			}
		}
		return $result;
	}
	
	function getUserFiles($uid) {
		$sql = "SELECT files.file_id as fid, file_name, wage_time, upload_time, count(cd.person_id) as pcount
				FROM files
				LEFT JOIN calculated_data cd ON cd.file_id = files.file_id
				WHERE user_id = :uid GROUP BY files.file_id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":uid", $uid);
		$stmt->execute();
		$result = array();
		while ( $row = $stmt->fetchObject()) {
			$file = new files();
			
			$file->setFile_id($row->fid);
			$file->setEmployees($row->pcount);
			$file->setFile_name($row->file_name);
			$file->setWage_time($row->wage_time);
			$file->setUpload_time($row->upload_time);
			
			$result[] = $file;
		}
		return $result;
	}
	
	function getFileTitle($fid, $uid) {
		$sql = "SELECT file_name, wage_time FROM files
				WHERE user_id = :uid AND file_id = :fid";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":uid", $uid);
		$stmt->bindValue(":fid", $fid);
		$stmt->execute();
		while ( $row = $stmt->fetchObject()) {
			$file = new files();
			
			$file->setFile_name($row->file_name);
			$file->setWage_time($row->wage_time);
			
			$result = $file;
		}
		return $result;
	}
	
	function getInfoTable($fid, $uid) {
		$sql = "SELECT file_name, wage_time, hourly_wage, evening_compensation, overtime_first, overtime_second, overtime_third, upload_time
				FROM files
				WHERE user_id = :uid AND file_id = :fid";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":uid", $uid);
		$stmt->bindValue(":fid", $fid);
		$stmt->execute();
		while ( $row = $stmt->fetchObject()) {
			$file = new files();
			
			$file->setFile_name($row->file_name);
			$file->setWage_time($row->wage_time);
			$file->setHourly($row->hourly_wage);
			$file->setEvening($row->evening_compensation);
			$file->setOtf($row->overtime_first);
			$file->setOts($row->overtime_second);
			$file->setOtt($row->overtime_third);
			$file->setUpload_time($row->upload_time);
			
			$result = $file;
		}
		return $result;
	}
	
	function getCalculatedStats($fid, $uid) {
		$sql = "SELECT sum(cd.wage) as sumwage, sum(cd.hours) as sumhours, sum(cd.overtime_hours) as othours, sum(cd.evening_hours) as ehours
				FROM calculated_data cd
				JOIN files f ON f.file_id = cd.file_id 
				WHERE cd.file_id = :fid AND f.user_id = :uid";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":uid", $uid);
		$stmt->bindValue(":fid", $fid);
		$stmt->execute();
		while ( $row = $stmt->fetchObject()) {
			$calculated = new calculated();
			
			$calculated->setWage($row->sumwage);
			$calculated->setHours($row->sumhours);
			$calculated->setEvening_hours($row->ehours);
			$calculated->setOvertime_hours($row->othours);
			
			$result = $calculated;
		}
		return $result;
	}
	
	function getAdditionalStats($fid, $uid) {
		$sql = "SELECT sum(ad.evening_wage) as ewage, sum(ad.overtime_wage) as otwage
				FROM additional_info ad
				JOIN raw_data rd ON rd.rdata_id = ad.rdata_id
				JOIN files f ON f.file_id = rd.file_id
				WHERE rd.file_id = :fid AND f.user_id = :uid";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":uid", $uid);
		$stmt->bindValue(":fid", $fid);
		$stmt->execute();
		$result;
		while ( $row = $stmt->fetchObject()) {
			$add = new additional();
			
			$add->setEwage($row->ewage);
			$add->setOtwage($row->otwage);
			
			$result = $add;
		}
		return $result;
	}
	
	function getPersonsFromFile($fid, $uid) {
		$sql = "SELECT cd.person_id as pid, cd.person_name as pname, cd.hours as h, cd.wage as w, cd.overtime_hours as oth, cd.evening_hours as eh
				FROM calculated_data cd
				JOIN files f ON f.file_id = cd.file_id
				WHERE cd.file_id = :fid AND f.user_id = :uid ORDER BY pid";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":uid", $uid);
		$stmt->bindValue(":fid", $fid);
		$stmt->execute();
		$result = array();
		while ( $row = $stmt->fetchObject()) {
			$cal = new calculated();
			
			$cal->setPerson_id($row->pid);
			$cal->setPerson_name($row->pname);
			$cal->setHours($row->h);
			$cal->setWage($row->w);
			$cal->setOvertime_hours($row->oth);
			$cal->setEvening_hours($row->eh);
			
			$result[] = $cal;
		}
		return $result;
	}
	
	function getPersonName($pid, $fid) {
		$sql = "SELECT person_name FROM calculated_data
				WHERE person_id = :pid AND file_id = :fid";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":pid", $pid);
		$stmt->bindValue(":fid", $fid);
		$stmt->execute();
		$result = $stmt->fetchObject()->person_name;
		return $result;
	}
	
	function getRawData2($fid, $pid) {
		$sql = "SELECT date, start, end, ad.hours as h, ad.overtimehours as oth, ad.evening_hours as eh, ad.normal_wage as nw, ad.evening_wage as ew, ad.overtime_wage as otw
				FROM raw_data rd
				JOIN additional_info ad ON ad.rdata_id = rd.rdata_id
				WHERE rd.person_id = :pid AND rd.file_id = :fid";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":pid", $pid);
		$stmt->bindValue(":fid", $fid);
		$stmt->execute();
		$result = array();
		while ($row = $stmt->fetchObject()) {
			$rd = new rd();
			
			$rd->setDate($row->date);
			$rd->setStart($row->start);
			$rd->setEnd($row->end);
			$rd->setHours($row->h);
			$rd->setOth($row->oth);
			$rd->setEh($row->eh);
			$rd->setNw($row->nw);
			$rd->setEw($row->ew);
			$rd->setOtw($row->otw);
			
			$result[] = $rd;
		}
		return $result;
	}

	function addEndData($pid, $pn, $wage, $fid, $hours, $othours, $ehours) {
		$sql = "INSERT INTO calculated_data (person_id, person_name, wage, file_id, hours, overtime_hours, evening_hours)
				VALUES(:pid, :pn, :wage, :fid, :h, :oth, :eh)";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":pn", $pn);
		$stmt->bindValue(":pid", $pid);
		$stmt->bindValue(":wage", $wage);
		$stmt->bindValue(":fid", $fid);
		$stmt->bindValue(":h", $hours);
		$stmt->bindValue(":oth", $othours);
		$stmt->bindValue(":eh", $ehours);
		$stmt->execute();
		$result = $this->db->lastInsertId();
		return $result;
	}
}