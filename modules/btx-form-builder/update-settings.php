<?
	$admin->requireLevel(2);
	
	$settings["accept_payments"] = $_POST["accept_payments"];
	$settings["recaptcha"] = $_POST["recaptcha"];
	$admin->updateSettingValue("settings",$settings);
	
	$admin->growl("Form Builder","Updated Settings");
	BigTree::redirect(MODULE_ROOT);
?>