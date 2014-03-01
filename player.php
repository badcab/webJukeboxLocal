#!/usr/bin/php
<?php
require('config.php');

$o = $argv[1];

if($o == '--play'){
	$Player = new Player();
	$song_bank = $Player->loadSession();
	//add a fail safe in case not enogh stuff was returned
	while(TRUE){
		$out = $Player->playNext($song_bank);
		$song_bank = $out['song_bank'];
		$play_cmd = "omxplayer " . escapeshellarg($out['path']);
		echo "playing {$out['path']} \n";
		exec($play_cmd);
	}
}

if($o == '--first'){
	$song = '/path/to/file';
	$play_cmd = "omxplayer " . escapeshellarg($song);
	echo "playing $song\n";
	exec($play_cmd);
}

if($o == '--parent'){
	$song = '/path/to/file';
	$play_cmd = "omxplayer " . escapeshellarg($song);
	echo "playing $song\n";
	exec($play_cmd);
}

if($o == '--other'){
	$song = '/path/to/file';
	$play_cmd = "omxplayer " . escapeshellarg($song);
	echo "playing $song\n";
	exec($play_cmd);
}

if($o == '--setup'){
	$Song = new Song();
	$Player = new Player();
	$Song->scanMusicDir();
	$song_bank = $Player->loadSession();
	for($i=0;$i<7;$i++){
		$Player->playNext($song_bank);
	}
}

if($o == '--reset'){
	$Song = new Song();
	$Song->resetPlayCount();
}

if($o == '--hard-reset'){
	$cmd = "php " . $argv[0] . " --reset";
	exec($cmd);

	$Queue = new Queue();
	$Queue->clear();

	$cmd = "php " . $argv[0] . " --setup";
	exec($cmd);
}

if($o == '--show-songs'){
	$Song = new Song();
	$song_bank = $Song->getAll();
	echo print_r($song_bank,TRUE);
}

if($o == '--show-queue'){
	$Queue = new Queue();
	$song_bank = $Queue->getAll();
	echo print_r($song_bank,TRUE);
}

if($o == '--help'){
	echo"--play  \tstart normal play\n";
	echo"--setup \trun to re-index music dir\n";
	echo"--reset \tset play count to all songs to 0\n";
	echo"--hard-reset \tclear queue set play count to 0 and reindex\n";
	echo"--show-songs \tshow songs without play count\n";
	//add some lines here for particular songs
	echo"addr: \t\thttp://" . exec("ifconfig | grep 192.168 | cut -d':' -f2 | cut -d' ' -f1") . "/webJukeboxLocal\n";
}

echo "\n";

?>
