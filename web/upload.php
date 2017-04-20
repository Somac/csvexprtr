<?php
header('Content-Type: text/html; charset=iso-8859-1');
require_once "../db/PDOc.php";
require_once "../ajax/user.php";
require_once "../beans/raw.php";
function decimalHours($time, $time2) {
    return round(abs($time - $time2)/60)/60;
}
if(isset($_POST["submit"])) {
	if(isset($_POST["settings"]) && $_POST["settings"] == 1) {
		//If custom values have been set
		$hourlyWage = $_POST["hourlywage"];
		$eveningWorkCompensation = $_POST["eveningcompensation"];
		$overTimeFirst = ($_POST["overtimefirst"] / 100);
		$overTimeSecond = ($_POST["overtimesecond"] / 100);
		$overTimeThird = ($_POST["overtimethird"] / 100);
	} else {
		//Default values
		$hourlyWage = 3.75;
		$eveningWorkCompensation = 1.15;
		$overTimeFirst = 0.25;
		$overTimeSecond = 0.5;
		$overTimeThird = 1;
	}
	$dbc = new PDOc();
	//Hours for normal day
	$normalday = 8;
	//Overtime checks
	$overtimefirstc = 2;
	$overtimesecondc = 2;
	//Evening compensation checks
	$eveningstart = strtotime("18:00");
	$eveningend = strtotime("06:00");
	$endofdaystr = strtotime("24:00");
	$startofdaystr = strtotime("00:00");
	$file = $_FILES['csvfile']['tmp_name'];
	$fn = $_FILES['csvfile']['name'];
	//Commenting out the FileName checker
//	$file_bool = $dbc->checkFileName($fn, $user_id);
//	if(!$file_bool) {
//		header("location: ../?error=fileSubmitted");
//	} else {
	$fid = $dbc->addFile($fn, $user_id, $hourlyWage, $eveningWorkCompensation, $overTimeFirst, $overTimeSecond, $overTimeThird);
	$handle = fopen($file, "r");
	if ($handle) {
		$i = 0;
		$personIdArray = array();
		$persons = array();
		$endData = array();
		while(($fop = fgetcsv($handle, 1000, ",")) !== false) {
			$pn = $fop[0];
			$pid = $fop[1];
			$date = $fop[2];
			$start = $fop[3];
			$end = $fop[4];
			$dateformat = date("Y-m-d",strtotime($date));
			if(!$pn == "Person Name" || is_numeric($pid) || preg_match('/^\d{2}:\d{2}$/', $start) || preg_match('/^\d{2}:\d{2}$/', $end)) {
				if(!in_array($pid, $personIdArray)) {
					$personIdArray[] = $pid;
					$persons[] = array($pid,$pn);
				}
				$dbc->addRawData($pn, $pid, $dateformat, $start, $end, $fid);
				$i++;
			}
		}
		foreach($persons as $pid) {
			$datesworked = array();
			$hoursarray = array();
			$wage = 0;
			$hours = 0;
			$overtimehourstotal = 0;
			$eveninghourstotal = 0;
			$person_name = $pid[1];
			$person_id = $pid[0];
			$userData = $dbc->getRawDataPerson($fid, $user_id, $person_id);
			foreach($userData as $ud) {
				//Nulling variables
				$eveningwage = 0;
				$normalwage = 0;
				$overtimewage = 0;
				$eveninghours = 0;
				$overtimehours = 0;
				$hoursworked = 0;
				//Getting data
				$uddate = $ud->getDate();
				$udstart = $ud->getStart();
				$udend = $ud->getEnd();
				$rdata_id = $ud->getData_id();
				$udstartstr = strtotime($udstart);
				$udendstr = strtotime($udend);
				//Worked after midnight
				$midnight = false;
				//Checking if employee has already done work the same day
				if(in_array($uddate, $datesworked)) {
					$k = array_search($uddate, $datesworked);
					//Hours that have been done already today
					$workedhours = $hoursarray[$k];
					//Checking if ending time is lower than starting time(work goes to next day)
					if($udendstr < $udstartstr) {
						$hoursworked = decimalHours($endofdaystr, $udstartstr);
						$hoursworked += decimalHours($udendstr, $startofdaystr);
						$midnight = true;
					} else {
						$hoursworked = decimalHours($udendstr, $udstartstr);
					}
					$hoursworked2 = $hoursworked + $workedhours;
					//Adding overtimehours if the dude/chick has worked overtime.
					if($hoursworked2 > $normalday) {
						$overtimehours = $hoursworked2 - $normalday;
						if($overtimehours > $overtimefirstc) {
							$overtimewage = $overtimefirstc * $overTimeFirst * $hourlyWage;
							$secondovertime = $overtimehours - $overtimefirstc;
							if($secondovertime > $overtimesecondc) {
								$overtimewage += $secondovertime * $overTimeSecond * $hourlyWage;
								$thirdovertime = $secondovertime - $overtimesecondc;
								$overtimewage += $thirdovertime * $overTimeThird * $hourlyWage;
							} else {
								$overtimewage += $secondovertime * $overTimeSecond * $hourlyWage;
							}
						} else {
							$overtimewage = $overtimefirstc * $overTimeFirst * $hourlyWage;
						}
					}
				} else {
					//Checking if ending time is lower than starting time
					if($udendstr < $udstartstr) {
						$hoursworked = decimalHours($endofdaystr, $udstartstr);
						$hoursworked += decimalHours($udendstr, $startofdaystr);
						$midnight = true;
					} else {
						$hoursworked = decimalHours($udendstr, $udstartstr);
					}
					//Adding overtimewage
					if($hoursworked > $normalday) {
						$overtimehours = $hoursworked - $normalday;
						if($overtimehours > $overtimefirstc) {
							$overtimewage = $overtimefirstc * $overTimeFirst * $hourlyWage;
							$secondovertime = $overtimehours - $overtimefirstc;
							if($secondovertime > $overtimesecondc) {
								$overtimewage += $secondovertime * $overTimeSecond * $hourlyWage;
								$thirdovertime = $secondovertime - $overtimesecondc;
								$overtimewage += $thirdovertime * $overTimeThird * $hourlyWage;
							} else {
								$overtimewage += $secondovertime * $overTimeSecond * $hourlyWage;
							}
						} else {
							$overtimewage = $overtimefirstc * $overTimeFirst * $hourlyWage;
						}
					}
				}
				$normalwage = $hourlyWage * $hoursworked;
				//Adding eveningwage (NOTE: I think this could've been done better, since at first I thought it would be a piece of cake,
				//but after noticing all the different possibilities this if/elseif/else-mess swelled abysmally. Maybe a simple for-loop would've
				//worked better)
				if($udendstr > $eveningstart) {
					if($midnight) {
						$eveninghours = decimalHours($udendstr, $eveningstart);
						$eveninghours += decimalHours($eveningend, $startofdaystr);
						$eveninghours += decimalHours($endofdaystr, $udstartstr);
					} else {
						if($udstartstr < $eveningstart) {
							$eveninghours = decimalHours($udendstr, $eveningstart);
						} else {
							$eveninghours = decimalHours($udendstr, $udstartstr);
						}
					}
				} elseif($udendstr < $eveningend) {
					if($midnight == true) {
						if($udstartstr > $eveningstart) {
							$eveninghours = decimalHours($udendstr, $startofdaystr);
							$eveninghours += decimalHours($endofdaystr, $udstartstr);
						} else {
							$eveninghours = decimalHours($udendstr, $startofdaystr);
							$eveninghours += decimalHours($endofdaystr, $eveningstart);
						}
					} else {
						if($udstartstr > $eveningend) {
							$eveninghours = decimalHours($udendstr, $eveningstart);
						} else {
							$eveninghours = decimalHours($udendstr, $udstartstr);
						}
					}
				} elseif($udstartstr > $eveningstart) {
					$eveninghours = decimalHours($endofdaystr, $udstartstr);
					$eveninghours += decimalHours($eveningend, $startofdaystr);
				} elseif($udstartstr < $eveningend) {
					$eveninghours = decimalHours($eveningend, $udstartstr);
				}
				$eveningwage = $eveninghours * $eveningWorkCompensation;
				$datesworked[] = $uddate;
				$hoursarray[] = $hoursworked;
				$wage += $normalwage + $overtimewage + $eveningwage;
				//adding additional data
				$dbc->addAdditionalData($rdata_id, $eveninghours, $overtimehours, $hoursworked, $normalwage, $overtimewage, $eveningwage);
				$eveninghourstotal += $eveninghours;
				$overtimehourstotal += $overtimehours;
				$hours += $hoursworked;
			}
			$dbc->addEndData($person_id, $person_name, $wage, $fid, $hours, $overtimehourstotal, $eveninghourstotal);
			$wtime = $dbc->getFirstAndLastDate($fid);
			$dbc->updateFileWtime($fid, $wtime);
		}
		$dbc = null;
		header("location: ../".$fid);
	} else {
		header("location: ../?error=errorLoadingFile");
	}
	$dbc = null;
} else {
	header("location: ../?error=noSubmit");
}
?>