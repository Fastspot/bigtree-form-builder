<?php
	/**
	 * @global array $field
	 */
	
	$fields = [];
	$form = $_POST["form"] ?? $field["value"]["form"];
	$form = $form ?: $_GET["form"];
	$query = SQL::query("SELECT * FROM btx_form_builder_fields
	                     WHERE form = ?
	                       AND type != 'columns'
	                       AND type != 'section'
	                       AND type != 'captcha'", $form);
	
	// Reset cache
	BTXFormBuilder::parseTokens($fields, false, false, false, true);
	
	while ($row = $query->fetch()) {
		$data = json_decode($row["data"], true);
		BTXFormBuilder::parseTokens($fields, $row["type"], $data["label"] ?? "", $data["name"] ?? "");
	}
	
	ksort($fields);
	$keys = [];
	
	foreach ($fields as $key => $name) {
		$keys[] = '{'.$key.'}';
	}
	
	echo "<strong>Available Tokens: </strong> &nbsp; ";
	echo implode(" &nbsp; ", $keys);
	