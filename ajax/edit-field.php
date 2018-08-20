<?php
	$settings = (array) $cms->getSetting("settings");
	$data = json_decode($_POST["data"], true);
	$paid = $_POST["paid"];
	$type = trim($_POST["type"]);

    $directory = EXTENSION_ROOT."modules/btx-form-builder/field-types/edit/";
    $scannedDirectory = array_diff(scandir($directory), ['..', '.']);
    if (!in_array("$type.php", $scannedDirectory)) {
        throw new Exception;
    }
	include $directory . $type . ".php";
		
    if ($type != "section" && $type != "captcha") { ?>
        <fieldset>
            <input type="checkbox" class="checkbox" name="required"<?php if ($data["required"]) { ?> checked="checked"<?php } ?> />
            <label class="for_checkbox">Required</label>
        </fieldset>
    <?php } ?>
