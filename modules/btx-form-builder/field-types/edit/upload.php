<?php
	/**
	 * @global array $data
	 * @global bool $paid
	 */
?>
<fieldset>
	<label>Field Label</label>
	<input type="text" name="label" value="<?=htmlspecialchars($data["label"])?>" />
</fieldset>
<fieldset>
	<label>Upload Directory <small>(relative to /site/, defaults to /site/files/form-builder/)</small></label>
	<input type="text" name="directory" value="<?=htmlspecialchars($data["directory"])?>" />
</fieldset>
<fieldset>
	<div id="form_builder_allowed_filetypes"></div>
</fieldset>


<script type="text/javascript">	
	new BigTreeListMaker({
		element: "#form_builder_allowed_filetypes",
		name: "allowed_filetypes",
		title: "Allowed File Types",
		columns: ["Extension"],
		keys: [{ key: "extension", type: "text" }],
		existing: <?=json_encode($data["allowed_filetypes"])?>
	});
</script>