<?php
/**
 * Created by PhpStorm.
 * User: Mohamed Hosny
 * Date: 4/2/2019
 * Time: 11:13 PM
 * @property GoodDB database
 */

if (!defined("language")) {
	define("language", "en");

	/* Errors */
	define("EMAIL_EXISTS_ERROR", "Email Already Exists!");
	define("SIGNUP_SUCCESSFUL", "Your Account was Successfully Created!");
	define("SIGNUP_FAILED",
	       "Something went wrong while Creating your Account.<br>if this issue persists please contact an administrator");
	define("SIGNIN_USER_NOT_FOUND", "Wrong Email or Password!");
	define("SIGNIN_USER_LOGGEDIN", "Loggedin Successfully... Redirecting");

	define("EDITPROFILE_PASSWORD_MISMATCH", "Password should match Confirm Password!");
	define("EDITPROFILE_INVALID_PASSWORD", "Invalid Current Password!");
	define("EDITPROFILE_SUCCESSFUL", "Profile was updated!");
	define("EDITPROFILE_NOCHANGES", "No Changes were made!");

	define("ORDERS_FAILED_ABORT", "Failed to abort order!");
	define("ORDERS_SUCCESSFUL_ABORT", "Order was Aborted Successfully!");
	define("CART_CHECKOUT_FAILED", "Checkout Failed Please Try Again Later!");
	define("CART_CHECKOUT_EMPTY", "Checkout Failed, Your Cart is Empty!");


	/* UserInterface */
	define("UI_HOME", "HOME");
	define("UI_ABOUTUS", "ABOUT US");
	define("UI_TESTS", "TESTS");
	define("UI_CONTACT", "CONTACT US");
	define("UI_CONTROLPANEL", "CONTROL PANEL");
	define("UI_LANGUAGE", "LANGUAGE");


	/* SignUp Form */
	define("SIGNUP_NAME", "First Name");
	define("SIGNUP_LASTNAME", "Last Name");
	define("SIGNUP_EMAIL", "EMAIL");
	define("SIGNUP_PASSWORD", "Password");
	define("SIGNUP_PASSWORD_CONFIRM", "Confirm Password");
	define("SIGNUP_PHONE", "Phone Number");
	define("SIGNUP_SUBMIT", "SignUP");

	/* SignIn Form */
	define("SIGNIN_PLACEHOLDER", "Please login!");
	define("SIGNIN_EMAIL", "Your Email Address");
	define("SIGNIN_PASSWORD", "Your Password");
	define("SIGNIN_FORGOT", "Forgot password?");
	define("SIGNIN_NOACCOUNT", "Do not have an account yet?");
	define("SIGNIN_SUBMIT", "LOGIN");

	/* ContactUs */
	define("CONTACT_INFO", "Contacts info");
	define("CONTACT_ADDRESS", "11 Fifth Ave - New York, US<br> + 61 (2) 8093 3400<br>");
	define("CONTACT_ADMINISTRATION", "Administration");
	define("CONTACT_GENERALQUESTION", "General questions");

	/* Footer */
	define("FOOTER_ABOUT", "About");
	define("FOOTER_USEFUL_LINKS", "Useful links");
	define("FOOTER_CONTACT_US", "Contact with Us");
	define("FOOTER_FOLLOW_US", "Follow us");
	define("FOOTER_TOS", "Terms and conditions");
	define("FOOTER_PRIVACY", "Privacy");
	define("FOOTER_ABOUTUS", "About Us");
	define("FOOTER_BLOG", "Blog");
	define("FOOTER_FAQ", "FAQ");
	define("FOOTER_DOCTORS", "Doctors");
	define("FOOTER_CLINICS", "Clinics");
	define("FOOTER_SPECIALIZATION", "Specialization");
	define("FOOTER_JOIN_AS_DOCTOR", "Join as a Doctor");
	define("FOOTER_DOWNLOADAPP", "Download App");

	/* Control */
	define("CONTROL_CONTROLS", "Controls");
	define("CONTROL_TITLE", "My Account");
	define("CONTROL_ORDERSBTN", "VIEW ORDERS");
	define("CONTROL_EDITPROFILE", "EDIT PROFILE");


	/* Edit Profile */
	define("EDITPROFILE_SUBMIT", "Save Changes");

	/* Tests */
	define("TESTS_TITLE", "AVAILABLE TESTS");


	/* Thank you */
	define("THANKYOU_TITLE", "Thanks for your Request!");
	define("THANKYOU_MAIL", "You'll receive a confirmation email at");

	/* General Titles */
	define("GENERAL_MOBILEMENU", "Menu mobile");
	define("GENERAL_ADMIN", "ADMIN");
	define("GENERAL_DATE", "DATE");
	define("GENERAL_CLIENTNAME", "CLIENT NAME");
	define("GENERAL_TESTNAME", "TEST NAME");
	define("GENERAL_PHONENUMBER", "PHONE NUMBER");
	define("GENERAL_ACTION", "ACTION");
	define("GENERAL_IDENTITYCHECK", "Confirm Your Identity");
}