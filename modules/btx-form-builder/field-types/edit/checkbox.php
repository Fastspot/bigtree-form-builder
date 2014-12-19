<?
	// Format pricing if paid.
	if ($paid) {
		foreach ($data["list"] as &$option) {
			if ($option["price"] < 0) {
				$option["price"] = '- $'.number_format(abs($option["price"]),2);
			} else {
				$option["price"] = '$'.number_format($option["price"],2);
			}
		}
	}
?>
<fieldset>
	<label>Field Label</label>
	<input type="text" name="label" value="<?=htmlspecialchars($data["label"])?>" />
</fieldset>
<div id="checkbox_option_list"></div>
<br />

<script type="text/javascript">	
	new BigTreeListMaker({
		element: "#checkbox_option_list",
		name: "list",
		title: "Options",
		columns: ["Value","Description"<? if ($paid) { ?>,"Price Change"<? } ?>],
		keys: [{ key: "value", type: "text" },{ key: "description", type: "text" }<? if ($paid) { ?>,{ key: "price", type: "text" }<? } ?>],
		existing: <?=json_encode($data["list"])?>
	});
</script>