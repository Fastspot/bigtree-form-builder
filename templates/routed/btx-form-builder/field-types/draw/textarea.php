<?
	$classes = array();
	if ($d["required"]) {
		$classes[] = "form_builder_required";
	}
	if ($d["default"]) {
		$classes[] = "default";
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
	<textarea id="form_builder_field_<?=$count?>" name="<?=$field_name?>"<? if (count($classes)) { ?> class="<?=implode(" ",$classes)?>"<? } ?> placeholder="<?=htmlspecialchars($d["placeholder"])?>"><?=htmlspecialchars($default)?></textarea>
</fieldset>
