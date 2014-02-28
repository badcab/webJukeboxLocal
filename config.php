<?php
if(!defined('DB_NAME')) {define('DB_NAME','web_jukebox');}
if(!defined('DB_USER')) {define('DB_USER','root');}
if(!defined('DB_PASSWORD')) {define('DB_PASSWORD','password');}
if(!defined('DB_HOST')) {define('DB_HOST','localhost');}

if(!defined('ZEND_INCLUDE_PATH')) {define('ZEND_INCLUDE_PATH','..');}
//if(!defined('MP3_INCLUDE_PATH')) {define('MP3_INCLUDE_PATH','..');}//if this and the zend path were different I would have to put both in the include path but well they are the same
if(!defined('MUSIC_DIRECTORY')) {define('MUSIC_DIRECTORY','/home/pi/music');}

set_include_path(get_include_path() . PATH_SEPARATOR . ZEND_INCLUDE_PATH);
require_once('Zend/Loader.php');
Zend_Loader::loadClass('Zend_Db');
include 'model.php';
session_start();
date_default_timezone_set('Etc/UTC');

$_bootstrap_css = '//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css';
$_bootstrap_js = '//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js';
$_jquery_js = '//ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.0.min.js';

?>
