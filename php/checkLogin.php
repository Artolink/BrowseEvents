<?php
require_once('./DBHandler.php');

class checkLoginResponse
{
	public $result = false;
}

$DBHandler = new DBHandler();
$checkLoginResponse = new checkLoginResponse();

if (isset($_POST['user']) && isset($_POST['pwd'])) {
	$username = $_POST['user'];
	$password = md5($_POST['pwd']);

	$sql = "SELECT Username, Password, UserType_idUserType FROM user WHERE (Username = '$username' OR Email = '$username') AND Password = '$password'";
	$result = $DBHandler->select($sql);

	if ($result) {
		$counts = array_map('count', $result);
		if (count($counts) == 1) {
			setcookie("logged", $username, time() + (86400 * 2), "/");
			setcookie("typeaccount", $result[0]["UserType_idUserType"], time() + (86400 * 2), "/");
			$checkLoginResponse->result = true;
		}
	} else {
		$checkLoginResponse->result = false;
	}
}

echo json_encode($checkLoginResponse);
