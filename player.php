<?php
//should not be accecable by web server only cli used to actually play the music
require('config.php');


$o = $argv[1];

if($o == '--play'){
	$Player = new Player();
	$song_bank = $Player->loadSession();
	//add a fail safe in case not enogh stuff was returned
	while(TRUE){
		$Player->playNext($song_bank);//will return path of next song to be played
		//will need a way to update $song_bank
	}
}

if($o == '--first'){
	//couple first dance
}

if($o == '--parent'){
	//parents dance or something
}

if($o == '--other'){
	//I think there was a third option
}

if($o == '--setup'){
	$Song = new Song();
	$Song->scanMusicDir();
	
	//add a few songs to the heat, queue 
}

if($o == '--help'){
	//print out pi ip address and what options I can run
}



echo "\n";

?>
