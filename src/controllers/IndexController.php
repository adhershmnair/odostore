<?php
class IndexController extends Controller{
	public function indexAction(){
		$userModel = new UserModel("user");
		$users = $userModel->getUsers();
		print_r($users);
		include  CURRENT_VIEW . "index.php";
	}
}