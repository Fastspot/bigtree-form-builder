<?php
	/**
	 * @global array $bigtree
	 */

	if (!empty($_GET["template"])) {
		$bigtree["form"] = $form = BTXFormBuilder::getForm($_GET["template"]);
	} else {
		$bigtree["form"] = $form = [];
	}

	$action = "create";

	include "_form.php";
