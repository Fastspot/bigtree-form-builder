<?
	$storage = new BigTreeStorage;
	$total = 0;
	$email = "";
	$errors = $entry = array();
	
	// Start up the running total if we're paid.
	if ($form["paid"]) {
		if ($form["early_bird_date"] && strtotime($form["early_bird_date"]) > time()) {
		   $total = $form["early_bird_base_price"] ? $form["early_bird_base_price"] : $form["base_price"];			
		} else {
		   $total = $form["base_price"] ? $form["base_price"] : 0;
		}
	}
	
	// Walk through each form field, see if it's required.  If it is and there was no entry, add an error, otherwise add the entry data.
	foreach ($form["fields"] as $field) {
		$t = $field["type"];
		$d = json_decode($field["data"],true);
		
		// If it's not a column, just process it.
		if ($t != "column") {
			if ($d["name"]) {
				$field_name = $d["name"];
			} else {
				$field_name = "data_".$field["id"];
			}

			$value = false;
			include "field-types/process/$t.php";
			if ($value !== false && $field["id"]) {
				$entry[$field["id"]] = $value;
			}

			if ($d["required"] && !$value) {
				$errors[] = $field_name;
			}
		// If it is a column, we need to process everything inside the column first.
		} else {
			foreach ($field["fields"] as $subfield) {
				$d = json_decode($subfield["data"],true);
				
				if ($d["name"]) {
					$field_name = $d["name"];	
				} else {
					$field_name = "data_".$subfield["id"];
				}

				$value = false;
				include "field-types/process/".$subfield["type"].".php";
				if ($value !== false) {
					$entry[$subfield["id"]] = $value;
				}

				if ($d["required"] && !$value) {
					$errors[] = $field_name;
				}
			}
		}
	}
	
	// If we had errors, redirect back with the saved data and errors.
	if (count($errors)) {
		unset($_POST["fb_cc_card"]["number"]);
		unset($_POST["fb_cc_card"]["code"]);
		$_SESSION["form_builder"]["fields"] = $_POST;
		$_SESSION["form_builder"]["errors"] = $errors;
		BigTree::redirect($page_link);
	}
	
	// If it's paid, let's try to charge them.
	if ($form["paid"]) {
		$pg = new BigTreePaymentGateway;
		$transaction = $pg->charge(round($total,2),0,implode(" ",$_POST["fb_cc_billing_name"]),$_POST["fb_cc_card"]["number"],$_POST["fb_cc_card"]["month"].$_POST["fb_cc_card"]["year"],$_POST["fb_cc_card"]["code"],$_POST["fb_cc_billing_address"],($page_header ? $page_header : $bigtree["page"]["nav_title"]),$_POST["fb_cc_billing_email"]);
		if (!$transaction) {
			unset($_POST["fb_cc_card"]["number"]);
			unset($_POST["fb_cc_card"]["code"]);
			$_SESSION["form_builder"]["fields"] = $_POST;
			$_SESSION["form_builder"]["errors"] = $errors;
			$_SESSION["form_builder"]["payment_error"] = $pg->Message;
			BigTree::redirect($page_link);
		}
		
		// Save Billing Info to the DB.
		$_POST["fb_cc_card"]["number"] = $pg->Last4CC;
		$entry["payment"] = array(
			"name" => $_POST["fb_cc_billing_name"],
			"address" => $_POST["fb_cc_billing_address"],
			"card" => $_POST["fb_cc_card"]
		);
		
		// Add Billing Info to the Email
		$address = $_POST["fb_cc_billing_address"];
		$card = $_POST["fb_cc_card"];
		$email .= "Billing Address:\n";
		$email .= implode(" ",$_POST["fb_cc_billing_name"])."\n";
		$email .= $address["street"]."\n";
		if ($address["street2"]) {
			$email .= $address["street2"]."\n";
		}
		$email .= $address["city"].", ".$address["state"]." ".$address["zip"]."\n";
		$email .= $address["country"];		
		$email .= "\n\n";
		
		$email .= "Credit Card Info:\n";
		$email .= $card["type"]."\n";
		$email .= "**** **** **** ".$pg->Last4CC."\n";
		$email .= "Expires ".$card["month"]."/".$card["year"];
		$email .= "\n\n";
		
		$email .= "Total Charged: $".number_format($total,2);
	}

	// Get rid of saved data or errors.	
	unset($_SESSION["form_builder"]);

	// Add the entry to the entries table.
	BigTreeAutoModule::createItem("btx_form_builder_entries",array("form" => $form["id"],"data" => $entry,"created_at" => "NOW()"));
	
	// Update the totals for the form and recache it.
	sqlquery("UPDATE btx_form_builder_forms SET entries = (entries + 1), last_entry = NOW(), total_collected = (total_collected + ".round($total,2).") WHERE id = '".$form["id"]."'");	
	BigTreeAutoModule::recacheItem($form["id"],"btx_form_builder_forms");

	// Get the no-reply domain
	$no_reply_domain = str_replace(array("http://www.","https://www.","http://","https://"),"",DOMAIN);
	$email_title = $page_header ? $page_header : $bigtree["page"]["nav_title"];

	$email = $email_title.' - Form Submission
'.str_repeat("=",strlen($email_title)).'==================

'.$email;

	// Send out email alerts
	$emails = explode(",",$emails);
	foreach ($emails as $e) {
		$e = trim($e);
		mail($e,$email_title." - Form Submission",$email,"From: no-reply@$no_reply_domain");
	}
	
	BigTree::redirect($page_link."thanks/");
?>