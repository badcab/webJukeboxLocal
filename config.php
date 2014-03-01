<?php
if(!defined('DB_NAME')) {define('DB_NAME','web_jukebox');}
if(!defined('DB_USER')) {define('DB_USER','root');}
if(!defined('DB_PASSWORD')) {define('DB_PASSWORD','password');}
if(!defined('DB_HOST')) {define('DB_HOST','localhost');}

if(!defined('ZEND_INCLUDE_PATH')) {define('ZEND_INCLUDE_PATH','/var/www/ZendFramework-1.12.3/library');}

if(!defined('MP3_INCLUDE_PATH')) {define('MP3_INCLUDE_PATH','../getID3-1.9.7');}
if(!defined('MUSIC_DIRECTORY')) {define('MUSIC_DIRECTORY','/home/pi/music');}

if(!defined('HEAT_SIZE')) {define('HEAT_SIZE',3);}

set_include_path(get_include_path() . PATH_SEPARATOR . ZEND_INCLUDE_PATH . PATH_SEPARATOR . MP3_INCLUDE_PATH);
require_once('Zend/Loader.php');
Zend_Loader::loadClass('Zend_Db');
include 'model.php';
session_start();
date_default_timezone_set('Etc/UTC');

$_bootstrap_css = '../bootstrap-3.1.1-dist/css/bootstrap.min.css';
$_bootstrap_js = '../bootstrap-3.1.1-dist/js/bootstrap.min.js';
$_jquery_js = '../jquery-2.1.0.min.js';
?>
