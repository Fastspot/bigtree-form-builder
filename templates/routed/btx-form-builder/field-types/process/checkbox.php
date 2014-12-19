<?
	if ($d["label"]) {
		$email .= $d["label"]."\n";
		$email .= str_repeat("-",strlen($d["label"]))."\n";
	}
	
	$value = $_POST[$field_name];
	$something_was_checked = false;
	
	if (is_array($value)) {
		foreach ($d["list"] as $item) {
			$v = $item["value"] ? $item["value"] : $item["description"];
			if (in_array($v,$value)) {
				if ($v == $item["description"]) {
					$email .= $item["description"].": Yes\n";
				} else {
					$email .= $item["description"].": ".$item["value"]."\n";
				}
				$something_was_checked = true;
				
				$total += $item["price"];
			} else {
				$email .= $item["description"].": ---\n";
			}
		}
		$email .= "\n\n";
	} else {
		foreach ($d["list"] as $item) {
			$v = $item["value"] ? $item["value"] : $item["description"];
			if ($value == $v) {
				if ($v == $item["description"]) {
					$email .= $item["description"].": Yes\n";
				} else {
					$email .= $item["description"].": ".$item["value"]."\n";
				}
				$something_was_checked = true;
				
				$total += $item["price"];
			}
		}
	}
	
	if ($d["required"] && !$something_was_checked) {
		$errors[] = $field_name;
	}
?>