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
	
	// We only want to draw a single captcha, even if the form builder added two for whatever reason
	if (!defined("BTXFORMBUILDER_CAPTCHA_USED")) {
		define("BTXFORMBUILDER_CAPTCHA_USED", true);
?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<fieldset class="form_builder_fieldset form_builder_fieldset_captcha">
	<?php
		if ($field_data["label"]) {
	?>
	<label class="form_builder_label">
		<?=htmlspecialchars($field_data["label"])?>
		<span class="form_builder_required_star">*</span>
	</label>
	<?php
		}
		
		if ($field_data["instructions"]) {
	?>
	<p class="form_builder_captcha_instructions"><?=htmlspecialchars($field_data["instructions"])?></p>
	<?php
		}
		
		if ($error) {
	?>
	<p class="form_builder_captcha_error">The code you entered was not correct.  Please try again.</p>
	<?php
		}
	?>
	<div class="g-recaptcha" data-sitekey="<?=$settings["recaptcha"]["site_key"]?>"></div>
</fieldset>
<?php
	}
