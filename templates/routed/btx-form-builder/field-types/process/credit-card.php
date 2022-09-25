<?php
	/**
	 * @global array $field_data
	 * @global string $field_name
	 * @global array $form
	 * @global array $settings
	 */
	
	$cc = $_POST[$field_name] ?? [];
	$cc_number = $cc["number"] ?? "";
	$cc_month = $cc["month"] ?? "";
	$cc_year = $cc["year"] ?? "";
	$cc_code = $cc["code"] ?? "";
	
	if ($cc_number !== "" && $cc_month !== "" && $cc_year !== "" && $cc_code !== "") {
		$value = substr(trim($cc_number), -4, 4);
	}
