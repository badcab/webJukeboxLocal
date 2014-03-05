#!/usr/bin/php
<?php
require('config.php');

$o = $argv[1];

if($o == '--play'){
	$Player = new Player();
	$song_bank = $Player->loadSession();
	while(TRUE){
		$out = $Player->playNext($song_bank);
		$song_bank = $out['song_bank'];
		$play_cmd = "omxplayer " . escapeshellarg($out['path']);
		echo "playing {$out['path']} \n";
		//echo $play_cmd . "\n";
		exec($play_cmd);
	}
}

if($o == '--first'){
	$song = '/home/pi/12 Sea of Love.m4a';
	$play_cmd = "omxplayer " . escapeshellarg($song);
	echo "playing {$song}\n";
	exec($play_cmd);
}

if($o == '--bride-dad'){
	$song = '/home/pi/14 - Landslide (Remastered LP Version).mp3';
	$play_cmd = "omxplayer " . escapeshellarg($song);
	echo "playing {$song}\n";
	exec($play_cmd);
}

if($o == '--garter'){
	$song = '/home/pi/11 - My Life (Feat_ Tim Armstrong).mp3';
	$play_cmd = "omxplayer " . escapeshellarg($song);
	echo "playing {$song}\n";
	exec($play_cmd);
}

if($o == '--bouquet'){
	$song = '/home/pi/05 Girlfriend.m4a';
	$play_cmd = "omxplayer " . escapeshellarg($song);
	echo "playing {$song}\n";
	exec($play_cmd);
}

if($o == '--reset' || $o == '--hard-reset'){
	echo "resetting play count\n";
	$Song = new Song();
	$Song->resetPlayCount();
}

if($o == '--hard-reset'){
	echo "clearing queue\n";
	$Queue = new Queue();
	$Queue->clear();
}

if($o == '--setup' || $o == '--hard-reset'){
	$Song = new Song();
	$Player = new Player();
	echo 'indexing ' . MUSIC_DIRECTORY . "\n";
	$Song->scanMusicDir();
	$song_bank = $Player->loadSession();
	echo "\ngenerating queue\n";
	for($i=0;$i<7;$i++){
		echo '.';
		$song_bank = $Player->addHeat($song_bank);
	}
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

	echo"--first \tplay first bride groom dance\n";
	echo"--bride-dad \tplay bride father dance\n";
	echo"--garter \tplay garter toss song\n";
	echo"--bouquet \tplay bouquet toss song\n";

	echo"addr: \t\thttp://" . exec("ifconfig | grep 192.168 | cut -d':' -f2 | cut -d' ' -f1") . "/webJukeboxLocal\n";
}

echo "\n";
?>
