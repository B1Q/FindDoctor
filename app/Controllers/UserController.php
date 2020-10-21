<?php
/**
 * Created by PhpStorm.
 * User: Mohamed Hosny
 * Date: 4/2/2019
 * Time: 8:27 PM
 * @property GoodDB database
 */

class UserController
{
	public function SignUp()
	{
		/* Extra Session Checks */
		// we use sessioncontroller instead of directly accessing the session class
		// we will still access the session class but this looks cleaner

		/* Display Registration Page */
		TemplateMaster::DisplayWithChildren("signup");
	}

	public function SignUpAjax()
	{
		$validationRules =
			[
				'firstName' => [
					'label' => 'First Name', 'required' => TRUE,
					'alpha' => TRUE, 'minlength' => 3, 'maxlength' => 12 ],

				'lastName' => [
					'label' => 'Last Name', 'required' => TRUE,
					'alpha' => TRUE, 'minlength' => 3, 'maxlength' => 12 ],

				'email' => [
					'label' => 'Email', 'required' => TRUE,
					'email' => TRUE ],

				'password' => [
					'label'    => 'Password', 'required' => TRUE,
					'alnum'    => TRUE, 'minlength' => 6, 'maxlength' => 32,
					'password' => TRUE ],

				'password_confirm' => [
					'label' => 'Confirm Password', 'required' => TRUE,
					'alnum' => TRUE, 'minlength' => 6, 'maxlength' => 32, 'matches' => 'password' ],

				'phone_number' => [
					'label' => 'Phone Number', 'required' => TRUE,
					'alnum' => TRUE, 'minlength' => 8, 'maxlength' => 11 ],
			];

		$validation = FormValidation::InitializeValidation("signUp");
		$validation->SetValidationRules($validationRules);

		$errors = $validation->Validate($_POST);
		if (!$errors) { // no errors go on
			// email check
			if ($this->EmailExists($validation->email))
				die(json_encode([ 'state' => 'error', 'message' => Utility::Errorify([ EMAIL_EXISTS_ERROR ]) ]));

			$insertUser = $this->BuildInsertStatement($validationRules, $_POST);

			$insert = $this->database->insert(USERTABLE, $insertUser);

			$error =
				[ 'state' => $insert ? 'success' : 'error', 'message' => $insert ? SIGNUP_SUCCESSFUL : SIGNUP_FAILED ];
			die(json_encode($error));
		} else
			die(json_encode([ 'state' => 'error', 'message' => Utility::Errorify($errors) ]));
	}

	private function BuildInsertStatement($validationRules, $data)
	{
		$statement = [];
		foreach ($validationRules as $key => $value)
			if (array_key_exists("required", $value) && $value['required']) {
				if (array_key_exists('matches', $value))
					continue;
				$statement[$key] = array_key_exists('password', $value) ? md5($data[$key]) : $data[$key];
			}
		return $statement;
	}

	private function EmailExists($email, $pass = '')
	{
		$where = [ 'email' => $email ];
		if (!empty($pass))
			$where['password'] = md5($pass);
		return count($this->database->select("id")
		                            ->from(USERTABLE)
		                            ->where($where)
		                            ->build()->result()) > 0;
	}


	public function Control()
	{
		if (SessionController::IsUserLogged()) {
			$data = [ 'userProfile' => SessionController::UserData(), 'ordersData' => SessionController::OrderData(1) ];
			TemplateMaster::DisplayWithChildren("control", $data);
		} else
			TemplateMaster::DisplayWithChildren("signin");
	}

	public function SignInAjax()
	{
		$validationRules = [
			'email' => [
				'label' => 'Email', 'required' => TRUE,
				'email' => TRUE ],

			'password' => [
				'label'    => 'Password', 'required' => TRUE,
				'alnum'    => TRUE, 'minlength' => 6, 'maxlength' => 32,
				'password' => TRUE ]
		];

		$validation = FormValidation::InitializeValidation("signin");
		$validation->SetValidationRules($validationRules);

		$errors = $validation->Validate($_POST);
		if (!$errors) { // no errors go on
			if (!$this->EmailExists($validation->email, $validation->password))
				die(json_encode([ 'state' => 'error', 'message' => Utility::Errorify([ SIGNIN_USER_NOT_FOUND ]) ]));

			$session = [ 'email' => $validation->email ];

			SessionController::InitSession($session);
			Session::$Instance->Email = $validation->email;

			die(json_encode([ 'state' => 'success', 'message' => SIGNIN_USER_LOGGEDIN ]));

		} else
			die(json_encode([ 'state' => 'error', 'message' => Utility::Errorify($errors) ]));
	}

