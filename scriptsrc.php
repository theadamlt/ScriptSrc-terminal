#!/usr/bin/php
<?php
error_reporting( 0 );

require 'simple_html_dom.php';

$com_type = array( 'compressed', 'uncompressed' );

$libraries = array(
	'jquery' => '1',
	'jqueryui' => '2',
	'prototype' => '3',
	'motools' => '4',
	'dojo' => '5',
	'swfobject' => '6',
	'yui' => '7',
	'ext-core' => '8',
	'chrome-frame' => '9',
	'scriptaculous' => '10'
	);

$lib  = $argv[1];

if(isset($argv[2])) $type = $argv[2];
else $type = 'compressed';
$url = 'http://scriptsrc.net/popup.php?id='.$libraries[$lib];


$html = file_get_html($url)->plaintext;

preg_match_all('/[a-z]+:\/\/\S+/', $html, $matches);

if(empty($matches[0])) die('It seems like you dont have an internet connection');

if($type == 'compressed') $final = $matches[0][0];
else $final = $matches[0][1];

echo "<script type='text/javascript' src='$final'></script>";
?>

