<?php
function csvFunction($user_id) {
	$toprint = "";
	$dbc = new PDOc();
	$files = $dbc->getUserFiles($user_id);
	if(count($files) == 0) {
		$toprint = "<tr><td>You haven't uploaded anything yet!</td></tr>";
	} else {
		foreach($files as $f) {
			$upload_time = date("j.n.Y H:i:s", strtotime($f->getUpload_time()));
			$toprint .= "<tr>";
			$toprint .= "<td>".$f->getFile_id()."</td>";
			$toprint .= "<td>".$f->getFile_name()."</td>";
			$toprint .= "<td>".$f->getWage_time()."</td>";
			$toprint .= "<td>".$upload_time."</td>";
			$toprint .= "<td>".$f->getEmployees()."</td>";
			$toprint .= "<td><a href='".$f->getFile_id()."'><span class='glyphicon glyphicon-link'></span></a></td>";
			$toprint .= "</tr>";
		}
	}
	$dbc = null;
	return $toprint;
}

function fileTitle($id, $user_id) {
	$toprint = "File: ";
	$dbc = new PDOc();
	$fileTitle = $dbc->getFileTitle($id, $user_id);
	$toprint .= $fileTitle->getFile_name() . " (" .$fileTitle->getWage_time().")";
	$dbc = null;
	return $toprint;
}

function infoTable($id, $user_id) {
	$toprint = "";
	$dbc = new PDOc();
	$info = $dbc->getInfoTable($id, $user_id);
	$toprint .= "<tbody>";
	$toprint .= "<tr><th>File name</th><td>".$info->getFile_name()."</td></tr>";
	$toprint .= "<tr><th>Wage time</th><td>".$info->getWage_time()."</td></tr>";
	$toprint .= "<tr><th>Upload time</th><td>".$info->getUpload_time()."</td></tr>";
	$toprint .= "<tr><th>Hourly wage</th><td>$ ".$info->getHourly()."</td></tr>";
	$toprint .= "<tr><th>Evening compensation</th><td>$ ".$info->getEvening()."</td></tr>";
	$toprint .= "<tr><th>First 2 hours after 8 hours</th><td>". (100*$info->getOtf())." %</td></tr>";
	$toprint .= "<tr><th>Next 2 Hours</th><td>". (100*$info->getOts())." %</td></tr>";
	$toprint .= "<tr><th>After That</th><td>". (100*$info->getOtt())." %</td></tr>";
	$toprint .= "</tbody>";
	$dbc = null;
	return $toprint;
}

function statisticsTable($id, $user_id) {
	$toprint = "";
	$dbc = new PDOc();
	$stats1 = $dbc->getCalculatedStats($id, $user_id);
	$otper = round(100*$stats1->getOvertime_hours() / $stats1->getHours(),2);
	$eper = round(100*$stats1->getEvening_hours() / $stats1->getHours(),2);
	$stats2 = $dbc->getAdditionalStats($id, $user_id);
	$a = "data";
	$toprint .= "<tbody>";
	$toprint .= "<tr><th>Total wage</th><td>$ ".$stats1->getWage()."</td></tr>";
	$toprint .= "<tr><th>Total hours</th><td>".$stats1->getHours()." hours</td></tr>";
	$toprint .= "<tr><th>Overtime hours</th><td>".$stats1->getOvertime_hours()." hours</td></tr>";
	$toprint .= "<tr><th>Evening hours</th><td>".$stats1->getEvening_hours()." hours</td></tr>";
	$toprint .= "<tr><th>Overtime percentage (hours)</th><td>".$otper." %</td></tr>";
	$toprint .= "<tr><th>Evening percentage (hours)</th><td>".$eper." %</td></tr>";
	$toprint .= "<tr><th>Overtime wage</th><td>$ ".$stats2->getOtwage()."</td></tr>";
	$toprint .= "<tr><th>Evening wage</th><td>$ ".$stats2->getEwage()."</td></tr>";
	$toprint .= "</tbody>";
	$dbc = null;
	return $toprint;
}

function personelTable($id, $user_id) {
	$toprint = "";
	$dbc = new PDOc();
	$persons = $dbc->getPersonsFromFile($id, $user_id);
	foreach($persons as $p) {
		$pid = $p->getPerson_id();
		$toprint .= "<tr>";
		$toprint .= "<td>$pid</td>";
		$toprint .= "<td>".$p->getPerson_name()."</td>";
		$toprint .= "<td>".$p->getWage()."</td>";
		$toprint .= "<td>".$p->getHours()."</td>";
		$toprint .= "<td>".$p->getOvertime_hours()."</td>";
		$toprint .= "<td>".$p->getEvening_hours()."</td>";
		$toprint .= "<td><a href='ajax/raw.php?pid=$pid&fid=$id' data-toggle='modal' data-target='#rawdata'><span class='glyphicon glyphicon-link'></span></a></td>";
		$toprint .= "</tr>";
	}
	$dbc = null;
	return $toprint;
}

function rawData($fid, $pid) {
	$toprint = "";
	$dbc = new PDOc();
	$rdata = $dbc->getRawData2($fid, $pid);
	foreach($rdata as $r) {
		$totalwage = $r->getNw() + $r->getEw() + $r->getOtw();
		$toprint .= "<tr>";
		$toprint .= "<td>".$r->getDate()."</td>";
		$toprint .= "<td>".date("H:i",strtotime($r->getStart()))."</td>";
		$toprint .= "<td>".date("H:i",strtotime($r->getEnd()))."</td>";
		$toprint .= "<td>".$r->getHours()."</td>";
		$toprint .= "<td>".$r->getOth()."</td>";
		$toprint .= "<td>".$r->getEh()."</td>";
		$toprint .= "<td>".$r->getNw()."</td>";
		$toprint .= "<td>".$r->getEw()."</td>";
		$toprint .= "<td>".$r->getOtw()."</td>";
		$toprint .= "<td>$totalwage</td>";
		$toprint .= "</tr>";
	}
	$dbc = null;
	return $toprint;
}