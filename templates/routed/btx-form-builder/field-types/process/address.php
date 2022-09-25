<?php
	/**
	 * @global string $email_body
	 * @global array $field_data
	 * @global string $field_name
	 * @global array $form
	 * @global array $settings
	 */
	
	$label = !empty($field_data["label"]) ? $field_data["label"] : "Address";
	$value = $_POST[$field_name] ?? [];
	$street = $value["street"] ?? "";
	$street2 = $value["street2"] ?? "";
	$city = $value["city"] ?? "";
	$state = $value["state"] ?? "";
	$zip = $value["zip"] ?? "";
	$country = $value["country"] ?? "";
	
	// Build out the notification email
	$email_body .= $label."\n";
	$email_body .= str_repeat("-", strlen($label))."\n";
	$email_body .= $street."\n";
	
	if ($street2 != "") {
		$email_body .= $street2."\n";
	}
	
	$email_body .= $city.", ".$state." ".$zip."\n";
	$email_body .= $country;
	$email_body .= "\n\n";
	
	// Build out the confirmation email value
	$confirmation_email_value = $street;
	
	if ($street2 != "") {
		$confirmation_email_value .= ", ".$street2;
	}
	
	if ($city != "") {
		$confirmation_email_value .= ", ".$city;
	}
	
	if ($state != "" || $zip != "") {
		$confirmation_email_value .= ", ".trim($state." ".$zip);
	}
	
	if ($country != "") {
		$confirmation_email_value .= ", ".$country;
	}
	
	if (!empty($field_data["required"]) && (!$street || !$city || !$state || !$zip || !$country)) {
		$errors[] = $field_name;
	}
