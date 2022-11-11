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
	
	$required = !empty($field_data["required"]) ? " form_builder_required" : "";
	
	if (empty($default["country"])) {
		if (empty($default)) {
			$default = [];
		}

		$default["country"] = "United States";
	}
	
	$section_token = "section-".BigTreeCMS::urlify($field_data["label"]);
?>
<fieldset class="form_builder_address" id="<?=$field_name?>">
	<legend for="form_builder_field_<?=$count?>">
		<?=htmlspecialchars($field_data["label"])?>
		<?php if ($required) { ?>
		<span class="form_builder_required_star">*</span>
		<?php } ?>
	</legend>
	
	<div class="form_builder_full">
		<input type="text" name="<?=$field_name?>[street]" id="form_builder_field_<?=$count?>"
			   class="form_builder_text<?=$required?><?php if ($error && empty($default["street"])) { ?> form_builder_error<?php } ?>"
			   value="<?=htmlspecialchars($default["street"] ?? "")?>"
			   autocomplete="<?=$section_token?> address-line1"<?php if ($required) { ?> required<?php } ?>>
		<label for="form_builder_field_<?=($count++)?>" class="form_builder_sublabel">Street Address</label>
	</div>
	
	<div class="form_builder_full">
		<input type="text" name="<?=$field_name?>[street2]" id="form_builder_field_<?=$count?>"
			   class="form_builder_text" value="<?=htmlspecialchars($default["street2"] ?? "")?>"
			   autocomplete="<?=$section_token?> address-line2">
		<label for="form_builder_field_<?=($count++)?>" class="form_builder_sublabel">Street Address Line 2</label>
	</div>
	
	<div class="form_builder_split">
		<input type="text" name="<?=$field_name?>[city]" id="form_builder_field_<?=$count?>"
			   class="form_builder_text<?=$required?><?php if ($error && empty($default["city"])) { ?> form_builder_error<?php } ?>"
			   value="<?=htmlspecialchars($default["city"] ?? "")?>"
			   autocomplete="<?=$section_token?> address-level2"<?php if ($required) { ?> required<?php } ?>>
		<label for="form_builder_field_<?=($count++)?>" class="form_builder_sublabel">City</label>
	</div>
	
	<div class="form_builder_split form_builder_split_last_col">
		<?php if (!empty($field_data["state_list"])) { ?>
		<select <?php if (!empty($field_data["required"])) { ?> class="form_builder_required<?php if ($error && empty($default["state"])) { ?> form_builder_error<?php } ?>"<?php } ?>
			name="<?=$field_name?>[state]" id="form_builder_field_<?=$count?>">
			<option value=""></option>
			<?php foreach (BigTree::$StateList as $state_code => $state_name) { ?>
				<option value="<?=htmlspecialchars($state_code)?>"<?php if (!empty($default["state"]) && $state_code == $default["state"]) { ?> selected="selected"<?php } ?>><?=htmlspecialchars($state_name)?></option>
			<?php } ?>
		</select>
		<?php } else { ?>
		<input type="text" name="<?=$field_name?>[state]" id="form_builder_field_<?=$count?>"
			   class="form_builder_text<?=$required?><?php if ($error && empty($default["state"])) { ?> form_builder_error<?php } ?>"
			   value="<?=htmlspecialchars($default["state"] ?? "")?>"
			   autocomplete="<?=$section_token?> address-level1"<?php if ($required) { ?> required<?php } ?>>
		<?php } ?>
		<label for="form_builder_field_<?=($count++)?>" class="form_builder_sublabel">State / Province / Region</label>
	</div>
	
	<div class="form_builder_split form_builder_split_last_row">
		<input type="text" name="<?=$field_name?>[zip]" id="form_builder_field_<?=$count?>"
			   class="form_builder_text<?=$required?><?php if ($error && empty($default["zip"])) { ?> form_builder_error<?php } ?>"
			   value="<?=htmlspecialchars($default["zip"] ?? "")?>"
			   autocomplete="<?=$section_token?> postal-code"<?php if ($required) { ?> required<?php } ?>>
		<label for="form_builder_field_<?=($count++)?>" class="form_builder_sublabel">Postal / Zip Code</label>
	</div>
	
	<div class="form_builder_split form_builder_split_last_row form_builder_split_last_col">
		<?php if (!empty($field_data["country_list"])) { ?>
		<select <?php if (!empty($field_data["required"])) { ?> class="form_builder_required<?php if ($error && empty($default["country"])) { ?> form_builder_error<?php } ?>"<?php } ?>
			name="<?=$field_name?>[country]" id="form_builder_field_<?=$count?>">
			<?php foreach (BigTree::$CountryList as $item) { ?>
			<option value="<?=htmlspecialchars($item)?>"<?php if (!empty($default["country"]) && $item == $default["country"]) { ?> selected="selected"<?php } ?>><?=htmlspecialchars($item)?></option>
			<?php } ?>
		</select>
		<?php } else { ?>
		<input type="text" name="<?=$field_name?>[country]" id="form_builder_field_<?=$count?>"
			   class="form_builder_text<?=$required?><?php if ($error && empty($default["country"])) { ?> form_builder_error<?php } ?>"
			   value="<?=htmlspecialchars($default["country"] ?? "")?>"
			   autocomplete="<?=$section_token?> country-name"<?php if ($required) { ?> required<?php } ?>>
		<?php } ?>
		<label for="form_builder_field_<?=$count?>" class="form_builder_sublabel">Country</label>
	</div>
</fieldset>
