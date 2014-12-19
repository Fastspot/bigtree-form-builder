<label>
	<?=htmlspecialchars($data["label"])?>
	<? if ($data["required"]) { ?>
	<span class="required">*</span>
	<? } ?>
</label>
<p><?=htmlspecialchars($data["instructions"])?></p>
<div class="form_builder_object">
	<img src="<?=ADMIN_ROOT?>*/com.fastspot.form-builder/images/recaptcha.gif" alt="" height="75" />
</div>