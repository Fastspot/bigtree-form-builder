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
<fieldset class="form_builder_fieldset form_builder_fieldset_date">
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

	<div class="form_builder_row form_builder_row_inline">
		<div class="form_builder_item form_builder_item_date_2">
			<input class="form_builder_text<?php if ($field_data["required"]) { ?> form_builder_required<?php if ($error && !$default["month"]) { ?> form_builder_error<?php } ?><?php } ?>" id="form_builder_field_<?=$count?>" type="text" maxlength="2" name="<?=$field_name?>[month]" value="<?=htmlspecialchars($default["month"])?>" />
			<label class="form_builder_sublabel form_builder_sublabel_centered" for="form_builder_field_<?=($count++)?>">MM</label>
		</div>

		<div class="form_builder_item form_builder_item_date_2">
			<input class="form_builder_text<?php if ($field_data["required"]) { ?> form_builder_required<?php if ($error && !$default["day"]) { ?> form_builder_error<?php } ?><?php } ?>" id="form_builder_field_<?=$count?>" type="text" maxlength="2" name="<?=$field_name?>[day]" value="<?=htmlspecialchars($default["day"])?>" />
			<label class="form_builder_sublabel form_builder_sublabel_centered" for="form_builder_field_<?=($count++)?>">DD</label>
		</div>
		
		<div class="form_builder_item form_builder_item_date_4">
			<input class="form_builder_text<?php if ($field_data["required"]) { ?> form_builder_required<?php if ($error && !$default["year"]) { ?> form_builder_error<?php } ?><?php } ?>" id="form_builder_field_<?=$count?>" type="text" maxlength="4" name="<?=$field_name?>[year]" value="<?=htmlspecialchars($default["year"])?>" />
			<label class="form_builder_sublabel form_builder_sublabel_centered" for="form_builder_field_<?=$count?>">YYYY</label>
		</div>
	</div>
</fieldset>