<?
	if (!$d["label"]) {
		$d["label"] = "Date";
	}
	
	$value = $_POST[$field_name]["year"]."-".$_POST[$field_name]["month"]."-".$_POST[$field_name]["day"];
	
	$email .= $d["label"]."\n";
	$email .= str_repeat("-",strlen($d["label"]))."\n";
	$email .= date("F j, Y",strtotime($value));
	$email .= "\n\n";
		
	if ($d["required"] && (!$_POST[$field_name]["year"] || !$_POST[$field_name]["month"] || !$_POST[$field_name]["day"])) {
		$errors[] = $field_name;
	}
?>