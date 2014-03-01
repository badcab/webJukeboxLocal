<?php
require('config.php');

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Web JukeBox</title>
	<link rel="stylesheet" href="<?= $_bootstrap_css ?>">
	<link rel="stylesheet" href="style.css">
	<script src="<?= $_jquery_js ?>"></script>
	<script src="<?= $_bootstrap_js ?>"></script>
	<script src="script.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 btn btn-primary btn-lg btn-block">
				<span class="pull-left">some text</span>
				<span class="badge badge-inverse pull-right">10</span>
			</div>
		</div>

		<div class="row"><div class="col-xs-12"></div></div>

		<div class="row">
			<div class="col-xs-12 btn btn-primary btn-lg btn-block">
				<span class="pull-left">some text</span>
				<span class="badge badge-inverse pull-right">10</span>
			</div>
		</div>

		<div class="row"><div class="col-xs-12"></div></div>

		<div class="row">
			<div class="col-xs-12 btn btn-primary btn-lg btn-block">
				<span class="pull-left">some text</span>
				<span class="badge badge-inverse pull-right">10</span>
			</div>
		</div>
		</div>
	</div>

	<div class="modal"><h1></h1></div>

	<div class="navbar navbar-fixed-bottom btn btn-primary btn-lg btn-block" id="skip">
		Skip
	</div>
</body>
</html>
