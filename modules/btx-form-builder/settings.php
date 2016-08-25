<?php
	/**
	 * @global array $settings
	 */
	
	$admin->requireLevel(2);
	$settings = array_filter((array) $settings);
	$pg = new BigTreePaymentGateway;
?>
<div class="container">
	<form method="post" action="<?=MODULE_ROOT?>update-settings/">
		<section>
			<?php if (empty($pg->Service)) { ?>
			<div class="alert">
				<span></span>
				<p>To enable payment processing you must first <a href="<?=ADMIN_ROOT?>developer/payment-gateway/">setup your Payment Gateway</a>.</p>
			</div>
			<?php } ?>
			<fieldset>
				<input id="fb_field_accept_payments" type="checkbox"<?php if (empty($pg->Service)) { ?> disabled="disabled"<?php } ?> name="accept_payments"<?php if (!empty($settings["accept_payments"])) { ?> checked="checked"<?php } ?> />
				<label for="fb_field_accept_payments" class="for_checkbox">Enable Payment Processing</label>
			</fieldset>
			<fieldset>
				<input id="fb_field_no_css" type="checkbox"<?php if (!empty($settings["no_css"])) { ?> checked="checked"<?php } ?> name="no_css" />
				<label for="fb_field_no_css" class="for_checkbox">Don't Use Included CSS <small>(in front end template)</small></label>
			</fieldset>
			<hr />
			<h3>reCAPTCHA</h3>
			<p>To enable reCAPTCHA support you must <a href="http://www.google.com/recaptcha/" target="_blank">sign up here</a>. After adding your domains to reCAPTCHA, enter your Site and Secret keys below.</p>
			<br />
			<fieldset>
				<label for="fb_field_site_key"><strong>Site</strong> Key</label>
				<input id="fb_field_site_key" type="text" name="recaptcha[site_key]" value="<?=htmlspecialchars($settings["recaptcha"]["site_key"])?>" />
			</fieldset>
			<fieldset>
				<label for="fb_field_secret_key"><strong>Secret</strong> Key</label>
				<input id="fb_field_secret_key" type="text" name="recaptcha[secret_key]" value="<?=htmlspecialchars($settings["recaptcha"]["secret_key"])?>" />
			</fieldset>
		</section>
		<footer>
			<input type="submit" class="button blue" value="Update" />
		</footer>
	</form>
</div>