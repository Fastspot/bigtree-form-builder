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
	<legend for="form_builder_field_<?=$count?>">
		<?php
			echo htmlspecialchars($field_data["label"] ?? "");
			
			if (!empty($field_data["required"])) {
		?>
		<span class="form_builder_required_star">*</span>
		<?php
			}
		?>
	</legend>
	
	<div class="form_builder_date_2">
		<input type="text" maxlength="2" name="<?=$field_name?>[month]" id="form_builder_field_<?=$count?>"
			   class="form_builder_text<?php if (!empty($field_data["required"])) { ?> form_builder_required<?php if ($error && empty($default["month"])) { ?> form_builder_error<?php } ?><?php } ?>"
			   value="<?=htmlspecialchars($default["month"] ?? "")?>"<?php if (!empty($field_data["required"])) { ?> required<?php } ?>>
		<label for="form_builder_field_<?=($count++)?>" class="form_builder_sublabel form_builder_centered">MM</label>
	</div>
	
	<div class="form_builder_date_2">
		<input type="text" maxlength="2" name="<?=$field_name?>[day]" id="form_builder_field_<?=$count?>"
			   class="form_builder_text<?php if (!empty($field_data["required"])) { ?> form_builder_required<?php if ($error && empty($default["day"])) { ?> form_builder_error<?php } ?><?php } ?>"
			   value="<?=htmlspecialchars($default["day"] ?? "")?>"<?php if (!empty($field_data["required"])) { ?> required<?php } ?>>
		<label for="form_builder_field_<?=($count++)?>" class="form_builder_sublabel form_builder_centered">DD</label>
	</div>
	
	<div class="form_builder_date_4">
		<input type="text" maxlength="4" name="<?=$field_name?>[year]" id="form_builder_field_<?=$count?>"
			   class="form_builder_text<?php if (!empty($field_data["required"])) { ?> form_builder_required<?php if ($error && empty($default["year"])) { ?> form_builder_error<?php } ?><?php } ?>"
			   value="<?=htmlspecialchars($default["year"] ?? "")?>"<?php if (!empty($field_data["required"])) { ?> required<?php } ?>>
		<label for="form_builder_field_<?=$count?>" class="form_builder_sublabel form_builder_centered">YYYY</label>
	</div>
</fieldset>