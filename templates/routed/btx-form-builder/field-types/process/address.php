<?
	if (!$d["label"]) {
		$d["label"] = "Address";
	}
	
	$value = $_POST[$field_name];

	$email .= $d["label"]."\n";
	$email .= str_repeat("-",strlen($d["label"]))."\n";
	$email .= $value["street"]."\n";
	if ($value["street2"]) {
		$email .= $value["street2"]."\n";
	}
	$email .= $value["city"].", ".$value["state"]." ".$value["zip"]."\n";
	$email .= $value["country"];
	$email .= "\n\n";
	
	if ($d["required"] && (!$value["street"] || !$value["city"] || !$value["state"] || !$value["zip"] || !$value["country"])) {
		$errors[] = $field_name;
	}
?>