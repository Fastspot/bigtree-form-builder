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

			<fieldset>
				<input id="fb_field_no_page_header" type="checkbox"<?php if (!empty($settings["dont_draw_page_header"])) { ?> checked="checked"<?php } ?> name="dont_draw_page_header" />
				<label for="fb_field_no_page_header" class="for_checkbox">Don't Draw Page Header <small>(for when your layout draws $page_header separately)</small></label>
			</fieldset>

			<fieldset>
				<input id="fb_field_no_columns" type="checkbox"<?php if (!empty($settings["disable_columns"])) { ?> checked="checked"<?php } ?> name="disable_columns" />
				<label for="fb_field_no_columns" class="for_checkbox">Disable Columns Field Type</label>
			</fieldset>

			<fieldset>
				<input id="fb_field_no_columns" type="checkbox"<?php if (!empty($settings["reject_duplicates"])) { ?> checked="checked"<?php } ?> name="reject_duplicates" />
				<label for="fb_field_no_columns" class="for_checkbox">Reject Duplicate Form Submissions of Exact Data <small>(within 10 minutes)</small></label>
			</fieldset>

			<hr>

			<h3>Text Wrapper</h3>
			<p>If your WYSIWYG content is drawn inside of a wrapper for styling, enter the beginning and end tags below.</p>
			<br>

			<fieldset>
				<label for="fb_field_text_wrapper">Opening Wrapper</label>
				<input id="fb_field_text_wrapper" type="text" name="text_wrapper" value="<?=htmlspecialchars($settings["text_wrapper"] ?? "")?>" />
			</fieldset>

			<fieldset>
				<label for="fb_field_text_wrapper_end">Closing Wrapper</label>
				<input id="fb_field_text_wrapper_end" type="text" name="text_wrapper_end" value="<?=htmlspecialchars($settings["text_wrapper_end"] ?? "")?>" />
			</fieldset>

			<hr>

			<h3>reCAPTCHA</h3>
			<p>To enable reCAPTCHA support you must <a href="http://www.google.com/recaptcha/" target="_blank">sign up here</a>. After adding your domains to reCAPTCHA, enter your Site and Secret keys below.</p>
			<br />
			
			<fieldset>
				<label for="fb_field_recaptcha_version">Version</label>
				<select id="fb_field_recaptcha_version" name="recaptcha[version]">
					<option value="2"<?php if (empty($settings["recaptcha"]["version"]) || $settings["recaptcha"]["version"] == "2") { ?> selected="selected"<?php } ?>>2 (checkbox)</option>
					<option value="3"<?php if (!empty($settings["recaptcha"]["version"]) && $settings["recaptcha"]["version"] == "3") { ?> selected="selected"<?php } ?>>3 (invisible)</option>
				</select>
			</fieldset>
			
			<fieldset>
				<label for="fb_field_site_key"><strong>Site</strong> Key</label>
				<input id="fb_field_site_key" type="text" name="recaptcha[site_key]" value="<?=htmlspecialchars($settings["recaptcha"]["site_key"] ?? "")?>" />
			</fieldset>

			<fieldset>
				<label for="fb_field_secret_key"><strong>Secret</strong> Key</label>
				<input id="fb_field_secret_key" type="text" name="recaptcha[secret_key]" value="<?=htmlspecialchars($settings["recaptcha"]["secret_key"] ?? "")?>" />
			</fieldset>
			
			<fieldset>
				<label for="fb_field_recaptcha_threshold">Version 3 Threshold <small>(number between 0 and 100 with 100 most likely to be a human)</small></label>
				<input id="fb_field_recaptcha_threshold" type="text" name="recaptcha[threshold]" value="<?=htmlspecialchars($settings["recaptcha"]["threshold"] ?? "")?>" />
			</fieldset>

			<hr>

			<h3>Phone Numbers</h3>

			<fieldset>
				<label for="fb_field_country_phone">Default Country Code <small>(e.g. 1 for USA)</small></label>
				<input id="fb_field_country_phone" type="text" name="phone_default_country_code" value="<?=htmlspecialchars($settings["phone_default_country_code"] ?? "")?>" />
			</fieldset>

			<fieldset>
				<input id="fb_field_intl_phone" type="checkbox"<?php if (!empty($settings["phone_default_intl"])) { ?> checked="checked"<?php } ?> name="phone_default_intl" />
				<label for="fb_field_intl_phone" class="for_checkbox">Default to International Phone Number Field</label>
			</fieldset>
		</section>
		<footer>
			<input type="submit" class="button blue" value="Update" />
		</footer>
	</form>
</div>