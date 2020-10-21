<?php
/**
 * Created by PhpStorm.
 * User: Mohamed Hosny
 * Date: 4/2/2019
 * Time: 8:28 PM
 * @property GoodDB database
 * @property int LastSessionAction
 */

class Session
{
	public static $Instance = NULL;

	public $ExpirationTime = 30 * 60;

	protected $SessionStarted = FALSE;


	public function __construct($config)
	{
		if (self::$Instance == NULL)
			self::$Instance = $this;

		$this->ExpirationTime = $config['expirationTime'] * 60;
	}

	public function InitializeSession()
	{
		if ($this->SessionStarted) return;
		$options = [ 'cookie_lifetime' => $this->ExpirationTime ];
		$this->SessionStarted = session_start($options);
		$this->LastSessionAction = time();
		$this->LoadFromDB();
	}

	public function DestroySession()
	{
		if (!$this->SessionStarted) return;
		$this->SessionStarted = !session_destroy();
		unset($_SESSION);
	}

	public function __set($name, $value)
	{
		$this->Expired();
		$_SESSION[$name] = $value;
		$this->SaveToDB();
	}

	public function __get($name)
	{
		$this->Expired();
		return $_SESSION[$name] ?? "";
	}

	public function __isset($name)
	{
		$this->Expired();
		return isset($_SESSION[$name]);
	}

	public function Expired()
	{
		if (!isset($this->LastSessionAction))
			$this->LastSessionAction = time();
		if (time() - $this->LastSessionAction >= $this->ExpirationTime) {
			$this->DestroySession();

			// update session in db
			if (isset($this->SessionId))
				GoodDB::getInstance()->update(SESSIONSTABLE, [ 'expirationdate' => time() ])
				      ->where([ 'sessionid' => $this->SessionId ])
				      ->build()
				      ->execute();

			Router::Redirect("/");
		} else
			$this->LastSessionAction = time();
	}

	public function LoadFromDB()
	{
		if (isset($this->SessionId)) {

			$data = GoodDB::getInstance()->select("sessiondata")
			              ->from(SESSIONSTABLE)
			              ->where([ 'sessionid' => $this->SessionId, 'expirationdate' => 0 ])
			              ->build()
			              ->result();
			if (count($data) > 0) {
				$sessionData = $data[0]['sessiondata'];
				$jsonSession = json_decode($sessionData);
				foreach ($jsonSession as $key => $value)
					$this->$key = $value;
			}
		}
	}

	public function SaveToDB()
	{
		if (isset($this->SessionId)) {
			GoodDB::getInstance()->update(SESSIONSTABLE, [ 'sessiondata' => json_encode($_SESSION) ])
			      ->where([ 'sessionid' => $this->SessionId ])
			      ->build()
			      ->execute();
		}
	}
}