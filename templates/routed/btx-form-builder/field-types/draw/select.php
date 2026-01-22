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

	$classes = [];
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
		<div class="form_builder_select">
			<select id="form_builder_field_<?=$count?>"
					name="<?=$field_name?>"<?php if (count($classes)) { ?> class="<?=implode(" ", $classes)?>"<?php } ?> <?=implode(" ", $input_attributes)?>>
				<?php foreach ($field_data["list"] as $item) { ?>
				<option
					value="<?=htmlspecialchars($item["value"])?>"
					<?php if ($item["value"] == $default || ($default === false && !empty($item["selected"]))) { ?> selected="selected"<?php } ?>
					data-price="<?=floatval(str_replace(['$', ','], '', $item["price"] ?? 0))?>">
					<?=htmlspecialchars($item["description"] ?? "")?>
				</option>
				<?php } ?>
			</select>
		</div>
	</fieldset>
<?php
	// If this is a paid form, we watch the element for changes to calculate the total
	if ($form["paid"]) {
		$select_watch[] = "form_builder_field_$count";
	}
?>