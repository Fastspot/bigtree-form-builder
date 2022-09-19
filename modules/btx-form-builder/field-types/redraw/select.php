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
<select<?php if (BIGTREE_REVISION < 500) { ?> class="custom_control"<?php } ?>>
	<?php
		if (!empty($data["list"]) && is_array($data["list"])) {
			foreach ($data["list"] as $item) {
	?>
	<option value="<?=htmlspecialchars($item["value"] ?? "")?>"<?php if (!empty($item["selected"])) {?> selected="selected"<?php } ?>><?=htmlspecialchars($item["description"] ?? "")?></option>
	<?php
			}
		}
	?>
</select>