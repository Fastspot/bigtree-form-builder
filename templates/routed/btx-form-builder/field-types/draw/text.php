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
	
	$classes = array("form_builder_text");
	
	if ($field_data["required"]) {
		$classes[] = "form_builder_required";
	}
	
	if ($error) {
		$classes[] = "form_builder_error";
	}
?>
<fieldset class="form_builder_fieldset form_builder_fieldset_text">
	<label class="form_builder_label" for="form_builder_field_<?=$count?>">
		<?php
			echo htmlspecialchars($field_data["label"]);
			
			if ($field_data["required"]) {
		?>
		<span class="form_builder_required_star">*</span>
		<?php
			}
		?>
	</label>

	<div class="form_builder_item">
		<input class="<?=implode(" ", $classes)?>" id="form_builder_field_<?=$count?>" type="text" name="<?=$field_name?>"  value="<?=htmlspecialchars($default)?>" placeholder="<?=htmlspecialchars($field_data["placeholder"])?>" <?php if (intval($field_data["maxlength"])) { ?>maxlength="<?=intval($field_data["maxlength"])?>" <?php } ?>/>
	</div>
</fieldset>
<?php
	if ($form["paid"] && $field_data["price"] == "on") {
		$text_watch[] = "form_builder_field_$count";
	}
?>