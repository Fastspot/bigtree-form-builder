<label>
	<?=htmlspecialchars($data["label"])?>
	<? if ($data["required"]) { ?>
	<span class="required">*</span>
	<? } ?>
</label>
<? foreach ($data["list"] as $item) { ?>
<div class="form_builder_option">
	<input type="radio"<? if ($item["selected"]) { ?> checked="checked"<? } ?> class="form_builder_radio custom_control" /> <?=htmlspecialchars($item["description"])?>
</div>
<? } ?>