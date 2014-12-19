<?
	$response = json_decode(BigTree::cURL("https://www.google.com/recaptcha/api/siteverify?secret=".$settings["recaptcha"]["secret_key"]."&response=".urlencode($_POST["g-recaptcha-response"])."&remoteip=".$_SERVER["REMOTE_ADDR"]));
	if (!$response->success) {
		$errors[] = $field_name;
	}
?>