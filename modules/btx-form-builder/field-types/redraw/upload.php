<?php
	/**
	 * @global array $data
	 * @global bool $paid
	 */
?>
<label>
	<?php
		echo htmlspecialchars($data["label"]);
		
		if ($data["required"]) {
	?>
	<span class="required">*</span>
	<?php
		}
	?>
</label>
<div class="form_builder_object form_builder_full">
	<input type="file" class="form_builder_upload custom_control" />
	<?php
		if (is_array($data["allowed_filetypes"]) && count($data["allowed_filetypes"])) {
			$types = array();

			foreach ($data["allowed_filetypes"] as $type) {
				$types[] = ltrim(trim($type["extension"]), ".");
			}
	?>
	<label>Allowed File Types: <?=implode(", ", $types)?></label>
	<?php
		}
	?>
</div>