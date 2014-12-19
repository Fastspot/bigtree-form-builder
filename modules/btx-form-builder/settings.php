<?
	$admin->requireLevel(2);
	$settings = is_array($settings) ? $settings : array();
	$pg = new BigTreePaymentGateway;
?>
<div class="container">
	<form method="post" action="../update-settings/">
		<section>
			<? if (empty($pg->Service)) { ?>
			<div class="alert">
				<span></span>
				<p>To enable payment processing you must first <a href="<?=ADMIN_ROOT?>developer/payment-gateway/">setup your Payment Gateway</a>.</p>
			</div>
			<? } ?>
			<fieldset>
				<input type="checkbox"<? if (empty($pg->Service)) { ?> disabled="disabled"<? } ?> name="accept_payments"<? if ($settings["accept_payments"]) { ?> checked="checked"<? } ?> />
				<label class="for_checkbox">Enable Payment Processing</label>
			</fieldset>
			<hr />
			<h3>reCAPTCHA</h3>
			<p>To enable reCAPTCHA support you must <a href="http://www.google.com/recaptcha/" target="_blank">sign up here</a>. After adding your domains to reCAPTCHA, enter your Site and Secret keys below.</p>
			<br />
			<fieldset>
				<label><strong>Site</strong> Key</label>
				<input type="text" name="recaptcha[site_key]" value="<?=htmlspecialchars($settings["recaptcha"]["site_key"])?>" />
			</fieldset>
			<fieldset>
				<label><strong>Secret</strong> Key</label>
				<input type="text" name="recaptcha[secret_key]" value="<?=htmlspecialchars($settings["recaptcha"]["secret_key"])?>" />
			</fieldset>
		</section>
		<footer>
			<input type="submit" class="button blue" value="Update" />
		</footer>
	</form>
</div>