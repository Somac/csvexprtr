<?php 
header("Content-Type: text/html; charset=iso-8859-1");
session_start();
require_once "../db/PDOc.php";
require_once "../ajax/user.php";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CSV wage calculator</title>
<meta name="description" content="CSV wage calculator">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/styles.css?v=1.0">
<link rel="shortcut icon" href="images/favicon.ico">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jq-2.2.4/dt-1.10.15/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
<a id="cookieconsent:learn_more" aria-label="learn more about cookies" role=button tabindex="0" class="cc-link" href="https://cookie-policy.org/"
	target="_blank">cookie policy</a>
<script>var cookieconsent_ts = 1492427471; var cookieconsent_id = 'fddd7d25-405b-42cb-bab5-4e9aaa25e591'; var learnmore2 = document.getElementById("cookieconsent:learn_more");learnmore2.setAttribute('style', 'display:none');</script>
<script src="//cookiescript.cdn2.info/libs/cookieconsent.4.min.js"></script>
<script src="js/cookienotif.js"></script>
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<noscript>
	<a href="https://cookiescript.info/">Cookie consent script</a>
</noscript>
<body>
	<div id="wrap">
		<!-- Static navbar from bootstrap -->
		<nav class="navbar navbar-custom navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
					</button>
					<p class="navbar-brand">CSV XPRTR</p>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li id='home'><a href="./">Home</a></li>
						<li id='csv'><a href="csv">Your CSV-uploads</a>
					</ul>
				</div>
			</div>
		</nav>