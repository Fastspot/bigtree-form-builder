<?php
	/**
	 * @global string $email_body
	 * @global array $field_data
	 * @global string $field_name
	 * @global array $form
	 * @global array $settings
	 * @global float $total
	 */
	
	if (!empty($field_data["label"])) {
		$email_body .= $field_data["label"]."\n";
		$email_body .= str_repeat("-", strlen($field_data["label"]))."\n";
	}
	
	$value = $_POST[$field_name] ?? [];
	$confirmation_email_value = [];
	$something_was_checked = false;
	
	if (is_array($value)) {
		foreach ($field_data["list"] as $item) {
			$item_value = $item["value"] ?? "";
			$item_description = $item["description"] ?? "";
			$v = ($item_value !== "") ? $item_value : $item_description;
			
			if (in_array($v, $value)) {
				if ($v == $item_description) {
					$email_body .= $item_description.": Yes\n";
				} else {
					$email_body .= $item_description.": ".$item["value"]."\n";
				}
				
				$confirmation_email_value[] = $item_description;
				$something_was_checked = true;
				$total += floatval(str_replace(['$', ','], '', $item["price"] ?? 0));
			} else {
				$email_body .= $item["description"].": ---\n";
			}
		}
		
		$email_body .= "\n\n";
	} else {
		foreach ($field_data["list"] as $item) {
			$item_value = $item["value"] ?? "";
			$item_description = $item["description"] ?? "";
			$v = ($item_value !== "") ? $item_value : $item_description;
			
			if ($value == $v) {
				if ($v == $item_description) {
					$email_body .= $item_description.": Yes\n";
				} else {
					$email_body .= $item_description.": ".$item_value."\n";
				}
				
				$something_was_checked = true;
				$confirmation_email_value[] = $item_description;
				$total += floatval(str_replace(['$', ','], '', $item["price"] ?? 0));
			}
		}
	}
	
	if (!empty($field_data["required"]) && !$something_was_checked) {
		$errors[] = $field_name;
	}
	
	$confirmation_email_value = implode(", ", $confirmation_email_value);
	