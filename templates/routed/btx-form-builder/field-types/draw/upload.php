<?
	$classes = array("form_builder_upload");
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
	<input type="file" id="form_builder_field_<?=$count?>" name="<?=$field_name?>" <? if (count($classes)) { ?>class="<?=implode(" ",$classes)?>" <? } ?>value="<?=htmlspecialchars($d["default"])?>" />
</fieldset>
