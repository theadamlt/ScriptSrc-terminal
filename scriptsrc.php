#!/usr/bin/php
<?php
error_reporting( 0 );



require 'simple_html_dom.php';

function help() {
	echo "scriptsrc 1.0 by Adam Lilienfeldt <lilienfeldt.adam@gmail.com>
https://github.com/theadamlt/ScriptSrc-terminal

Finds the most current google-hosted JS librarys

Usage:
    scriptsrc [library] [compression-type]

Example:
    ./scriptsrc jquery compressed
    ./scriptsrc -i jquery


Options:
    -l, --list          List available libraries
    -i, --info			Displays info about the passed library
    -h, --help          Display this help text".PHP_EOL;
}

function list_() {

	echo 'jQuery
jQuery UI
Prototype
ḾooTools
Dojo
SWFObject
YIU
Ext Core
Chrome Frame
script.aculo.us'.PHP_EOL;
}

function info( $arr ) {
	if ( !empty( $arr[2] ) ) {
		$lib = strtolower($arr[2]);

		$libraries = array(
			'jquery' => '1',
			'jqueryui' => '2',
			'prototype' => '3',
			'mootools' => '4',
			'dojo' => '5',
			'swfobject' => '6',
			'yui' => '7',
			'ext-core' => '8',
			'chrome-frame' => '9',
			'scriptaculous' => '10'
		);

		$url = 'http://scriptsrc.net/popup.php?id='.$libraries[$lib];
		$html = file_get_html( $url )->plaintext;
		// echo $html;
		$split = explode( '&nbsp', $html );

		$name_arr = $split[0];
		$names = explode( ' ', $name_arr );
		$name = $names[29];

		$versions = explode( ';', $split[3] );
		$versions = $versions[1];
		$versions = explode( '         path:', $versions );
		$versions = $versions[0];

		$path = explode( ';', $split[6] );
		$path = $path[1];
		$path = explode( '         path(u):', $path );
		$path = $path[0];

		$path_u = explode( ';', $split[9] );
		$path_u = $path_u[1];
		$path_u = explode( '         site:', $path_u );
		$path_u = $path_u[0];

		$site = explode( ';', $split[12] );
		$site = $site[1];
		$site = explode( ' ', $site );
		$site = $site[0];

		$update = explode( ';', $split[15] );
		$update = $update[1];


		echo 'Library name: '.$name.PHP_EOL;
		echo 'Versions: '.$versions.PHP_EOL;
		echo 'URL: '.$path.PHP_EOL;
		echo 'URL (u): '.$path_u.PHP_EOL;
		echo 'Website: '.$site.PHP_EOL;
		echo 'Last updated: '.$update.PHP_EOL;
	}
	else {
		$libraries = array(
			'jquery' => '1',
			'jqueryui' => '2',
			'prototype' => '3',
			'mootools' => '4',
			'dojo' => '5',
			'swfobject' => '6',
			'yui' => '7',
			'ext-core' => '8',
			'chrome-frame' => '9',
			'scriptaculous' => '10'
		);
		foreach ( $libraries as $lib ) {
			$url = 'http://scriptsrc.net/popup.php?id='.$lib;
			$html = file_get_html( $url )->plaintext;
			// echo $html;
			$split = explode( '&nbsp', $html );

			$name_arr = $split[0];
			$names = explode( ' ', $name_arr );
			$name = $names[29];

			$versions = explode( ';', $split[3] );
			$versions = $versions[1];
			$versions = explode( '         path:', $versions );
			$versions = $versions[0];

			$path = explode( ';', $split[6] );
			$path = $path[1];
			$path = explode( '         path(u):', $path );
			$path = $path[0];

			$path_u = explode( ';', $split[9] );
			$path_u = $path_u[1];
			$path_u = explode( '         site:', $path_u );
			$path_u = $path_u[0];

			$site = explode( ';', $split[12] );
			$site = $site[1];
			$site = explode( ' ', $site );
			$site = $site[0];

			$update = explode( ';', $split[15] );
			$update = $update[1];


			echo 'Library name: '.$name.PHP_EOL;
			echo 'Versions: '.$versions.PHP_EOL;
			echo 'URL: '.$path.PHP_EOL;
			echo 'URL (u): '.$path_u.PHP_EOL;
			echo 'Website: '.$site.PHP_EOL;
			echo 'Last updated: '.$update.PHP_EOL.PHP_EOL.PHP_EOL;
		}
	}

}

function fetch() {

	$com_type = array( 'compressed', 'uncompressed' );

	$libraries = array(
		'jquery' => '1',
		'jqueryui' => '2',
		'prototype' => '3',
		'mootools' => '4',
		'dojo' => '5',
		'swfobject' => '6',
		'yui' => '7',
		'ext-core' => '8',
		'chrome-frame' => '9',
		'scriptaculous' => '10'
	);

	$lib  = strtolower($argv[1]);

	if ( isset( $argv[2] ) ) $type = strtolower($argv[2]);
	else $type = 'compressed';
	$url = 'http://scriptsrc.net/popup.php?id='.$libraries[$lib];


	$html = file_get_html( $url )->plaintext;

	preg_match_all( '/[a-z]+:\/\/\S+/', $html, $matches );

	if ( empty( $matches[0] ) ) die( 'It seems like you dont have an internet connection' );

	if ( $type == 'compressed' ) $final = $matches[0][0];
	else $final = $matches[0][1];

	echo "<script type='text/javascript' src='$final'></script>";


	if ( empty( $argv ) ) {

	}
}


if ( !isset( $argv[1] ) || strtolower($argv[1]) == '-h' || strtolower($argv[1]) == '--help' ) help();
elseif ( strtolower($argv[1]) == '-l' || strtolower($argv[1]) == '--list' ) list_();
elseif ( strtolower($argv[1]) == '-i' || strtolower($argv[1]) == '--info' ) info( $argv );
?>
