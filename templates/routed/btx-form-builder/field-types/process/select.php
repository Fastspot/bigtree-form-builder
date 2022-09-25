<?php
	/**
	 * @global array $field_data
	 * @global string $field_name
	 * @global array $form
	 * @global array $settings
	 * @global float $total
	 */
	
	$submitted_value = $_POST[$field_name] ?? "";
	
	foreach ($field_data["list"] as $key => $item) {
		$value = (isset($item["value"]) && $item["value"] !== "") ? $item["value"] : $item["description"];
		
		if ($submitted_value == $value) {
			$total += floatval(str_replace(['$', ','], '', $item["price"] ?? 0));
		}
	}
	
	include "text.php";
