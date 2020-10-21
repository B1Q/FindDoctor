<?php
date_default_timezone_set("Africa/Cairo");

require_once 'constants.php';

if (defined("DEBUG") && DEBUG) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}

require_once DIVINEPATH . 'app/config.php';
require_once DIVINEPATH . 'app/routes.php';
require_once PATHTOSMARTY;
require_once 'database.php';
require_once 'router.php';
require_once 'TemplateMaster.php';
require_once 'FormValidation.php';
require_once 'session.php';
require_once 'utility.php';


$session = new Session($config['session']);
$database = new GoodDB($config['db']);
$currentLang =
	isset($_COOKIE['currentLanguage']) && CookieLanguageExists() ? $_COOKIE['currentLanguage'] : $config['site']['defaultLang'];

Session::$Instance->InitializeSession();
Session::$Instance->Expired();
TemplateMaster::InitializeConfig($config);
FormValidation::InitializeRules();

require_once "lang/$currentLang.php";
Router::Init($routes, $config['site']);


function CookieLanguageExists()
{
	global $config;
	$langKey = $_COOKIE['currentLanguage'];
	foreach ($config['site']['languages'] as $lang)
		if ($lang['key'] == $langKey)
			return TRUE;
	return FALSE;
}
//print_r($database->insert(USERTABLE,
//                          ['email' => 'test', 'password' => 'test', 'firstname' => 'test', 'lastname' => 'test']));
//
//var_dump($database->delete(USERTABLE, 7));