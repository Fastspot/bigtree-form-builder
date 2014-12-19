<?
	if (!$d["label"]) {
		$d["label"] = "Phone";
	}
	
	$value = $_POST[$field_name]["first"]."-".$_POST[$field_name]["second"]."-".$_POST[$field_name]["third"];

	$email .= $d["label"]."\n";
	$email .= str_repeat("-",strlen($d["label"]))."\n";
	$email .= $value;
	$email .= "\n\n";
	
	if ($d["required"] && (strlen($_POST[$field_name]["first"]) != 3 || strlen($_POST[$field_name]["second"]) != 3 || strlen($_POST[$field_name]["third"]) != 4 || !is_numeric($_POST[$field_name]["first"]) || !is_numeric($_POST[$field_name]["second"]) || !is_numeric($_POST[$field_name]["third"]))) {
		$errors[] = $field_name;
	}	
?>