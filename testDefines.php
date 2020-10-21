<?php
/**
 * Created by PhpStorm.
 * User: Mohamed Hosny
 * Date: 4/4/2019
 * Time: 5:48 PM
 */

require_once 'vendor/autoload.php';
require_once "system/lang/en.php";

use Stichoza\GoogleTranslate\GoogleTranslate;

$langName = "ar";
$langFile = "if (!defined(\"language\")) {
	define(\"language\", \"" . $langName . "\");}" . "<br>";

$defines = get_defined_constants(TRUE)['user'];

$tr = new GoogleTranslate($langName); // Translates into English
$tr->setSource("en");
$tr->setOptions([ 'proxy' => 'socks4://83.220.241.153:48199' ]);

foreach ($defines as $key => $value) {

	if (is_string($value) && $key != "language") {
		$translatedValue = $tr->translate($value);
		$langFile .= "define(\"" . $key . "\", \"" . $translatedValue . "\");" . "<br>";
	}
}


echo $langFile;