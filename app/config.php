<?php
/**
 * Created by PhpStorm.
 * User: Mohamed Hosny
 * Date: 4/2/2019
 * Time: 12:35 AM
 */


$config = [];

$config['db'] = [
	'host'     => 'localhost',
	'user'     => 'root',
	'pass'     => '123123',
	'database' => 'finddoc' ];

$config['site'] = [
	'name'        => 'FindDoc',
	'title'       => 'FindDoc good',
	'siteurl'     => 'http://localhost/',
	'assetsPath'  => 'assets',
	'defaultLang' => 'en'
];

$config['site']['contact'] = [
	'mobile' => '+201096690560',
	'email'  => 'ksamkasdf@gmail.com' ];

$config['site']['socialmedia'] = [
	'facebook'  => 'https://facebook.com/B1QB0SS',
	'twitter'   => 'https://twitter.com/B1Q',
	'instagram' => 'https://instagram.com',
	'linkedin'  => 'https://linkedin.com' ];

$config['site']['languages'] = [
	[ 'name' => 'English', 'icon' => 'flag-icon flag-icon-us', 'key' => 'en', 'current' => TRUE ],
	[ 'name' => 'العربية', 'icon' => 'flag-icon flag-icon-eg', 'key' => 'ar', 'current' => FALSE ] ];

$config['session'] = [ 'expirationTime' => 60 ];

$config['site']['jsPath'] = $config['site']['assetsPath'] . "/js/";
$config['site']['cssPath'] = $config['site']['assetsPath'] . "/css/";
$config['site']['imgPath'] = $config['site']['assetsPath'] . "/img/";

$config['smtp'] = [ 'host' => '', 'user' => '', 'pass' => '' ];