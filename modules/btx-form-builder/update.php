<?
	BigTree::globalizePOSTVars("htmlspecialchars");
	$form = sqlescape($bigtree["commands"][0]);
	
	// Get cleaned up prices, dates, and entries
	if ($early_bird) {
		$early_bird_date = "'".date("Y-m-d H:i:s",strtotime(str_replace("@","",$_POST["early_bird_date"])))."'";
		$early_bird_base_price = floatval(str_replace(array('$',',',' '),'',$_POST["early_bird_base_price"]));
	} else {
		$early_bird_date = "NULL";
	}
	$base_price = floatval(str_replace(array('$',',',' '),'',$_POST["base_price"]));
	$max_entries = intval($max_entries);

	BigTreeAutoModule::updateItem("btx_form_builder_forms",$form,array(
		"title" => $title,
		"paid" => $paid,
		"base_price" => $base_price,
		"early_bird_base_price" => $early_bird_base_price,
		"early_bird_date" => $early_bird_date,
		"limit_entries" => $limit_entries,
		"max_entries" => $max_entries
	));
	
	// Setup the default column, sort position, alignment inside columns.
	$position = count($_POST["type"]);
	$column = 0;
	$alignment = "";
	
	// Get all the previous fields so we know which to delete.
	$fields_to_delete = array();
	$q = sqlquery("SELECT * FROM btx_form_builder_fields WHERE form = '$form'");
	while ($f = sqlfetch($q)) {
		$fields_to_delete[$f["id"]] = $f["id"];
	}
	
	foreach ($_POST["type"] as $key => $type) {
		$id = $_POST["id"][$key];
		// The field still exists, remove it from the list to delete
		if ($id) {
			unset($fields_to_delete[$id]);
		}
		if ($type == "column_start") {
			// If we're starting a set of columns and don't have an alignment it's a new set.
			if (!$alignment) {
				if (!$id) {
					$column = BigTreeAutoModule::createItem("btx_form_builder_fields",array("form" => $form,"type" => "column","position" => $position));
				} else {
					$column = $id;
					BigTreeAutoModule::updateItem("btx_form_builder_fields",$id,array("position" => $position));
				}
				$alignment = "left";
			// Otherwise we're starting the second column of the set, just change the alignment.
			} elseif ($alignment == "left") {
				$alignment = "right";
			}
		} elseif ($type == "column_end") {
			if ($alignment == "right") {
				$column = 0;
				$alignment = "";
			}
		} elseif ($type) {
			if ($id) {
				BigTreeAutoModule::updateItem("btx_form_builder_fields",$id,array("type" => $type,"data" => $_POST["data"][$key],"position" => $position,"column" => $column,"alignment" => $alignment));
			} else {
				BigTreeAutoModule::createItem("btx_form_builder_fields",array("form" => $form,"type" => $type,"data" => $_POST["data"][$key],"position" => $position,"column" => $column,"alignment" => $alignment));
			}
		}
		$position--;
	}

	// Delete fields that no longer exist in the form
	foreach ($fields_to_delete as $id) {
		BigTreeAutoModule::deleteItem("btx_form_builder_fields",$id);
	}
	
	$admin->growl("Form Builder","Updated Form");
	BigTree::redirect(MODULE_ROOT);
?>