<?
	$email .= $d["label"]."\n";
	$email .= str_repeat("-",strlen($d["label"]))."\n";

	if ($_FILES[$field_name]["tmp_name"]) {
		if ($d["directory"]) {
			$directory = rtrim($d["directory"],"/")."/";
		} else {
			$directory = "files/form-builder/";
		}
		$value = $storage->store($_FILES[$field_name]["tmp_name"],$_FILES[$field_name]["name"],$directory);
		$email .= $cms->replaceRelativeRoots($value);
	} else {
		$email .= "No File Uploaded";
		if ($d["required"]) {
			$errors[] = $field_name;
		}
		$value = "";
	}
	$email .= "\n\n";
?>