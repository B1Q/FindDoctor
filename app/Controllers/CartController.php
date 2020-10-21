<?php
/**
 * Created by PhpStorm.
 * User: Mohamed Hosny
 * Date: 4/3/2019
 * Time: 10:16 AM
 * @property GoodDB database
 */

class CartController
{

	protected $categories = NULL;
	protected $tests = NULL;

	public function ShowTests()
	{
		if (SessionController::IsUserLogged()) {
			$this->LoadTests();
			$updatedTests = $this->LoadCategories($this->tests);
			$data = [
				'userProfile' => SessionController::UserData(), 'tests' => $updatedTests,
				'categories'  => $this->categories,
				'cartData'    => $this->CartData() ];
			TemplateMaster::DisplayWithChildren("cart/tests", $data);
		} else {
			SessionController::DestroySession();
			Router::Redirect("/control");
			//TemplateMaster::DisplayWithChildren("signin");
		}
	}

	public function Checkout()
	{
		if (!SessionController::IsUserLogged()) exit;
		if (empty(Session::$Instance->CART))
			die(json_encode([ 'state' => 'error', 'message' => CART_CHECKOUT_EMPTY ]));

		$userData = SessionController::UserData();
		$cart = Session::$Instance->CART;
		$fullName = $userData['firstname'] . ' ' . $userData['lastname'];
		$phoneNumber = $userData['phone_number'];
		$orderIdentifier = Utility::RandomStringGenerator(8);

		foreach ($cart as $item) {

			$hasOrder = $this->database->select("orderIdentifier")
			                           ->from(ORDERSTABLE)
			                           ->where([ 'orderIdentifier' => $orderIdentifier, 'testid' => $item->id ])
			                           ->build()
			                           ->result();
			if (count($hasOrder) > 0) continue;
			$values =
				[
					'clientname'      => $fullName, 'testname' => $item->name, 'testid' => $item->id,
					'price'           => $item->price, 'order_date' => Utility::dateNow(),
					'phone_number'    => $phoneNumber,
					'clientid'        => $userData['id'], 'aborted' => 0,
					'order_state'     => 'WAITING', 'message' => '',
					'orderIdentifier' => $orderIdentifier ];
			$result = $this->database->insert(ORDERSTABLE, $values);
			if (!$result)
				die(json_encode([ 'state' => 'error', 'message' => CART_CHECKOUT_FAILED ]));
		}

		Session::$Instance->CART = [];
		Session::$Instance->CHECKEDOUT = TRUE;
		die(json_encode([ 'state' => 'success', 'message' => '/thankyou' ]));
	}

	public function AddToCartAjax()
	{
		if (!SessionController::IsUserLogged()) exit;

		$validationRules = [
			'itemID' => [ 'label' => 'id', 'required' => TRUE, 'numeric' => TRUE ]
		];

		$validation = FormValidation::InitializeValidation("addtocart");
		$validation->SetValidationRules($validationRules);

		$errors = $validation->Validate($_POST);
		if (!$errors) { // no errors go on

			if ($this->HasItem($validation->itemID))
				die(json_encode([ 'state' => 'error', 'message' => print_r(Session::$Instance->CART, TRUE) ]));

			// add item to cart
			$cart = Session::$Instance->CART;
			$testData = $this->TestData($validation->itemID);
			$cartItem = new stdClass();
			$cartItem->id = $validation->itemID;
			$cartItem->name = $testData[0];
			$cartItem->price = $testData[1];

			$cart[] = $cartItem;

			Session::$Instance->CART = $cart;


			$updateCart = [ 'item' => $cartItem, 'total' => $this->TotalPrice() ];

			die(json_encode([ 'state' => 'success', 'message' => $updateCart ]));

		} else
			die(json_encode([ 'state' => 'error', 'message' => Utility::Errorify($errors) ]));
	}

	public function RemoveFromCart()
	{
		if (!SessionController::IsUserLogged()) exit;

		$validationRules = [
			'itemID' => [ 'label' => 'id', 'required' => TRUE, 'numeric' => TRUE ]
		];

		$validation = FormValidation::InitializeValidation("removefromcart");
		$validation->SetValidationRules($validationRules);

		$errors = $validation->Validate($_POST);
		if (!$errors) { // no errors go on

			if (!$this->HasItem($validation->itemID))
				die(json_encode([ 'state' => 'error', 'message' => "Invalid ItemID" ]));

			$this->RemoveItem($validation->itemID);

			$updatedStatus = [ 'item' => $validation->itemID, 'total' => $this->TotalPrice() ];

			die(json_encode([ 'state' => 'success', 'message' => $updatedStatus ]));

		} else
			die(json_encode([ 'state' => 'error', 'message' => Utility::Errorify($errors) ]));
	}

	private function TotalPrice()
	{
		$price = 0;
		$cart = Session::$Instance->CART;

		foreach ($cart as $item)
			$price += $item->price;

		return $price;
	}

	private function TestData($id)
	{
		if (!isset($this->tests))
			$this->LoadTests();

		foreach ($this->tests as $test)
			if ($test['id'] == $id)
				return [ $test['name'], $test['price'] ];
		return [ '', '' ];
	}

	private function RemoveItem($itemID)
	{
		if (!isset(Session::$Instance->CART))
			Session::$Instance->CART = [];

		$cart = Session::$Instance->CART;
		$finalCart = [];

		foreach ($cart as $item) {
			if ($item->id == $itemID)
				continue;
			$finalCart[] = $item;
		}

		Session::$Instance->CART = $finalCart;
	}

	private function HasItem($id)
	{
		if (!isset(Session::$Instance->CART))
			Session::$Instance->CART = [];

		$cart = Session::$Instance->CART;

		foreach ($cart as $item)
			if ($item->id == $id)
				return TRUE;

		return FALSE;
	}

	private function CartData()
	{
		if (!isset(Session::$Instance->CART))
			Session::$Instance->CART = [];

		$cart = Session::$Instance->CART;
		$cart['total'] = $this->TotalPrice();
		return $cart;
	}

	private function LoadTests()
	{
		$this->tests = $this->database->select("*")
		                              ->from(TESTSTABLE)
		                              ->order_by("updated_at", "desc")
		                              ->build()
		                              ->result();
	}

	private function LoadCategories($tests)
	{
		$cats = $this->database->select("*")
		                       ->from(CATEGORYTABLE)
		                       ->order_by("`order`", "asc")
		                       ->build()
		                       ->result();

		$this->categories = $cats;
		$testsFinal = [];
		foreach ($tests as &$test) {
			$categories = explode(",", $test['category']);
			$finalcategories = "";
			foreach ($cats as $key => $cat)
				if (in_array($cat['id'], $categories))
					$finalcategories .= $cat['name'] . ",";

			$test['category'] = substr($finalcategories, 0, strlen($finalcategories) - 1);
			$testsFinal[] = $test;
		}
		return $testsFinal;
	}
}