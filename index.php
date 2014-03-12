<?php 
	require('config.php');
	$_SESSION['heat'] = 0;	
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

		<div class="row"><div class="col-xs-12"><div class="space"></div></div></div>
	<?php for($i=0;$i<HEAT_SIZE;$i++): ?>
		<div class="row">
			<div class="col-xs-12 classy-btn song-btn" song-id="" id="s<?= $i+1 ?>">
				<span class="song-name"></span>
				<span class="badge badge-inverse pull-right song-votes"></span>
			</div>
		</div>

		<div class="row"><div class="col-xs-12"><div class="space"></div></div></div>
	<?php endfor; ?>

	</div>

	<div class="modal"><h1></h1></div>

	<div class="navbar navbar-fixed-bottom classy-btn" id="skip">
		<span class="song-name">Skip</span>
	</div>
</body>
</html>
