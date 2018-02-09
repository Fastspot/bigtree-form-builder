<?php
	/**
	 * @global array $default
	 * @global array $field_data
	 * @global array $form
	 * @global array $settings
	 * @global bool $error
	 * @global int $count
	 * @global string $field_name
	 */
	
	$classes = array("form_builder_upload");
	
	if ($field_data["required"]) {
		$classes[] = "form_builder_required";
	}
	
	if ($error) {
		$classes[] = "form_builder_error";
	}

	if (is_array($field_data["allowed_filetypes"]) && count($field_data["allowed_filetypes"])) {
		$allowed_types = array();
		$accept = array();

		foreach ($field_data["allowed_filetypes"] as $type) {
			$ext = ltrim(trim($type["extension"]), ".");
			$allowed_types[] = $ext;
			$accept[] = ".$ext";
		}
	} else {
		$allowed_types = null;
		$accept = null;
	}
?>
<fieldset>
	<label for="form_builder_field_<?=$count?>">
		<?php
			echo htmlspecialchars($field_data["label"]);
			
			if ($field_data["required"]) {
		?>
		<span class="form_builder_required_star">*</span>
		<?php
			}
		?>
	</label>
	<input type="file" id="form_builder_field_<?=$count?>" name="<?=$field_name?>" <?php if (count($classes)) { ?>class="<?=implode(" ", $classes)?>" <?php } ?>value="<?=htmlspecialchars($field_data["default"])?>" <?php if (!is_null($accept)) { ?> accept="<?=implode(",", $accept)?>"<?php } ?> />
	<?php
		if (!is_null($allowed_types)) {
	?>
	<div class="form_builder_sublabel">Allowed File Types: <?=implode(", ", $allowed_types)?></div>
	<?php
		}
	?>
</fieldset>
