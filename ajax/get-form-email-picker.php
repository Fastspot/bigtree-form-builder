<?php
	/**
	 * @global array $field
	 */
	
	$fields = [];
	$form = $_POST["form"] ?? $field["value"]["form"];
	$query = SQL::query("SELECT * FROM btx_form_builder_fields WHERE form = ? AND type = 'email'", $form);
	
	// Reset cache
	BTXFormBuilder::parseTokens($fields, false, false, false, true);
	
	while ($row = $query->fetch()) {
		$data = json_decode($row["data"], true);
		BTXFormBuilder::parseTokens($fields, $row["type"], $data["label"] ?? "", $data["name"] ?? "");
	}
	
	ksort($fields);
?>
<option></option>
<?php
	foreach ($fields as $key => $name) {
?>
<option<?php if (!empty($field["value"]["email_field"]) && $key == $field["value"]["email_field"]) { ?> selected="selected"<?php } ?>><?=$key?></option>
<?php
	}
	
	if (!count($fields)) {
?>
<option value="" disabled="disabled">No Email Fields Found</option>
<?php
	}
