<?php
$user = false;
if(isset($_COOKIE["hash"]) && isset($_COOKIE["salt"])) {
	$dbc = new PDOc();
	$hash = $_COOKIE["hash"];
	$salt = $_COOKIE["salt"];
	$cookiehash = hash('sha512',$hash.$salt);
	$user_id = $dbc->getUser($cookiehash);
	if(count($user_id) != 0) {
		$user = true;
	} else {
		$user = false;
	}
	$dbc = null;
}
if($user == false) {
	$salt = uniqid(mt_rand(), true);
	$hash = hash('sha512',$_SERVER['REMOTE_ADDR'].time());
	$hash2 = hash('sha512',$hash.$salt);
	$dbc = new PDOc();
	$user_id = $dbc->insertUser($hash2);
	$dbc = null;
	setcookie("hash", $hash, time()+31556926, "/");
	setcookie("salt", $salt, time()+31556926, "/");
	$user = true;
}
if(isset($_SESSION["seen_id"])) {
	$dbc = new PDOc();
	$seen_id = $_SESSION["seen_id"];
	$dbc->updateSeenTime($seen_id);
	$dbc = null;
} else {
	$dbc = new PDOc();
	$seen_id = $dbc->addSeenTime($user_id);
	$_SESSION["seen_id"] = $seen_id;
	$dbc = null;
}