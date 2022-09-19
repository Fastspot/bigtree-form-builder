<?php
	/**
	 * @global array $data
	 * @global bool $paid
	 */
?>
<label>
	<?php
		echo htmlspecialchars($data["label"] ?? "");
		
		if (!empty($data["required"])) {
	?>
	<span class="required">*</span>
	<?php
		}
	?>
</label>
<?php
	if (!empty($data["list"]) && is_array($data["list"])) {
		foreach ($data["list"] as $item) {
?>
<div class="form_builder_option">
	<input type="checkbox"<?php if (!empty($item["selected"])) { ?> checked="checked"<?php } ?> class="custom_control" />
	<?=htmlspecialchars($item["description"] ?? "")?>
</div>
<?php
		}
	}
?>