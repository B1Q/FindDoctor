<?php
/**
 * Created by PhpStorm.
 * User: Mohamed Hosny
 * Date: 4/2/2019
 * Time: 8:09 AM
 */


$routes = [];

$routes['acontrollerweallneed'] = "SessionController";

$routes['default'] = "IndexController";

/* Static */
$routes['Index'] = "IndexController";
$routes['contact'] = "IndexController/ContactUs";
$routes['thankyou'] = "IndexController/ThankYou";

/* User Controller */
$routes['control'] = "UserController/Control";
$routes['signup'] = "UserController/SignUp";
$routes['logout'] = "UserController/Logout";

/* Cart Controller*/
$routes['tests'] = "CartController/ShowTests";
$routes['checkout'] = "CartController/Checkout";

/* Admin Controller */
$routes['admincp'] = "AdminController/Index";
$routes['admincp/categories'] = "AdminController/Categories";
$routes['admincp/tests'] = "AdminController/Tests";

/* Ajax Requests */
$routes['signinConfirm'] = "UserController/SignInAjax";
$routes['signupConfirm'] = "UserController/SignUpAjax";
$routes['updateProfile'] = "UserController/UpdateProfileAjax";
$routes['abortTest'] = "UserController/AbortTestAjax";
$routes['addtocart'] = "CartController/AddToCartAjax";
$routes['removefromcart'] = "CartController/RemoveFromCart";
$routes['adminOrderUpdate'] = "AdminController/UpdateOrderAjax";
$routes['adminUpdateCategory'] = "AdminController/UpdateCategoryAjax";
$routes['adminAddCategory'] = "AdminController/AddCategoryAjax";
$routes['adminAddTest'] = "AdminController/AddTestAjax";
$routes['adminUpdateTest'] = "AdminController/UpdateTestAjax";
$routes['adminDeleteCategory'] = "AdminController/RemoveCategoryAjax";