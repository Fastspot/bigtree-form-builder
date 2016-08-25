<?php
	$admin->requireLevel(2);
	
	$settings["accept_payments"] = !empty($_POST["accept_payments"]) ? "on" : "";
	$settings["no_css"] = !empty($_POST["no_css"]) ? "on" : "";
	$settings["recaptcha"] = $_POST["recaptcha"];

	$admin->updateSettingValue("settings",$settings);
	$admin->growl("Form Builder","Updated Settings");

	BigTree::redirect(MODULE_ROOT);