	public function UpdateProfileAjax()
	{
		$validationRules =
			[
				'firstName' => [
					'label' => 'First Name', 'required' => FALSE,
					'alpha' => TRUE, 'minlength' => 3, 'maxlength' => 12 ],

				'lastName' => [
					'label' => 'Last Name', 'required' => FALSE,
					'alpha' => TRUE, 'minlength' => 3, 'maxlength' => 12 ],

				'email' => [
					'label' => 'Email', 'required' => FALSE,
					'email' => TRUE ],

				'password' => [
					'label'    => 'Password', 'required' => TRUE,
					'alnum'    => TRUE, 'minlength' => 6, 'maxlength' => 32,
					'password' => TRUE ],

				'password_confirm' => [
					'label' => 'Confirm Password', 'required' => TRUE,
					'alnum' => TRUE, 'minlength' => 6, 'maxlength' => 32, 'matches' => 'password' ],

				'phone_number' => [
					'label' => 'Phone Number', 'required' => FALSE,
					'alnum' => TRUE, 'minlength' => 11, 'maxlength' => 32 ],
			];

		$validation = FormValidation::InitializeValidation("signUp");
		$validation->SetValidationRules($validationRules);

		$errors = $validation->Validate($_POST);

		if (!$errors) { // go on
			$userData = SessionController::UserData();
			$firstName = $validation->firstName;
			$lastName = $validation->lastName;
			$email = $validation->email;
			$password = $validation->password;
			$password_confirm = $validation->password_confirm;
			$phone_number = $validation->phone_number;

			$errors = [];
			if ($password_confirm != $password_confirm)
				$errors[] = EDITPROFILE_PASSWORD_MISMATCH;
			if (!$this->VerifyPassword($password))
				$errors[] = EDITPROFILE_INVALID_PASSWORD;

			if (!empty($errors))
				die(json_encode([ 'state' => 'error', 'message' => Utility::Errorify($errors) ]));

			if ($firstName != $userData['firstname'] || $lastName != $userData['lastname']
				|| $email != $userData['email'] || $phone_number != $userData['phone_number']) {
				// update profile
				$update = [
					'firstname'    => $firstName, 'lastname' => $lastName, 'email' => $email,
					'phone_number' => $phone_number ];

				$updateResult = $this->database->update(USERTABLE, $update)
				                               ->where([ 'id' => $userData['id'] ])
				                               ->build()// never forget to build the query first
				                               ->execute();
				if ($updateResult)
					die(json_encode([ 'state' => 'success', 'message' => EDITPROFILE_SUCCESSFUL ]));
			} else
				die(json_encode([ 'state' => 'success', 'message' => EDITPROFILE_NOCHANGES ]));

		} else
			die(json_encode([ 'state' => 'error', 'message' => Utility::Errorify($errors) ]));
	}

	private function VerifyPassword($password)
	{
		$email = Session::$Instance->Email;
		$result = $this->database->select("*")
		                         ->from(USERTABLE)
		                         ->where([ 'email' => $email, 'password' => md5($password) ])
		                         ->build()
		                         ->result();
		return count($result) > 0;
	}

	public function AbortTestAjax()
	{
		$validationRules =
			[
				'id' => [ 'label' => 'TestID', 'required' => TRUE, 'numeric' => TRUE ],
			];

		$validation = FormValidation::InitializeValidation("signUp");
		$validation->SetValidationRules($validationRules);

		$errors = $validation->Validate($_POST);
		if (!$errors) { // no errors go on

			$orderID = $validation->id;
			$userData = SessionController::UserData();

			$realID = $this->database->select("id,aborted")
			                         ->from(ORDERSTABLE)
			                         ->where([ 'clientid' => $userData['id'], 'id' => $orderID ])
			                         ->build()
			                         ->result();
			if (count($realID) > 0) {
				if ($realID[0]['aborted'] == 1)
					die(json_encode([ 'state' => 'error', 'message' => ORDERS_FAILED_ABORT ]));

				$update = [ 'aborted' => 1 ];
				$where = [ 'clientid' => $userData['id'], 'id' => $orderID ];

				$updateResult = $this->database->update(ORDERSTABLE, $update)
				                               ->where($where)
				                               ->build()
				                               ->execute();
				if ($updateResult)
					die(json_encode([ 'state' => 'success', 'message' => ORDERS_SUCCESSFUL_ABORT ]));
			}

		} else
			die(json_encode([ 'state' => 'error', 'message' => implode("<br>", $errors) ]));
	}

	public function Logout()
	{
		SessionController::DestroySession();
		Session::$Instance->DestroySession();
		Router::Redirect("/");
	}
}