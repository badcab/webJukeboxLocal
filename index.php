<?php
require('config.php');

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Web JukeBox</title>
	<link rel="stylesheet" href="<?= $_bootstrap_css ?>">
	<link rel="stylesheet" href="style.css"
	<script src="<?= $_bootstrap_js ?>"></script>
	<script src="<?= $_jquery_js ?>"></script>
	<script src="script.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-4">
				<button type="button" class="btn btn-primary btn-lg btn-block">Block level button</button>
				<button type="button" class="btn btn-default btn-lg btn-block">Block level button</button>
			</div>
			<div class="col-lg-4">col-md-4</div>
			<div class="col-lg-4">col-md-4</div>
		</div>
	</div>
</body>
</html>
