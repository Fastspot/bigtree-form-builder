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
	?>
	<div class="form_builder_radio">
		<input type="radio" id="form_builder_field_<?=$count?>" name="<?=$field_name?>" value="<?=htmlspecialchars($item["value"])?>" <? if ($default == $item["value"] || ($default === false && $item["selected"])) { ?>checked="checked" <? } ?> data-price="<?=$item["price"]?>" />
		<label class="form_builder_for_checkbox" for="form_builder_field_<?=$count?>"><?=htmlspecialchars($item["description"])?></label>
	</div>
	<?
			// If this is a paid form, we watch the element for changes to calculate the total
			if ($form["paid"]) {
				$radio_watch[] = "form_builder_field_$count";
			}
			$count++;
		}
	?>
</fieldset>
