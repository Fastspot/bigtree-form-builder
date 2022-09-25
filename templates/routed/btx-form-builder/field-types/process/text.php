<?php
	/**
	 * @global string $email_body
	 * @global array $field_data
	 * @global string $field_name
	 * @global array $form
	 * @global array $settings
	 * @global float $total
	 */
	
	if (empty($field_data["label"])) {
		$field_data["label"] = "";
	}
	
	$submitted_value = $_POST[$field_name] ?? "";
	$email_body .= $field_data["label"]."\n";
	$email_body .= str_repeat("-", strlen($field_data["label"]))."\n";
	
	if ($field_data["price"] == "on") {
		$value = floatval(str_replace(["$", ","], "", $submitted_value));
		
		if ($value < 0) {
			$value = 0;
		}
		
		$total += $value;
		$confirmation_email_value = "$".number_format($value, 2);
		$email_body .= $confirmation_email_value;
	} else {
		$email_body .= $submitted_value;
		$value = $submitted_value;
		$confirmation_email_value = $submitted_value;
	}
	
	$email_body .= "\n\n";
