<?php
	$bigtree["css"][] = "btx-form-builder.css";
	$bigtree["js"][] = "btx-form-builder.js";
	
	// Create the settings array if it doesn't exist
	if (!$admin->settingExists("settings")) {
		$admin->createSetting(["id" => "settings", "system" => "on", "name" => "Form Builder Settings"]);
	}
	
	$settings = $cms->getSetting("settings") ?: [];
