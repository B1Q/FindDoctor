<?php
/**
 * Created by PhpStorm.
 * User: Mohamed Hosny
 * Date: 4/3/2019
 * Time: 8:59 PM
 * @property GoodDB database
 */

class AdminController
{
	public function Index()
	{
		if (SessionController::IsUserLogged() && SessionController::IsAdmin()) {
			$orders = SessionController::OrderData(0);

			$data = [ 'orders' => $orders ];
			TemplateMaster::DisplayWithChildren("admincp/dashboard", $data);
		} else {
			SessionController::DestroySession();
			Router::Redirect("/control");
		}
	}

	public function Categories()
	{
		if (SessionController::IsUserLogged()) {
			$categories = $this->database->select("*")
			                             ->from(CATEGORYTABLE)
			                             ->order_by("`order`", "asc")
			                             ->build()
			                             ->result();

			$data = [ 'categories' => $categories ];
			TemplateMaster::DisplayWithChildren("admincp/categories", $data);
		} else {
			SessionController::DestroySession();
			Router::Redirect("/control");
		}
	}

	public function Tests()
	{
		if (SessionController::IsUserLogged()) {
			$categories = $this->database->select("*")
			                             ->from(CATEGORYTABLE)
			                             ->order_by("`order`", "asc")
			                             ->build()
			                             ->result();

			$tests = $this->database->select("*")
			                        ->from(TESTSTABLE)
			                        ->build()
			                        ->result();
			$tests = $this->LoadCategories($tests);
			$data = [ 'tests' => $tests, 'categories' => $categories ];
			TemplateMaster::DisplayWithChildren("admincp/tests", $data);
		} else {
			SessionController::DestroySession();
			Router::Redirect("/control");
		}
	}

	public function AddTestAjax()
	{
		if (!SessionController::IsUserLogged() || !SessionController::IsAdmin())
			die(json_encode([ 'state' => 'dead', 'message' => 'not loggedin!' ]));

		$validationRules = [
			'testName'        => [ 'label' => 'Test Name', 'required' => TRUE, 'alnum_spacesArabic' => TRUE ],
			'testPrice'       => [ 'label' => 'Test Price', 'required' => TRUE, 'numeric' => TRUE ],
			'testDescription' => [ 'label' => 'Test Description', 'required' => TRUE ],
			'testcategories'  => [ 'label' => 'Categories', 'required' => TRUE ] ];

		$validation = FormValidation::InitializeValidation("addTest");
		$validation->SetValidationRules($validationRules);

		$errors = $validation->Validate($_POST);
		if (!$errors) { // no errors go on

			if ($this->HasTest($validation->testName))
				die(json_encode([
					                'state'   => 'error',
					                'message' => Utility::Errorify("A test with the name $validation->testName already exists!") ]));

			$values = [
				'name'     => $validation->testName, 'description' => $validation->testDescription,
				'price'    => $validation->testPrice, 'notes' => '',
				'category' => implode(',', $validation->testcategories),
				'img'      => '' ];

			$result = $this->database->insert(TESTSTABLE, $values);

			if ($result) {
				$testID = $this->HasTest($validation->testName);
				die(json_encode([
					                'state'   => 'success',
					                'message' => "Test $validation->testName was added Successfully!",
					                'data'    => $testID ]));
			} else
				die(json_encode([
					                'state'   => 'error',
					                'message' => 'Something went wrong while trying to add a new test' ]));
		} else
			die(json_encode([ 'state' => 'error', 'message' => Utility::Errorify($errors) ]));
	}

	public function UpdateTestAjax()
	{
		if (!SessionController::IsUserLogged() || !SessionController::IsAdmin())
			die(json_encode([ 'state' => 'dead', 'message' => 'not loggedin!' ]));

		$validationRules = [
			'edittestID'          => [ 'label' => 'Test ID', 'required' => TRUE, 'numeric' => TRUE ],
			'editTestName'        => [ 'label' => 'Test Name', 'required' => TRUE, 'alnum_spacesArabic' => TRUE ],
			'editTestPrice'       => [ 'label' => 'Test Price', 'required' => TRUE, 'numeric' => TRUE ],
			'edittestDescription' => [ 'label' => 'Test Description', 'required' => TRUE ],
			'edittestcategories'  => [ 'label' => 'Categories', 'required' => TRUE ] ];

		$validation = FormValidation::InitializeValidation("addTest");
		$validation->SetValidationRules($validationRules);

		$errors = $validation->Validate($_POST);
		if (!$errors) { // no errors go on

			$values = [
				'name'     => $validation->editTestName, 'description' => $validation->edittestDescription,
				'price'    => $validation->editTestPrice, 'notes' => '',
				'category' => implode(',', $validation->edittestcategories),
				'img'      => '' ];

			$result = $this->database->update(TESTSTABLE, $values)
			                         ->where([ 'id' => $validation->edittestID ])
			                         ->build()
			                         ->execute();

			if ($result) {
				$testID = $this->HasTest($validation->testName);
				die(json_encode([
					                'state'   => 'success',
					                'message' => "Test $validation->testName was Updated Successfully!",
					                'data'    => $testID ]));
			} else
				die(json_encode([
					                'state'   => 'error',
					                'message' => 'Something went wrong while trying to update a test' ]));
		} else
			die(json_encode([ 'state' => 'error', 'message' => Utility::Errorify($errors) ]));
	}

