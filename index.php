<?php
require('config.php');

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Web JukeBox</title>
	<link rel="stylesheet" href="<?= $_bootstrap_css ?>">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="button.css">
	<script src="<?= $_jquery_js ?>"></script>
	<script src="<?= $_bootstrap_js ?>"></script>
	<script src="script.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 song-btn" song-id="" id="s1">
				<span class="pull-left song-name">s1</span>
				<span class="badge badge-inverse pull-right song-votes">s1</span>
			</div>
		</div>

		<div class="row"><div class="col-xs-12"></div></div>

		<div class="row">
			<div class="col-xs-12 song-btn" song-id="" id="s2">
				<span class="pull-left song-name">s2</span>
				<span class="badge badge-inverse pull-right song-votes">s2</span>
			</div>
		</div>

		<div class="row"><div class="col-xs-12"></div></div>

		<div class="row">
			<div class="col-xs-12 btn song-btn" song-id="" id="s3">
				<span class="pull-left song-name">s3</span>
				<span class="badge badge-inverse pull-right song-votes">s3</span>
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
