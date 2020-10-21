<?php
/**
 * Created by PhpStorm.
 * User: Mohamed Hosny
 * Date: 4/2/2019
 * Time: 8:52 AM
 */

class FormValidation
{
	private static $validRules = [];

	private static $validationQueue = [];

	private static $ruleErrors = [
		'required'           => 'The field %s is required',
		'matches'            => 'The value of %s doesn\'t match %s',
		'minlength'          => 'The value of %s has to be more than %d in length',
		'maxlength'          => 'The value of %s has to be less than %d in length',
		'email'              => 'The value of %s has an invalid email format!',
		'numeric'            => 'The value of %s has to be numeric(0-9)',
		'alnum'              => 'The value of %s has to be alphanumeric(A-z-0-9)',
		'alnum_spaces'       => 'The value of %s has to be alphanumeric(A-z-0-9) spaces allowed',
		'alnum_spacesArabic' => 'The value of %s has to be alphanumeric(A-z-0-9) spaces allowed',
		'alpha'              => 'The value of %s has to be alpha(A-z)' ];

	public static function InitializeRules()
	{
		// this is kinda ugly but it works
		self::$validRules = [
			'required'           => function ($frm, $key, $ruleval) {
				return array_key_exists($key, $frm) && ($frm[$key] === "0" || $frm[$key]);
			},
			'matches'            => function ($frm, $key, $ruleval) {
				return $frm[$key] == $frm[$ruleval];
			},
			'minlength'          => function ($frm, $key, $ruleval) {
				return (strlen($frm[$key]) >= $ruleval);
			},
			'maxlength'          => function ($frm, $key, $ruleval) {
				return !(strlen($frm[$key]) > $ruleval);
			},
			'email'              => function ($frm, $key, $ruleval) {
				return filter_var($frm[$key], FILTER_VALIDATE_EMAIL);
			},
			'alnum'              => function ($frm, $key, $ruleval) {
				return ctype_alnum($frm[$key]);
			},
			'alpha'              => function ($frm, $key, $ruleval) {
				return ctype_alpha($frm[$key]);
			},
			'numeric'            => function ($frm, $key, $ruleval) {
				return ctype_digit($frm[$key]) || is_numeric($frm[$key]);
			},
			'alnum_spaces'       => function ($frm, $key, $ruleval) {
				return ctype_alnum(str_replace(" ", "", $frm[$key]));
			},
			'alnum_spacesArabic' => function ($frm, $key, $ruleval) {
				// copied from https://stackoverflow.com/questions/44360293/matching-only-arabic-and-english-alphanumeric-with-one-space-allowed-only
				return preg_match("/^[\p{Arabic}a-zA-Z\p{N}]+\h?[\p{N}\p{Arabic}a-zA-Z]*$/u",
				                  str_replace(" ", "", $frm[$key]));
			} ];
	}

	/**
	 * @param $name
	 * @return mixed|stdClass
	 * @throws Exception
	 */
	public static function InitializeValidation($name)
	{
		if (array_key_exists($name, self::$validationQueue))
			throw new Exception("Validation Name $name Already Exists in the Queue!");

		self::$validationQueue[$name] = [];
		$kClass = new class
		{
			public $name;
			private $data;

			public function SetValidationRules($rules)
			{
				FormValidation::SetValidationOptions($this->name, $rules);
			}

			public function Validate($data)
			{
				$this->data = $data;
				return FormValidation::Validate($this->name, $data);
			}

			public function __get($name)
			{
				return $this->data[$name] ?? "";
			}
		};
		$kClass->name = $name;
		return $kClass;
	}

	public static function SetValidationOptions($name, $rules = [])
	{
		self::$validationQueue[$name] = $rules;
	}

	public static function Validate($name, $data)
	{
		if (!array_key_exists($name, self::$validationQueue)) return;
		$rules = self::$validationQueue[$name];
		$errors = [];

		// i go eat
		foreach ($rules as $item => $itemRules)
			foreach ($itemRules as $ruleName => $ruleValue) {
				if (!array_key_exists($ruleName, self::$validRules))
					continue; // ignore this rule because it doesn't exist
				$ok = self::$validRules[$ruleName]($data, $item, $ruleValue);
				if (!$ok) {
					$errors[] = sprintf(self::$ruleErrors[$ruleName], $itemRules['label'] ?? $item, $ruleValue);
					// if the value is required & not present just continue the first loop to avoid checking for other rules
					if ($ruleName == "required") continue 2;
				}
			}
		return empty($errors) ? FALSE : $errors;
	}
}