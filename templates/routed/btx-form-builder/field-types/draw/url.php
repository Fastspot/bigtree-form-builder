<?
	$classes = array("form_builder_text","form_builder_url");
	if ($d["required"]) {
		$classes[] = "form_builder_required";
	}
	if ($error) {
		$classes[] = "form_builder_error";
	}
?>
<fieldset>
	<label for="form_builder_field_<?=$count?>">
		<?=htmlspecialchars($d["label"])?>
		<? if ($d["required"]) { ?>
		<span class="form_builder_required_star">*</span>
		<? } ?>
	</label>
	<input type="text" id="form_builder_field_<?=$count?>" name="<?=$field_name?>" class="<?=implode(" ",$classes)?>" value="<?=htmlspecialchars($default)?>" />
</fieldset>
