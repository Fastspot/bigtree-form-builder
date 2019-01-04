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
<fieldset class="form_builder_fieldset form_builder_fieldset_select">
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
		<select class="form_builder_select<?php if ($field_data["required"]) { ?> form_builder_required<?php if ($error) { ?> form_builder_error<?php } } ?>" id="form_builder_field_<?=$count?>" name="<?=$field_name?>">
			<?php foreach ($field_data["list"] as $item) { ?>
			<option value="<?=htmlspecialchars($item["value"])?>"<?php if ($item["value"] == $default || ($default === false && $item["selected"])) { ?> selected="selected"<?php } ?> data-price="<?=floatval(str_replace(array('$', ','), '', $item["price"]))?>"><?=htmlspecialchars($item["description"])?></option>
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