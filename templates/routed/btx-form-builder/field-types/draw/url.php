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
	
	$classes = ["form_builder_text", "form_builder_url"];
	
	if (!empty($field_data["required"])) {
		$classes[] = "form_builder_required";
	}
	
	if ($error) {
		$classes[] = "form_builder_error";
	}
	
	$section_token = "section-".BigTreeCMS::urlify($field_data["label"] ?? "");
?>
<fieldset id="<?=$field_name?>">
	<label for="form_builder_field_<?=$count?>">
		<?php
			echo htmlspecialchars($field_data["label"]);
			
			if (!empty($field_data["required"])) {
		?>
		<span class="form_builder_required_star">*</span>
		<?php
			}
		?>
	</label>
	<input type="url" id="form_builder_field_<?=$count?>" name="<?=$field_name?>" class="<?=implode(" ", $classes)?>"
		   value="<?=htmlspecialchars($default)?>"
		   autocomplete="<?=$section_token?> url"<?php if (!empty($field_data["required"])) { ?> required<?php } ?>>
</fieldset>
