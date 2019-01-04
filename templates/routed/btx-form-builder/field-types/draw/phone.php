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

	if (empty($default["first"]) && !empty($settings["phone_default_country_code"])) {
		$default["first"] = $settings["phone_default_country_code"];
	}
	
	$section_token = "section-".BigTreeCMS::urlify($field_data["label"]);
?>
<fieldset class="form_builder_fieldset form_builder_fieldset_phone">
	<legend class="form_builder_legend" for="form_builder_field_<?=$count?>">
		<?php
			echo htmlspecialchars($field_data["label"]);
			
			if ($field_data["required"]) {
		?>
		<span class="form_builder_required_star">*</span>
		<?php
			}
		?>
	</legend>
	
	<div class="form_builder_row">
		<?php
			if (empty($field_data["international"])) {
		?>
		<div class="form_builder_item form_builder_item_phone_3">
			<input class="form_builder_text<?php if ($field_data["required"]) { ?> form_builder_required<?php if ($error && (strlen($default["first"]) != 3 || !is_numeric($default["first"]))) { ?> form_builder_error<?php } ?><?php } ?>" id="form_builder_field_<?=$count?>" type="text" maxlength="3" name="<?=$field_name?>[first]" value="<?=htmlspecialchars($default["first"])?>" autocomplete="<?=$section_token?> tel-area-code" />
			<label class="form_builder_sublabel form_builder_sublabel_centered" for="form_builder_field_<?=($count++)?>">###</label>
		</div>
		
		<div class="form_builder_item form_builder_item_phone_3">
			<input class="form_builder_text<?php if ($field_data["required"]) { ?> form_builder_required<?php if ($error && (strlen($default["second"]) != 3 || !is_numeric($default["second"]))) { ?> form_builder_error<?php } ?><?php } ?>" id="form_builder_field_<?=$count?>" type="text" maxlength="3" name="<?=$field_name?>[second]" value="<?=htmlspecialchars($default["second"])?>" autocomplete="<?=$section_token?> tel-local-prefix" />
			<label class="form_builder_sublabel form_builder_sublabel_centered" for="form_builder_field_<?=($count++)?>">###</label>
		</div>
		
		<div class="form_builder_item form_builder_item_phone_4">
			<input class="form_builder_text<?php if ($field_data["required"]) { ?> form_builder_required<?php if ($error && (strlen($default["third"]) != 4 || !is_numeric($default["third"]))) { ?> form_builder_error<?php } ?><?php } ?>" id="form_builder_field_<?=$count?>" type="text" maxlength="4" name="<?=$field_name?>[third]" value="<?=htmlspecialchars($default["third"])?>" autocomplete="<?=$section_token?> tel-local-suffix" />
			<label class="form_builder_sublabel form_builder_sublabel_centered" for="form_builder_field_<?=$count?>">####</label>
		</div>
		<?php
			} else {
		?>
		<div class="form_builder_item form_builder_item_phone_country">
			<input class="form_builder_text<?php if ($field_data["required"]) { ?> form_builder_required<?php if ($error && (strlen($default["first"]) != 3 || !is_numeric($default["first"]))) { ?> form_builder_error<?php } ?><?php } ?>" id="form_builder_field_<?=$count?>" type="text" maxlength="3" name="<?=$field_name?>[first]" value="<?=htmlspecialchars($default["first"])?>" autocomplete="<?=$section_token?> tel-country-code" />
			<label class="form_builder_sublabel form_builder_sublabel_centered" for="form_builder_field_<?=($count++)?>">Country Code</label>
		</div>
		
		<div class="form_builder_item form_builder_item_phone_area">
			<input class="form_builder_text<?php if ($field_data["required"]) { ?> form_builder_required<?php if ($error && (strlen($default["second"]) != 3 || !is_numeric($default["second"]))) { ?> form_builder_error<?php } ?><?php } ?>" id="form_builder_field_<?=$count?>" type="text" maxlength="3" name="<?=$field_name?>[second]" value="<?=htmlspecialchars($default["second"])?>" autocomplete="<?=$section_token?> tel-area-code" />
			<label class="form_builder_sublabel form_builder_sublabel_centered" for="form_builder_field_<?=($count++)?>">Area Code</label>
		</div>
		
		<div class="form_builder_item form_builder_item_phone_number">
			<input class="form_builder_text<?php if ($field_data["required"]) { ?> form_builder_required<?php if ($error && (strlen($default["third"]) != 4 || !is_numeric($default["third"]))) { ?> form_builder_error<?php } ?><?php } ?>" id="form_builder_field_<?=$count?>" type="text" maxlength="8" name="<?=$field_name?>[third]" value="<?=htmlspecialchars($default["third"])?>" autocomplete="<?=$section_token?> tel-local" />
			<label class="form_builder_sublabel form_builder_sublabel_centered" for="form_builder_field_<?=$count?>">Phone Number</label>
		</div>
		<?php
			}
		?>
	</div>
</fieldset>