<label>
	<?=htmlspecialchars($data["label"])?>
	<? if ($data["required"]) { ?>
	<span class="required">*</span>
	<? } ?>
</label>
<textarea class="form_builder_textarea" placeholder="<?=htmlspecialchars($data["placeholder"])?>"></textarea>