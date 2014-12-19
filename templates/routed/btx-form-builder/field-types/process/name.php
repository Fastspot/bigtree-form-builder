<?
	if (!$d["label"]) {
		$d["label"] = "Name";
	}
	
	$value = $_POST[$field_name];
	$count++;
	
	$email .= $d["label"]."\n";
	$email .= str_repeat("-",strlen($d["label"]))."\n";
	$email .= "First: ".$value["first"]."\n";
	$email .= "Last: ".$value["last"];
	$email .= "\n\n";
	
	if ($d["required"] && (!$value["first"] || !$value["last"])) {
		$errors[] = $field_name;
	}
?>