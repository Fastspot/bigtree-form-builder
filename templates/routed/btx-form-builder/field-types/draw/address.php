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

	$required = $field_data["required"] ? " form_builder_required" : "";

	if (!$default["country"]) {
		$default["country"] = "United States";
	}

	$section_token = "section-".BigTreeCMS::urlify($field_data["label"]);
?>
<fieldset class="form_builder_fieldset form_builder_fieldset_address">
	<legend class="form_builder_legend" for="form_builder_field_<?=$count?>">
		<?=htmlspecialchars($field_data["label"])?>
		<?php if ($field_data["required"]) { ?>
		<span class="form_builder_required_star">*</span>
		<?php } ?>
	</legend>

	<div class="form_builder_item">
		<input class="form_builder_text<?=$required?><?php if ($error && !$default["street"]) { ?> form_builder_error<?php } ?>" id="form_builder_field_<?=$count?>" value="<?=htmlspecialchars($default["street"])?>" type="text" name="<?=$field_name?>[street]" autocomplete="<?=$section_token?> address-line1" />
		<label class="form_builder_sublabel" for="form_builder_field_<?=($count++)?>">Street Address</label>
	</div>

	<div class="form_builder_item">
		<input class="form_builder_text" id="form_builder_field_<?=$count?>" type="text" name="<?=$field_name?>[street2]" value="<?=htmlspecialchars($default["street2"])?>" autocomplete="<?=$section_token?> address-line2" />
		<label class="form_builder_sublabel" for="form_builder_field_<?=($count++)?>">Street Address Line 2</label>
	</div>

	<div class="form_builder_row form_builder_row_split">
		<div class="form_builder_item">
			<input class="form_builder_text<?=$required?><?php if ($error && !$default["city"]) { ?> form_builder_error<?php } ?>" id="form_builder_field_<?=$count?>" type="text" name="<?=$field_name?>[city]" value="<?=htmlspecialchars($default["city"])?>" autocomplete="<?=$section_token?> address-level2" />
			<label class="form_builder_sublabel" for="form_builder_field_<?=($count++)?>">City</label>
		</div>

		<div class="form_builder_item">
			<?php if ($field_data["state_list"]) { ?>
			<select class="form_builder_select<?php if ($field_data["required"]) { ?> form_builder_required<?php if ($error) { ?> form_builder_error<?php } } ?>" id="form_builder_field_<?=$count?>" name="<?=$field_name?>[state]">
				<option value=""></option>
				<?php foreach (BigTree::$StateList as $state_code => $state_name) { ?>
				<option value="<?=htmlspecialchars($state_code)?>"<?php if ($state_code == $default["state"]) { ?> selected="selected"<?php } ?>><?=htmlspecialchars($state_name)?></option>
				<?php } ?>
			</select>
			<?php } else { ?>
			<input class="form_builder_text<?=$required?><?php if ($error && !$default["state"]) { ?> form_builder_error<?php } ?>" id="form_builder_field_<?=$count?>" type="text" name="<?=$field_name?>[state]" value="<?=htmlspecialchars($default["state"])?>" autocomplete="<?=$section_token?> address-level1" />
			<?php } ?>
			<label class="form_builder_sublabel" for="form_builder_field_<?=($count++)?>">State / Province / Region</label>
		</div>
	</div>

	<div class="form_builder_row form_builder_row_split">
		<div class="form_builder_item">
			<input class="form_builder_text<?=$required?><?php if ($error && !$default["zip"]) { ?> form_builder_error<?php } ?>" id="form_builder_field_<?=$count?>" type="text" name="<?=$field_name?>[zip]" value="<?=htmlspecialchars($default["zip"])?>" autocomplete="<?=$section_token?> postal-code" />
			<label class="form_builder_sublabel" for="form_builder_field_<?=($count++)?>">Postal / Zip Code</label>
		</div>

		<div class="form_builder_item">
			<?php if ($field_data["country_list"]) { ?>
			<select class="form_build_select<?php if ($field_data["required"]) { ?> form_builder_required<?php if ($error) { ?> form_builder_error<?php } } ?>" id="form_builder_field_<?=$count?>" name="<?=$field_name?>[country]">
				<?php foreach (BigTree::$CountryList as $item) { ?>
				<option value="<?=htmlspecialchars($item)?>"<?php if ($item == $default["country"]) { ?> selected="selected"<?php } ?>><?=htmlspecialchars($item)?></option>
				<?php } ?>
			</select>
			<?php } else { ?>
			<input class="form_builder_text<?=$required?><?php if ($error && !$default["country"]) { ?> form_builder_error<?php } ?>" id="form_builder_field_<?=$count?>" type="text" name="<?=$field_name?>[country]" value="<?=htmlspecialchars($default["country"])?>" autocomplete="<?=$section_token?> country-name" />
			<?php } ?>
			<label class="form_builder_sublabel" for="form_builder_field_<?=$count?>">Country</label>
		</div>
	</div>
</fieldset>
