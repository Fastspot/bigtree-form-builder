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
?>
<fieldset id="<?=$field_name?>">
	<?php
		if (!empty($field_data["label"])) {
	?>
	<legend>
		<?php
			echo htmlspecialchars($field_data["label"]);
			
			if (!empty($field_data["required"])) {
		?>
		<span class="form_builder_required_star">*</span>
		<?php
			}
		?>
	</legend>
	<?php
		}
		
		foreach ($field_data["list"] as $item) {
			$value = !empty($item["value"]) ? htmlspecialchars($item["value"]) : htmlspecialchars($item["description"]);
	?>
	<div class="form_builder_checkbox">
		<input type="checkbox" id="form_builder_field_<?=$count?>"
			   name="<?=$field_name?><?php if (count($field_data["list"]) > 1) { ?>[]<?php } ?>"
			   value="<?=$value?>"<?php if ((is_array($default) && in_array($value, $default)) || $default === $value || ($default === false && !empty($item["selected"]))) { ?> checked="checked"<?php } ?>
			   data-price="<?=floatval(str_replace(['$', ','], '', $item["price"] ?? 0))?>">
		<span class="form_builder_checkbox_indicator"></span>
		<label class="form_builder_for_checkbox" for="form_builder_field_<?=$count?>">
			<?=htmlspecialchars($item["description"] ?? "")?>
			<?php if (!empty($field_data["required"]) && empty($field_data["label"])) { ?>
			<span class="form_builder_required_star">*</span>
			<?php } ?>
		</label>
	</div>
	<?php
			// If this is a paid form, we watch the element for changes to calculate the total
			if (!empty($form["paid"])) {
				$check_watch[] = "form_builder_field_$count";
			}
			
			$count++;
		}
	?>
</fieldset>
