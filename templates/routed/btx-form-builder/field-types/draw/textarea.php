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
	
	$classes = array();
	
	if ($field_data["required"]) {
		$classes[] = "form_builder_required";
	}
	
	if ($field_data["default"]) {
		$classes[] = "default";
	}
	
	if ($error) {
		$classes[] = "form_builder_error";
	}
?>
<fieldset class="form_builder_fieldset form_builder_fieldset_textarea">
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
		<textarea class="form_builder_textarea <?php if (count($classes)) { ?><?=implode(" ", $classes)?><?php } ?>" id="form_builder_field_<?=$count?>" name="<?=$field_name?>" placeholder="<?=htmlspecialchars($field_data["placeholder"])?>"><?=htmlspecialchars($default)?></textarea>
	</div>
</fieldset>