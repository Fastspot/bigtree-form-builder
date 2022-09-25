<?php
	/**
	 * @global array $bigtree
	 * @global int $form
	 */
	
	// Make sure this page is never cached.
	if (!defined("BIGTREE_DO_NOT_CACHE")) {
		define("BIGTREE_DO_NOT_CACHE", true);
	}
	
	// $form is an array in newer form builder
	if (!is_array($form)) {
		$form = [
			"form" => $form,
			"email_field" => false,
			"email_template" => false
		];
	}
	
	$email_template = $form["email_template"];
	$email_subject = $form["email_subject"];
	$email_field = $form["email_field"];
	$form = BTXFormBuilder::getForm($form["form"]);
	$settings = $cms->getSetting("settings");
	
	// Make sure we're serving over HTTPS
	if ($form["paid"]) {
		$cms->makeSecure();
		
		$form["fields"] = array_merge($form["fields"], [
			// Section Header
			[
				"type" => "section",
				"data" => json_encode([
					"title" => "Billing Address & Payment",
					"description" => "Please enter your billing information as it appears on your credit card.",
				]),
			],
			// Billing Name
			[
				"type" => "name",
				"id" => "fb_cc_billing_name",
				"data" => json_encode([
					"required" => true,
					"label" => "Billing Name"
				]),
			],
			// Billing Email
			[
				"type" => "email",
				"id" => "fb_cc_billing_email",
				"data" => json_encode([
					"required" => true,
					"label" => "Billing Email"
				]),
			],
			// Billing Address
			[
				"type" => "address",
				"id" => "fb_cc_billing_address",
				"data" => json_encode([
					"required" => true,
					"label" => "Billing Address"
				]),
			],
			// Credit Card
			[
				"type" => "credit-card",
				"id" => "fb_cc_card",
				"data" => json_encode(["required" => true]),
			],
		]);
		
		$page_link = str_replace("http://", "https://", $cms->getLink($bigtree["page"]["id"]));
	} else {
		$page_link = $cms->getLink($bigtree["page"]["id"]);
	}
