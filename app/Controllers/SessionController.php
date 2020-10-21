<?php
/**
 * Created by PhpStorm.
 * User: Mohamed Hosny
 * Date: 4/2/2019
 * Time: 8:48 PM
 * @property GoodDB database
 */


define("SessionController", TRUE);

/**
 * @property GoodDB database
 */
class SessionController
{
	private static $database = NULL;

	public static function IsUserLogged()
	{
		/** @noinspection PhpUndefinedFieldInspection */
		return isset(Session::$Instance->SessionId);
	}

	public static function IsAdmin()
	{
		return self::UserData()['rank'] == 1;
	}

	public static function InitSession($data)
	{
		if (self::$database == NULL)
			self::$database = GoodDB::getInstance();

		if (self::HasSession()) return;

		$sessionId = Utility::RandomNumberGenerator(6);
		$values = [ 'sessionid' => $sessionId, 'sessiondata' => json_encode($data), 'ip_address' => Utility::get_ip() ];

		self::$database->insert(SESSIONSTABLE, $values);

		Session::$Instance->SessionId = $sessionId;
	}

	public static function UserData()
	{
		if (self::$database == NULL)
			self::$database = GoodDB::getInstance();

		if (!self::IsUserLogged()) return [];

		$email = Session::$Instance->Email;

		if (empty($email)) return [];

		$userData = self::$database->select("`rank`,id,email,firstname,lastname,phone_number")
		                           ->from(USERTABLE)
		                           ->where([ 'email' => $email ])
		                           ->limit(1)
		                           ->build()->result();
		if (!empty($userData) && count($userData) > 0)
			return $userData[0]; // return first element of the returned array
	}

	public static function OrderData($userID = 0)
	{
		$user = self::UserData();
		if (!empty($user)) {
			$orders = self::$database->select("aborted,id,clientname,testname,phone_number,order_state,order_date")
			                         ->from(ORDERSTABLE);
			if ($userID > 0)
				$orders->where([ 'clientid' => $user['id'] ]);

			$orders = $orders->order_by("order_date", "desc")
			                 ->build()
			                 ->result();
			return $orders;
		}

		return [];
	}

	public static function HasSession()
	{
		$ip = Utility::get_ip();

		$sessions = self::$database->select("*")
		                           ->from(SESSIONSTABLE)
		                           ->where([ 'expirationdate' => 0, 'ip_address' => $ip ])
		                           ->order_by("updated_at", "desc")
		                           ->limit(1)
		                           ->build()
		                           ->result();
		if (!empty($sessions)) {
			$session = (object)$sessions[0];

			if (time() - strtotime($session->updated_at) >= Session::$Instance->ExpirationTime) {

				$values = [ 'expirationdate' => time(), 'updated_at' => Utility::dateNow() ];

				self::$database->update(SESSIONSTABLE, $values)
				               ->where([ 'sessionid' => $session->sessionid ])
				               ->build()
				               ->execute();

				return FALSE; // create a new session this one expired and or closed
			}
		}
		return count($sessions) > 0;
	}

	public static function DestroySession()
	{
		if (self::$database == NULL)
			self::$database = GoodDB::getInstance();

		$values = [ 'expirationdate' => time(), 'updated_at' => Utility::dateNow() ];

		$where =
			isset(Session::$Instance->SessionId) ? [ 'sessionid' => Session::$Instance->SessionId ] : [ 'ip_address' => Utility::get_ip() ];
		self::$database->update(SESSIONSTABLE, $values)
		               ->where( [ 'sessionid' => Session::$Instance->SessionId ])
		               ->build()
		               ->execute();

		Session::$Instance->DestroySession();
	}
}