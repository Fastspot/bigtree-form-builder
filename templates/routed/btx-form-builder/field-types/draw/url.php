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
	
	$classes = array("form_builder_text", "form_builder_url");
	
	if ($field_data["required"]) {
		$classes[] = "form_builder_required";
	}
	
	if ($error) {
		$classes[] = "form_builder_error";
	}
	
	$section_token = "section-".BigTreeCMS::urlify($field_data["label"]);
?>
<fieldset class="form_builder_fieldset form_builder_fieldset_url">
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
		<input class="<?=implode(" ", $classes)?>" id="form_builder_field_<?=$count?>" type="url" name="<?=$field_name?>" value="<?=htmlspecialchars($default)?>" autocomplete="<?=$section_token?> url" />
	</div>
</fieldset>
