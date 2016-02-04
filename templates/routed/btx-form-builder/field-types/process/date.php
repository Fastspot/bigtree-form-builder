<?
	if (!$d["label"]) {
		$d["label"] = "Date";
	}
	
	$email .= $d["label"]."\n";
	
	if(checkdate($_POST[$field_name]["month"], $_POST[$field_name]["day"], $_POST[$field_name]["year"])){
		$value = $_POST[$field_name]["year"]."-".$_POST[$field_name]["month"]."-".$_POST[$field_name]["day"];
		$email .= date("F j, Y",strtotime($value));	
	}
	
	$email .= str_repeat("-",strlen($d["label"]))."\n";
	$email .= "\n\n";
		
	if ($d["required"] && (!$_POST[$field_name]["year"] || !$_POST[$field_name]["month"] || !$_POST[$field_name]["day"])) {
		$errors[] = $field_name;
	}
?>
