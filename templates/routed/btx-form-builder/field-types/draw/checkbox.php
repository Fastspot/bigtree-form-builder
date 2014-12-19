<fieldset>
	<?
		if ($d["label"]) {
	?>
	<label>
		<?=htmlspecialchars($d["label"])?>
		<? if ($d["required"]) { ?>
		<span class="form_builder_required_star">*</span>
		<? } ?>
	</label>
	<?
		}
		
		foreach ($d["list"] as $item) {
			$value = $item["value"] ? htmlspecialchars($item["value"]) : htmlspecialchars($item["description"]);
	?>
	<div class="form_builder_checkbox">
		<input type="checkbox" id="form_builder_field_<?=$count?>" name="<?=$field_name?><? if (count($d["list"]) > 1) { ?>[]<? } ?>" value="<?=$value?>"<? if ((is_array($default) && in_array($value,$default)) || ($default === false && $item["selected"])) { ?> checked="checked"<? } ?> data-price="<?=$item["price"]?>" /> 
		<label class="form_builder_for_checkbox" for="form_builder_field_<?=$count?>"><?=htmlspecialchars($item["description"])?><? if ($d["required"] && !$d["label"]) { ?><span class="form_builder_required_star">*</span><? } ?></label>
	</div>
	<?	
			// If this is a paid form, we watch the element for changes to calculate the total
			if ($form["paid"]) {
				$check_watch[] = "form_builder_field_$count";
			}
			$count++;
		}
	?>
</fieldset>
