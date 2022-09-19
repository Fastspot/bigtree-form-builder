<?php
	/**
	 * @global BigTreeAdmin $admin
	 */
	
	if (method_exists($admin, "verifyCSRFToken")) {
		$admin->verifyCSRFToken();
	}
	
	// Create the form.
	$form = BigTreeAutoModule::createItem("btx_form_builder_forms", [
		"title" => BigTree::safeEncode($_POST["title"]),
		"paid" => $_POST["paid"] ? "on" : "",
		"base_price" => floatval(str_replace(['$', ',', ' '], '', $_POST["base_price"])),
		"early_bird_base_price" => floatval(str_replace(['$', ',', ' '], '', $_POST["early_bird_base_price"])),
		"early_bird_date" => !empty($_POST["early_bird"]) ? $admin->convertTimestampFromUser($_POST["early_bird"]) : null,
		"limit_entries" => !empty($_POST["limit_entries"]) ? "on" : "",
		"max_entries" => intval($_POST["max_entries"]),
		"scheduling" => !empty($_POST["scheduling"]) ? "on" : "",
		"scheduling_open_date" => !empty($_POST["scheduling_open_date"]) ? $admin->convertTimestampFromUser($_POST["scheduling_open_date"]) : null,
		"scheduling_close_date" => !empty($_POST["scheduling_close_date"]) ? $admin->convertTimestampFromUser($_POST["scheduling_close_date"]) : null,
		"scheduling_before_message" => $_POST["scheduling_before_message"],
		"scheduling_after_message" => $_POST["scheduling_after_message"],
	]);
	
	// Setup the default column, sort position, alignment inside columns.
	$position = count($_POST["type"]);
	$column = 0;
	$alignment = "";
	
	foreach ($_POST["type"] as $key => $type) {
		if ($type == "column_start") {
			// If we're starting a set of columns and don't have an alignment it's a new set.
			if (!$alignment) {
				$column = BigTreeAutoModule::createItem("btx_form_builder_fields", [
					"form" => $form,
					"type" => "column",
					"position" => $position,
				]);
				$alignment = "left";
			// Otherwise we're starting the second column of the set, just change the alignment.
			} elseif ($alignment == "left") {
				$alignment = "right";
			}
		} elseif ($type == "column_end") {
			if ($alignment == "right") {
				$column = 0;
				$alignment = "";
			}
		} elseif ($type) {
			BigTreeAutoModule::createItem("btx_form_builder_fields", [
				"form" => $form,
				"column" => $column,
				"alignment" => $alignment,
				"type" => $type,
				"data" => $_POST["data"][$key],
				"position" => $position,
			]);
		}
		
		$position--;
	}
	
	$admin->growl("Form Builder", "Created Form");
	BigTree::redirect(MODULE_ROOT);
