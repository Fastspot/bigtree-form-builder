<label>
	<?=htmlspecialchars($data["label"])?>
	<? if ($data["required"]) { ?>
	<span class="required">*</span>
	<? } ?>
</label>
<select class="custom_control">
	<? foreach ($data["list"] as $item) { ?>
	<option value="<?=htmlspecialchars($item["value"])?>"<? if ($item["selected"]) {?> selected="selected"<? } ?>><?=htmlspecialchars($item["description"])?></option>
	<? } ?>
</select>