<?php
/**
 * Created by PhpStorm.
 * User: Mohamed Hosny
 * Date: 4/2/2019
 * Time: 8:10 AM
 * @property GoodDB database
 */

class IndexController
{

	public function Index()
	{
		// form validation
//		$rules =
//			[ 'hello' => [ 'required' => TRUE, 'minlength' => 4, 'maxlength' => 32, 'alnum_spacesArabic' => TRUE ] ];
//		$data = [ 'hello' => 'خهسشيب' ];
//
//		$validation = FormValidation::InitializeValidation("IndexTest");
//		$validation->SetValidationOptions($rules);
//		$errors = FormValidation::Validate($validation, $data);
//
//
		TemplateMaster::DisplayWithChildren("Index", [ 'userProfile' => SessionController::UserData() ], TRUE, FALSE,
		                                    FALSE);
	}

	public function HelloWorld()
	{

	}

	public function ContactUs()
	{
		TemplateMaster::DisplayWithChildren("contact", [ 'userProfile' => SessionController::UserData() ], TRUE, FALSE,
		                                    FALSE);
	}

	public function ThankYou()
	{
		if (!SessionController::IsUserLogged())
			Router::Redirect("/");
		else {
			if (!isset(Session::$Instance->CHECKEDOUT) || !Session::$Instance->CHECKEDOUT)
				Router::Redirect("/");
			elseif (Session::$Instance->CHECKEDOUT) {
				Session::$Instance->CHECKEDOUT = FALSE; // clear cart
				TemplateMaster::DisplayWithChildren("thankyou", [ 'mail' => SessionController::UserData() ]);
			}
		}
	}
}