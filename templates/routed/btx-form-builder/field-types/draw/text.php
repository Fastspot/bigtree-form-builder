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
	
	$classes = ["form_builder_text"];
	$input_attributes = [];
	
	if (!empty($field_data["required"])) {
		$classes[] = "form_builder_required";
		$input_attributes[] = "required";
	}
	
	if ($error) {
		$classes[] = "form_builder_error";
	}
?>
<fieldset id="<?=$field_name?>">
	<label for="form_builder_field_<?=$count?>">
		<?php
			echo htmlspecialchars($field_data["label"] ?? "");
			
			if (!empty($field_data["required"])) {
		?>
		<span class="form_builder_required_star">*</span>
		<?php
			}
		?>
	</label>
	<input type="text" id="form_builder_field_<?=$count?>" name="<?=$field_name?>"
		   class="<?=implode(" ", $classes)?>" value="<?=htmlspecialchars($default)?>"
		   placeholder="<?=htmlspecialchars($field_data["placeholder"] ?? "")?>"
		   <?php if (!empty($field_data["maxlength"]) && intval($field_data["maxlength"])) { ?>maxlength="<?=intval($field_data["maxlength"])?>"<?php } ?>
		   <?=implode(" ", $input_attributes)?>>
</fieldset>
<?php
	if (!empty($form["paid"]) && !empty($field_data["price"]) && $field_data["price"] == "on") {
		$text_watch[] = "form_builder_field_$count";
	}
?>