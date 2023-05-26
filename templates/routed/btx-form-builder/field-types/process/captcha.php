<?php
	/**
	 * @global array $field_data
	 * @global string $field_name
	 * @global array $form
	 * @global array $settings
	 */
	
	if (empty($settings["recaptcha"]["version"]) || $settings["recaptcha"]["version"] == "2") {
		$recaptcha_url = "https://www.google.com/recaptcha/api/siteverify".
			"?secret=".$settings["recaptcha"]["secret_key"].
			"&response=".urlencode($_POST["g-recaptcha-response"]).
			"&remoteip=".$_SERVER["REMOTE_ADDR"];
		
		$response = json_decode(BigTree::cURL($recaptcha_url));
		
		if (!$response->success) {
			$errors[] = $field_name;
		}
	} else {
		$response = json_decode(BigTree::cURL("https://www.google.com/recaptcha/api/siteverify", [
			"secret" => $settings["recaptcha"]["secret_key"],
			"response" => $_POST["g-recaptcha-response"],
			"remoteip" => $_SERVER["REMOTE_ADDR"]
		]), true);
		
		if (!$response["success"] || $response["score"] < intval($settings["recaptcha"]["threshold"]) / 100) {
			$errors[] = $field_name;
		}
	}
