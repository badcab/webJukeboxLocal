webJukeboxLocal
===============

A music voting webapp for use on a lan that might not have exteral internet connectivity


Setup
---------------------

This was program was written for and tested on a Raspberry Pi running Raspian. Setup should be as simple as running the pi_setup.sh script but the setup script has not been tested please report an issue if it does not work.

	`su -c './pi_setup.sh'`

in your MUSIC_DIRECTORY as defined in config.php Inside of that directory make any number of subdirectories (but at least one) and inside of these directories place mp3 files with properly populated id3 tags. These subdirectories are inteded to be music genreas but you can subdevide the music files up using any methodaligy you wish.

make sure you have run the sql file and setup the mysql database, then edit the config.php file to fit your specific needs. Then run the --hard-reset option to index your music files.

	`php player.php --hard-reset`

plug your Raspberry Pi into a wireless router and privide your guest with the ip address of the Raspberry Pi. The will then need to point there web browsers to that ip. This was designed for mobile browsers with javascript enabled but desktop computer will work to as long as they are all connected to the same lan

start the music playback

	`php player.php --play`

