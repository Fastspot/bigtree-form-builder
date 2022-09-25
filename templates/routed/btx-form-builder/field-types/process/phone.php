<?php
	/**
	 * @global string $email_body
	 * @global array $field_data
	 * @global string $field_name
	 * @global array $form
	 * @global array $settings
	 */
	
	if (empty($field_data["label"])) {
		$field_data["label"] = "Phone";
	}
	
	$phone = $_POST[$field_name] ?? [];
	$first = $phone["first"] ?? "";
	$second = $phone["second"] ?? "";
	$third = $phone["third"] ?? "";
	
	if (empty($field_data["international"])) {
		$value = $first."-".$second."-".$third;
	} else {
		$value = "+".$first." ".$second." ".$third;
	}
	
	$email_body .= $field_data["label"]."\n";
	$email_body .= str_repeat("-", strlen($field_data["label"]))."\n";
	$email_body .= $value;
	$email_body .= "\n\n";
	
	$confirmation_email_value = $value;
	
	if ($field_data["required"] && (strlen($_POST[$field_name]["first"]) != 3 || strlen($_POST[$field_name]["second"]) != 3 || strlen($_POST[$field_name]["third"]) != 4 || !is_numeric($_POST[$field_name]["first"]) || !is_numeric($_POST[$field_name]["second"]) || !is_numeric($_POST[$field_name]["third"]))) {
		$errors[] = $field_name;
	}	
