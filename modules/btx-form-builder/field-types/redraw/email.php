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
<input type="text" class="form_builder_text" value="" />