	public function UpdateOrderAjax()
	{
		if (!SessionController::IsUserLogged() || !SessionController::IsAdmin())
			die(json_encode([ 'state' => 'dead', 'message' => 'not loggedin!' ]));

		$validationRules = [ 'orderID' => [ 'label' => 'OrderID', 'required' => TRUE, 'numeric' => TRUE ] ];

		$validation = FormValidation::InitializeValidation("updateOrder");
		$validation->SetValidationRules($validationRules);

		$errors = $validation->Validate($_POST);
		if (!$errors) { // no errors go on

			$updateOrder = [ 'aborted' => 0, 'order_state' => 'DONE', 'message' => $validation->orderMessage ?? "" ];

			$result = $this->database->update(ORDERSTABLE, $updateOrder)
			                         ->where([ 'id' => $validation->orderID ])
			                         ->build()
			                         ->execute();

			if ($result)
				die(json_encode([ 'state' => 'success', 'message' => 'Order was Updated Successfully!' ]));
			else
				die(json_encode([
					                'state'   => 'error',
					                'message' => 'Something went wrong while trying to update the Order' ]));
		} else
			die(json_encode([ 'state' => 'error', 'message' => Utility::Errorify($errors) ]));
	}

	public function UpdateCategoryAjax()
	{
		if (!SessionController::IsUserLogged() || !SessionController::IsAdmin())
			die(json_encode([ 'state' => 'dead', 'message' => 'not loggedin!' ]));

		$validationRules = [
			'categoryID'    => [ 'label' => 'CategoryID', 'required' => TRUE, 'numeric' => TRUE ],
			'categoryName'  => [ 'label' => 'Category Name', 'required' => TRUE, 'alnum_spaces' => TRUE ],
			'categoryOrder' => [ 'label' => 'Category Order', 'required' => TRUE, 'numeric' => TRUE ],
			'frontPage'     => [ 'label' => 'Front Page', 'required' => TRUE, 'numeric' => TRUE ]
		];

		$validation = FormValidation::InitializeValidation("updateCategory");
		$validation->SetValidationRules($validationRules);

		$errors = $validation->Validate($_POST);
		if (!$errors) { // no errors go on

			$updateCategory = [
				'name'      => $validation->categoryName,
				'`order`'   => $validation->categoryOrder,
				'frontpage' => $validation->frontPage ];

			$result = $this->database->update(CATEGORYTABLE, $updateCategory)
			                         ->where([ 'id' => $validation->categoryID ])
			                         ->build()
			                         ->execute();

			if ($result)
				die(json_encode([ 'state' => 'success', 'message' => 'Category was Updated Successfully!' ]));
			else
				die(json_encode([
					                'state'   => 'error',
					                'message' => 'Something went wrong while trying to update Category' ]));
		} else
			die(json_encode([ 'state' => 'error', 'message' => Utility::Errorify($errors) ]));
	}

	public function AddCategoryAjax()
	{
		if (!SessionController::IsUserLogged() || !SessionController::IsAdmin())
			die(json_encode([ 'state' => 'dead', 'message' => 'not loggedin!' ]));

		$validationRules = [
			'categoryName'  => [ 'label' => 'Category Name', 'required' => TRUE, 'alnum_spaces' => TRUE ],
			'categoryOrder' => [ 'label' => 'Category Order', 'required' => TRUE, 'numeric' => TRUE ],
			'frontPage'     => [ 'label' => 'Front Page', 'required' => TRUE, 'numeric' => TRUE ]
		];

		$validation = FormValidation::InitializeValidation("updateCategory");
		$validation->SetValidationRules($validationRules);

		$errors = $validation->Validate($_POST);
		if (!$errors) { // no errors go on

			if ($this->HasCategory($validation->categoryName))
				die(json_encode([
					                'state'   => 'error',
					                'message' => Utility::Errorify("A Category with the name $validation->categoryName already exists!") ]));

			$insert = [
				'name'      => $validation->categoryName,
				'`order`'   => $validation->categoryOrder,
				'frontpage' => $validation->frontPage ];

			$result = $this->database->insert(CATEGORYTABLE, $insert);

			if ($result) {
				$data = $this->HasCategory($validation->categoryName);
				die(json_encode([
					                'state' => 'success', 'message' => 'New Category was Added Successfully!',
					                'data'  => $data ]));
			} else
				die(json_encode([
					                'state'   => 'error',
					                'message' => 'Something went wrong while trying to add a new Category' ]));
		} else
			die(json_encode([ 'state' => 'error', 'message' => Utility::Errorify($errors) ]));
	}

	public function RemoveCategoryAjax()
	{
		if (!SessionController::IsUserLogged() || !SessionController::IsAdmin())
			die(json_encode([ 'state' => 'dead', 'message' => 'not loggedin!' ]));

		$validationRules = [
			'categoryID' => [ 'label' => 'Category ID', 'required' => TRUE, 'numeric' => TRUE ],
		];

		$validation = FormValidation::InitializeValidation("removeCategory");
		$validation->SetValidationRules($validationRules);

		$errors = $validation->Validate($_POST);
		if (!$errors) { // no errors go on


			$result = $this->database->delete(CATEGORYTABLE, $validation->categoryID);

			if ($result) {
				die(json_encode([
					                'state' => 'success', 'message' => 'Category was Deleted Successfully!', ]));
			} else
				die(json_encode([
					                'state'   => 'error',
					                'message' => 'Something went wrong while trying to delete a Category' ]));
		} else
			die(json_encode([ 'state' => 'error', 'message' => Utility::Errorify($errors) ]));
	}

	public function HasCategory($name)
	{
		$result = $this->database->select("id")->from(CATEGORYTABLE)->where([ 'name' => $name ])->build()->result();
		return count($result) > 0 ? $result[0]['id'] : 0;
	}

	public function HasTest($name)
	{
		$result = $this->database->select("id")->from(TESTSTABLE)->where([ 'name' => $name ])->build()->result();
		return count($result) > 0 ? $result[0]['id'] : 0;
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