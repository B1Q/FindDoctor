<?php
/**
 * Created by PhpStorm.
 * User: Mohamed Hosny
 * Date: 4/2/2019
 * Time: 8:57 PM
 * @property GoodDB database
 */

class Utility
{

	public static function RandomNumberGenerator($length = 8)
	{
		$number = [];
		for ($i = 0; $i < $length; ++$i)
			$number[] =
				mt_rand(1, 9); // 1 to stop weird behaviour... well it's not weird but yeah it stops the weird behavior
		return intval(implode("", $number));
	}

	// COPIED FROM https://stackoverflow.com/questions/4356289/php-random-string-generator
	public static function RandomStringGenerator($length = 8)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public static function get_ip()
	{
		return $_SERVER['REMOTE_ADDR'] ?? "";
	}

	public static function dateNow()
	{
		return date("Y-m-d H:i:s");
	}

	public static function Errorify($array)
	{
		$data = is_array($array) ? implode("<br>", $array) : $array;
		return "<div class='error_message alert alert-danger alert-dismissible'>" . $data . "</div>";
	}
}