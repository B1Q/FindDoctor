<?php
/**
 * Created by PhpStorm.
 * User: b1qb0
 * Date: 4/2/2019
 * Time: 12:35 AM
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'meconnect.php';

$db = new MeConnect();
$validRules = [
	'required'=>function($frm,$key,$ruleval){return array_key_exists($key,$frm);},
	'matches'=>function($frm,$key,$ruleval) {return $frm[$key] == $frm[$ruleval];},
	'minlength'=>function($frm,$key,$ruleval) {return (strlen($frm[$key]) >= $ruleval);},
	'maxlength'=>function($frm,$key,$ruleval) {return !(strlen($frm[$key]) > $ruleval);},
	'email'=>function($frm,$key,$ruleval) {return filter_var($frm[$key],FILTER_VALIDATE_EMAIL);},
	'alnum'=>function($frm,$key,$ruleval) {return ctype_alnum($frm[$key]);},
	'alpha'=>function($frm,$key,$ruleval) {return ctype_alpha($frm[$key]);},
	'numeric'=>function($frm,$key,$ruleval) {return ctype_digit($frm[$key]);},
	'alnum_spaces'=>function($frm,$key,$ruleval) {return preg_match("/^[أ-يa-zA-Z]+$/u", str_replace(" ","",$frm[$key]));}];

$ruleErrors = ['required'=>'The field %s is required',
               'matches'=>'The value of %s doesn\'t match %s',
               'minlength'=>'The value of %s has to be more than %d in length',
               'maxlength'=>'The value of %s has to be less than %d in length',
               'email'=>'The value of %s has an invalid email format!',
               'alnum'=>'The value of %s has to be alphanumeric(A-z-0-9)',
               'alnum_spaces'=>'The value of %s has to be alphanumeric(A-z-0-9) spaces allowed',
               'alpha'=>'The value of %s has to be alpha(A-z)'];

// Parse Post
$validation = ['token'=>['required'=>true,'minlength'=>8,'maxlength'=>8,'alnum'=>true],
               'id'=>['required'=>true,'numeric'=>true],
               'name'=>['required'=>true,'minlength'=>4,'maxlength'=>32,'alnum_spaces'=>true],
               'points'=>['required'=>true,'minlength'=>1,'maxlength'=>4,'numeric'=>true]];
$formValidation = FormValidation($_POST,$validation);
if(!empty($formValidation))
	die(json_encode(['state'=>0,'message'=>implode(",",$formValidation)]));
else
{
	$token = $_POST['token'];
	$name = $_POST['name'];
	$id = $_POST['id'];
	$points = $_POST['points'];
	$present = $_POST['present'] ?? 0;
	$userID = getUserByToken($token,$db);
	if($id>0)
	{
		if($userID == 0)
			die(json_encode(['id'=>0,'name'=>'','present'=>0,'top5'=>0]));
		else
		{
			$studentOK = studentThere($userID,$id,$db);
			// add new student
			if($studentOK[0])
			{
				$db->DoQuery("update _students set name=?, points=? where userid=? and id=?",
				             [$name,$points,$userID,$id]);
				$studentData = $studentOK[1];
				die(json_encode($studentData));
			}
			else
				die(json_encode(['id'=>0,'name'=>'','present'=>0,'top5'=>0]));
		}
	}
	else
		die(json_encode(['state'=>0,'message'=>'Invalid Token']));
}

function studentThere($userID,$studentID,$db)
{
	$q = $db->ReadRows("select * from _students where userid=? and id=?",[$userID,$studentID]);
	return count($q) > 0 ? [true,$q[0]] : [false];
}

function getUserByToken($token,$db)
{
	$q = $db->ReadRows("select * from _tokens where token=?",[$token]);
	if(count($q)>0)
		return $q[0]['user'];
	else
		return 0;
}

function FormValidation($form,$rules = [])
{
	global $validRules;
	global $ruleErrors;
	$errors = [];

	foreach($rules as $item=>$itemRules)
		foreach($itemRules as $ruleName=>$ruleValue)
		{
			if(!array_key_exists($ruleName,$validRules))
				continue; // ignore this rule because it doesn't exist
			$ok = $validRules[$ruleName]($form,$item,$ruleValue);
			if(!$ok)
			{
				$errors[] = sprintf($ruleErrors[$ruleName],$item,$ruleValue);
				// if the value is required & not present just continue the first loop to avoid checking for other rules
				if($ruleName == "required") continue 2;
			}
		}
	return $errors;
}