<?
	// We only want to draw a single captcha, even if the form builder added two for whatever reason
	if (!defined("BTXFORMBUILDER_CAPTCHA_USED")) {
		define("BTXFORMBUILDER_CAPTCHA_USED",true);
?>
<script src='https://www.google.com/recaptcha/api.js'></script>
<fieldset>
	<?
		if ($d["label"]) {
	?>
	<label>
		<?=htmlspecialchars($d["label"])?>
		<span class="form_builder_required_star">*</span>
	</label>
	<?
		}
		if ($d["instructions"]) {
	?>
	<p><?=htmlspecialchars($d["instructions"])?></p>
	<?
		}
		if ($error) {
	?>
	<div class="form_builder_captcha_error">
		<p>The code you entered was not correct.  Please try again.</p>
	</div>
	<?
		}
	?>
	<div class="g-recaptcha" data-sitekey="<?=$settings["recaptcha"]["site_key"]?>"></div>
</fieldset>
<?
	}
?>