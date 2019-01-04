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
	
	$classes = array("form_builder_text");
	
	if ($field_data["required"]) {
		$classes[] = "form_builder_required";
	}
	
	$section_token = "section-".BigTreeCMS::urlify($field_data["label"]);
?>
<fieldset class="form_builder_fieldset form_builder_fieldset_name">
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
		<div class="form_builder_item form_builder_item_firstname">
			<input class="<?=implode(" ",$classes)?><?php if ($error && !$default["first"]) { ?> form_builder_error<?php } ?>" id="form_builder_field_<?=$count?>" type="text" name="<?=$field_name?>[first]" value="<?=htmlspecialchars($default["first"])?>" autocomplete="<?=$section_token?> given-name" />
			<label class="form_builder_sublabel" for="form_builder_field_<?=($count++)?>">First</label>
		</div>
		
		<div class="form_builder_item form_builder_item_lastname">
			<input class="<?=implode(" ",$classes)?><?php if ($error && !$default["last"]) { ?> form_builder_error<?php } ?>" id="form_builder_field_<?=$count?>" type="text" name="<?=$field_name?>[last]" value="<?=htmlspecialchars($default["last"])?>" autocomplete="<?=$section_token?> family-name" />
			<label class="form_builder_sublabel" for="form_builder_field_<?=$count?>">Last</label>
		</div>
	</div>
</fieldset>