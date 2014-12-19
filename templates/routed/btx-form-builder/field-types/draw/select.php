<fieldset>
	<label for="form_builder_field_<?=$count?>">
		<?=htmlspecialchars($d["label"])?>
		<? if ($d["required"]) { ?>
		<span class="form_builder_required_star">*</span>
		<? } ?>
	</label>
	<select id="form_builder_field_<?=$count?>" name="<?=$field_name?>"<? if ($d["required"]) { ?> class="form_builder_required<? if ($error) { ?> form_builder_error<? } ?>"<? } ?>>
		<? foreach ($d["list"] as $item) { ?>
		<option value="<?=htmlspecialchars($item["value"])?>"<? if ($item["value"] == $default || ($default === false && $item["selected"])) { ?> selected="selected"<? } ?> data-price="<?=$item["price"]?>"><?=htmlspecialchars($item["description"])?></option>
		<? } ?>
	</select>
</fieldset>
<?
	// If this is a paid form, we watch the element for changes to calculate the total
	if ($form["paid"]) {
		$select_watch[] = "form_builder_field_$count";
	}
?>