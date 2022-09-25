<?php
	/**
	 * @global string $email_body
	 * @global array $field_data
	 * @global string $field_name
	 * @global array $form
	 * @global array $settings
	 */
	
	if (empty($field_data["label"])) {
		$field_data["label"] = "Name";
	}
	
	$value = $_POST[$field_name] ?? [];
	$first = $value["first"] ?? "";
	$last = $value["last"] ?? "";
	
	$email_body .= $field_data["label"]."\n";
	$email_body .= str_repeat("-", strlen($field_data["label"]))."\n";
	$email_body .= "First: ".$first."\n";
	$email_body .= "Last: ".$last;
	$email_body .= "\n\n";
	
	$confirmation_email_value = trim($first." ".$last);
	
	if (!empty($field_data["required"]) && (!$first || !$last)) {
		$errors[] = $field_name;
	}
