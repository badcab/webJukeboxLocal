webJukeboxLocal
===============

An offline implementation of my web jukebox program


Setup
====

On a freash install of Raspbian the pi_setup.sh file might work, I haven't tested it. If someone does let me know. 

You will have to install lighttpd mysql and other programs dictated in the setup file

jQuery, bootstap, Zend and getID3 will have to be downloaded with wget

Set up a MySQL user and run the db_setup.sql file to create your tables

Edit the config.php file with your information

place mp3 files in sub folders in your MUSIC_DIRECTORY as defined in config.php
-these sub folders will be the category that each song belongs to for example /home/pi/music/rock

once done adding your music files go to your root web directory likely /var/www

php player.php --hard-reset 

this command will index your music directory

load a web browser on another computer and point it at the web server if you are unsure run
php player.php --help

the bottem line should be the URL you need to go to

Start voting for music, when you are ready to start playing music type

php player.php --play


note
=====

I wrote this program for my own use so you will see options in the player.php file that apply only to me, feel free to change or remove these options.

