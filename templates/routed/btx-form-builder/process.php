<?php
	/**
	 * @global array $bigtree
	 * @global string $emails
	 * @global string $email_field
	 * @global string $email_subject
	 * @global string $email_template
	 * @global array $form
	 * @global string $page_link
	 */
	
	$storage = new BigTreeStorage;
	$total = 0;
	$email_body = "";
	$errors = $entry = $confirmation_email_tokens = $duplicate_labels = [];
	$form_closed = false;
	
	// Check to make sure this form didn't close or reach max entries while being filled out
	if (!empty($form["scheduling"])) {
		if (!empty($form["scheduling_open_date"]) && strtotime($form["scheduling_open_date"]) > time()) {
			$form_closed = true;
		} elseif (!empty($form["scheduling_close_date"]) && strtotime($form["scheduling_close_date"]) < time()) {
			$form_closed = true;
		}
	}
	
	if (!empty($form["limit_entries"]) && $form["entries"] >= $form["max_entries"]) {
		$form_closed = true;
	}
	
	if ($form_closed) {
		BigTree::redirect($page_link);
	}
	
	// Start up the running total if we're paid.
	if (!empty($form["paid"])) {
		if ($form["early_bird_date"] && strtotime($form["early_bird_date"]) > time()) {
			$total = $form["early_bird_base_price"] ?: $form["base_price"];
		} else {
			$total = $form["base_price"] ?: 0;
		}
	}
	
	// Walk through each form field, see if it's required.  If it is and there was no entry, add an error, otherwise add the entry data.
	foreach ($form["fields"] as $field) {
		$field_type = $field["type"];
		$field_data = json_decode($field["data"], true);
		
		// If it's not a column, just process it.
		if ($field_type != "column") {
			$field_name = "form_builder_data_".$field["id"];
			$value = $confirmation_email_value = null;
			
			include "field-types/process/$field_type.php";
			
			if ($value !== null && $field["id"]) {
				$entry[$field["id"]] = $value;
			}
			
			if (!empty($field_data["required"]) && ($value === "" || $value === false || is_null($value))) {
				$errors[] = $field_name;
			}
			
			BTXFormBuilder::parseTokens($confirmation_email_tokens, $field_type,
			                            $field_data["label"], $confirmation_email_value);
			
			// If it is a column, we need to process everything inside the column first.
		} else {
			foreach ($field["fields"] as $subfield) {
				$field_data = json_decode($subfield["data"], true);
				$field_name = "form_builder_data_".$subfield["id"];
				$value = $confirmation_email_value = false;
				
				include "field-types/process/".$subfield["type"].".php";
				
				if ($value !== false) {
					$entry[$subfield["id"]] = $value;
				}
				
				if ($field_data["required"] && ($value === "" || $value === false || is_null($value))) {
					$errors[] = $field_name;
				}
				
				BTXFormBuilder::parseTokens($confirmation_email_tokens, $field_type,
				                            $field_data["label"], $confirmation_email_value);
			}
		}
	}
	
	// If we're disabling duplicate entries, check the hash
	$hash = md5(json_encode($entry).BigTree::remoteIP());
	
	if (!count($errors) && !empty($settings["reject_duplicates"]) && BTXFormBuilder::hashCheck($form["id"], $hash)) {
		$errors[] = "duplicate";
	}
	
	$errors = array_unique($errors);
	
	// If we had errors, redirect back with the saved data and errors.
	if (count($errors)) {
		unset($_POST["form_builder_data_fb_cc_card"]["number"]);
		unset($_POST["form_builder_data_fb_cc_card"]["code"]);
		
		$_SESSION["form_builder"]["fields"] = $_POST;
		$_SESSION["form_builder"]["errors"] = $errors;
		
		BigTree::redirect($page_link);
	}
	
	// If it's paid, let's try to charge them.
	if ($form["paid"]) {
		$pg = new BigTreePaymentGateway;
		
		$transaction = $pg->charge(
			round($total, 2),
			0, // Tax
			implode(" ", $_POST["form_builder_data_fb_cc_billing_name"]),
			$_POST["form_builder_data_fb_cc_card"]["number"],
			$_POST["form_builder_data_fb_cc_card"]["month"].$_POST["form_builder_data_fb_cc_card"]["year"],
			$_POST["form_builder_data_fb_cc_card"]["code"],
			$_POST["form_builder_data_fb_cc_billing_address"],
			(!empty($page_header) ? $page_header : $bigtree["page"]["nav_title"]),  // Transaction Description
			$_POST["form_builder_data_fb_cc_billing_email"]
		);
		
		if (!$transaction) {
			unset($_POST["form_builder_data_fb_cc_card"]["number"]);
			unset($_POST["form_builder_data_fb_cc_card"]["code"]);
			
			$_SESSION["form_builder"]["fields"] = $_POST;
			$_SESSION["form_builder"]["errors"] = $errors;
			$_SESSION["form_builder"]["payment_error"] = $pg->Message;
			
			BigTree::redirect($page_link);
		}
		
		// Save Billing Info to the DB.
		$_POST["form_builder_data_fb_cc_card"]["number"] = $pg->Last4CC;
		$entry["payment"] = [
			"name" => $_POST["form_builder_data_fb_cc_billing_name"],
			"address" => $_POST["form_builder_data_fb_cc_billing_address"],
			"card" => $_POST["form_builder_data_fb_cc_card"]
		];
		
		// Add Billing Info to the Email
		$address = $_POST["form_builder_data_fb_cc_billing_address"];
		$card = $_POST["form_builder_data_fb_cc_card"];
		$email_body .= "Billing Address:\n";
		$email_body .= implode(" ", $_POST["form_builder_data_fb_cc_billing_name"])."\n";
		$email_body .= $address["street"]."\n";
		
		if ($address["street2"]) {
			$email_body .= $address["street2"]."\n";
		}
		
		$email_body .= $address["city"].", ".$address["state"]." ".$address["zip"]."\n";
		$email_body .= $address["country"];
		$email_body .= "\n\n";
		
		$email_body .= "Credit Card Info:\n";
		$email_body .= $card["type"]."\n";
		$email_body .= "**** **** **** ".$pg->Last4CC."\n";
		$email_body .= "Expires ".$card["month"]."/".$card["year"];
		$email_body .= "\n\n";
		
		$email_body .= "Total Charged: $".number_format($total, 2);
	}
	
	// Get rid of saved data or errors.	
	unset($_SESSION["form_builder"]);
	
	// Add the entry to the entries table.
	BigTreeAutoModule::createItem("btx_form_builder_entries", [
		"form" => $form["id"],
		"data" => $entry,
		"hash" => $hash,
		"created_at" => "NOW()",
		"ip" => BigTree::remoteIP()
	]);
	
	// Update the totals for the form and recache it.
	sqlquery("UPDATE btx_form_builder_forms SET entries = (entries + 1), last_entry = NOW(), total_collected = (total_collected + ".round($total, 2).") WHERE id = '".$form["id"]."'");
	BigTreeAutoModule::recacheItem($form["id"], "btx_form_builder_forms");
	
	// Get the no-reply domain
	$no_reply_domain = str_replace(["http://www.", "https://www.", "http://", "https://"], "", DOMAIN);
	$email_title = !empty($page_header) ? $page_header : $bigtree["page"]["nav_title"];
	$email_body = $email_title." - Form Submission\n".str_repeat("=", strlen($email_title))."==================\n\n$email_body";
	
	// Send out email alerts
	$email_array = explode(",", $emails);
	
	foreach ($email_array as $email_address) {
		$email_address = trim($email_address);
		mail($email_address, $email_title." - Form Submission", $email_body, "From: no-reply@$no_reply_domain");
	}
	
	// Send out confirmation email
	if (!empty($email_field)) {
		$send_to_email = $confirmation_email_tokens[$email_field];
		$tokens = [];
		
		foreach ($confirmation_email_tokens as $key => $token) {
			$tokens[] = '{'.$key.'}';
		}
		
		$email_template = str_replace($tokens, $confirmation_email_tokens, $email_template);
		mail($send_to_email, $email_subject, $email_template, "From: no-reply@$no_reply_domain");
	}
	
	BigTree::redirect($page_link."thanks/");
