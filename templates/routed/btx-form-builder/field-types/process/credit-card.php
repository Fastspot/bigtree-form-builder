<?
	$cc = $_POST[$field_name];
	if ($cc["number"] && $cc["month"] && $cc["year"] && $cc["code"]) {
		$value = substr(trim($cc["number"]),-4,4);
	}
?>