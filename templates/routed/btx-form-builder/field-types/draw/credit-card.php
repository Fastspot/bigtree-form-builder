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
	
	$card_types = array(
		"Visa" => "Visa",
		"MasterCard" => "MasterCard"
	);
?>
<fieldset class="form_builder_fieldset form_builder_fieldset_credit_card">
	<legend class="form_builder_legend" for="form_builder_field_<?=$count?>">
		Credit Card
		<span class="form_builder_required_star">*</span>
	</legend>
	
	<div class="form_builder_row">
		<div class="form_builder_item form_builder_item_card_number">
			<input class="form_builder_text<?php if ($error && !$default["number"]) { ?> form_builder_error"<?php } ?> value="<?=htmlspecialchars($default["number"])?>" type="text" name="<?=$field_name?>[number]" id="form_builder_field_<?=$count?>" autocomplete="off" maxlength="19" />
			<label class="form_builder_sublabel" for="form_builder_field_<?=($count++)?>">Number</label>
		</div>
	</div>
	
	<div class="form_builder_row">
		<div class="form_builder_item form_builder_item_card_date">
			<input class="form_builder_text form_builder_card_month<?php if ($error && !$default["month"]) { ?> form_builder_error<?php } ?>" id="form_builder_field_<?=($count++)?>" type="text" name="<?=$field_name?>[month]" value="<?=htmlspecialchars($default["month"])?>" maxlength="2" />
			<input class="form_builder_text form_builder_card_year<?php if ($error && !$default["year"]) { ?> form_builder_error<?php } ?>" id="form_builder_field_<?=($count++)?>" type="text" name="<?=$field_name?>[year]" value="<?=htmlspecialchars($default["year"])?>" maxlength="4" />
			<label class="form_builder_sublabel" for="form_builder_field_<?=($count - 2)?>">Expiration (MM-YYYY)</label>
		</div>
		
		<div class="form_builder_item form_builder_item_card_code">
			<input class="form_builder_text<?php if ($error && !$default["code"]) { ?> form_builder_error<?php } ?>" id="form_builder_field_<?=$count?>" type="text" name="<?=$field_name?>[code]" maxlength="4" value="<?=htmlspecialchars($default["code"])?>" autocomplete="off" />
			<label class="form_builder_sublabel" for="form_builder_field_<?=($count++)?>">CVV Code</label>
		</div>
	</div>
</fieldset>
<div class="form_builder_section_header form_builder_total_section">
	<h2 class="form_builder_total_section_title">Total</h2>
	<p class="form_builder_total_section_description">Your total charge will be: <span class="form_builder_total" id="form_builder_total">$<?=number_format($form["base_price"], 2)?></span></p>
</div>