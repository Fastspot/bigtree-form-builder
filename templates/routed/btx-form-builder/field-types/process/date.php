<?php
	/**
	 * @global string $email_body
	 * @global array $field_data
	 * @global string $field_name
	 * @global array $form
	 * @global array $settings
	 */
	
	if (empty($field_data["label"])) {
		$field_data["label"] = "Date";
	}
	
	$email_body .= $field_data["label"]."\n";
	$date = $_POST[$field_name] ?? [];
	$month = $date["month"] ?? "";
	$day = $date["day"] ?? "";
	$year = $date["year"] ?? "";
	
	if (checkdate(intval($month), intval($day), intval($year))) {
		$value = $year."-".$month."-".$day;
		$confirmation_email_value = date("F j, Y", strtotime($value));
		$email_body .= $confirmation_email_value;
	}
	
	$email_body .= str_repeat("-", strlen($field_data["label"]))."\n";
	$email_body .= "\n\n";
	
	if (!empty($field_data["required"]) && (!$year || !$month || !$day)) {
		$errors[] = $field_name;
	}
