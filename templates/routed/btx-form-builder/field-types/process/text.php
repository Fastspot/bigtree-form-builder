<?	
	$email .= $d["label"]."\n";
	$email .= str_repeat("-",strlen($d["label"]))."\n";
	if ($d["price"] == "on") {
		$value = floatval(str_replace(array("$",","),"",$_POST[$field_name]));
		if ($value < 0) {
			$value = 0;
		}
		$total += $value;
		$email .= "$".number_format($value,2);
	} else {
		$email .= $_POST[$field_name];
		$value = $_POST[$field_name];
	}
	$email .= "\n\n";		
?>