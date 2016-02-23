<section>
	<?
		// See if they want to use an existing form as a base.
		if (empty($form["id"])) {
			$existing_forms = BTXFormBuilder::getAllForms("title ASC");
			if (count($existing_forms)) {
	?>
	<div class="alert">
		<label>Form Template</label>
		<select name="existing" id="form_builder_existing_form">
			<option value="<?=MODULE_ROOT?>add/">-- New Form --</option>
			<? foreach ($existing_forms as $item) { ?>
			<option value="<?=MODULE_ROOT?>add/?template=<?=$item["id"]?>"<? if ($form["id"] == $item["id"]) { ?> selected="selected"<? } ?>><?=$item["title"]?></option>
			<? } ?>
		</select>
	</div>
	<?
			}
		}
	?>
	<fieldset>
		<label>Form Title</label>
		<input type="text" name="title" placeholder="Please enter a title to describe your form." value="<?=$form["title"]?>" />
	</fieldset>
	<fieldset>
		<div id="form_builder_limit_checkbox">
			<input type="checkbox" name="limit_entries" id="form_builder_limit_entries"<? if ($form["limit_entries"]) { ?> checked="checked"<? } ?> />
			<label class="for_checkbox">Limit Number of Entries</label>
		</div>
		<div id="form_builder_max_entries"<? if (!$form["limit_entries"]) { ?> style="display: none;"<? } ?>>
			<label>Maximum Number of Entries</label>
			<input type="text" name="max_entries" value="<?=$form["max_entries"]?>" />
		</div>
	</fieldset>
	<? if (!empty($settings["accept_payments"])) { ?>
	<fieldset>
		<div class="form_builder_triplets">
			<input type="checkbox" name="paid" id="form_builder_is_paid"<? if ($form["paid"]) { ?> checked="checked"<? } ?> />
			<label class="for_checkbox">Paid Form</label>	
		</div>
		<div id="form_builder_early_bird" class="form_builder_triplets"<? if (!$form["paid"]) { ?> style="display: none;"<? } ?>>
			<input type="checkbox" name="early_bird" <? if ($form["early_bird_date"]) { ?> checked="checked"<? } ?> />
			<label class="for_checkbox">Early Bird Pricing</label>
		</div>
	</fieldset>
	<div id="form_builder_paid_extras"<? if (!$form["paid"]) { ?> style="display: none;"<? } ?>>
		<div class="left" id="form_builder_base_price"<? if (!$form["paid"]) { ?> style="display: none;"<? } ?>>
			<fieldset>
					<label>Base Price <small>(the price a user pays before any field prices)</small></label>
				<input type="text" name="base_price" value="$<?=number_format($form["base_price"],2)?>" placeholder="Enter a numeric value." />
			</fieldset>
		</div>
		<div class="right" id="form_builder_early_base_price"<? if (!$form["early_bird_date"]) { ?> style="display: none;"<? } ?>>
			<fieldset>
					<label>Early Bird Base Price <small>(the price a user pays before early bird date)</small></label>
				<input type="text" name="early_bird_base_price" value="$<?=number_format($form["early_bird_base_price"],2)?>" placeholder="Enter a numeric value." />
			</fieldset>
		</div>
		<div class="left" id="form_builder_early_bird_date"<? if (!$form["early_bird_date"]) { ?> style="display: none;"<? } ?>>
			<label>Early Bird Cut-off Date <small>(i.e. February 22, 2011 @ 5:30pm)</small></label>
			<input type="text" name="early_bird_date" value="<? if ($form["early_bird_date"]) { echo date("F j, Y @ g:ia",strtotime($form["early_bird_date"])); } ?>" />
		</div>
	</div>
	<? } ?>
	<fieldset id="form_builder_fields">
		<?
			$count = 0;
			$in_cwrapper = false;
			
			foreach ((array)$form["fields"] as $field) {
				$t = $field["type"];
				$d = json_decode($field["data"],true);
				$id = $field["id"];
				
				if ($t != "column") {
					$_POST = array();
					$label = "";
					if (!empty($d)) {
						foreach ($d as $key => $val) {
							$_POST[$key] = $val;
						}
					}
					$_POST["name"] = "form_builder_element_$count";
					$_POST["type"] = $t;
					$_POST["id"] = $id;

					echo '<div class="form_builder_element form_builder_'.$t.'" data-type="'.$t.'" id="form_builder_element_'.$count.'">';
					include EXTENSION_ROOT."ajax/redraw-field.php";
					echo '</div>';
				} else {
					if (!$in_cwrapper) {
						echo '<div class="form_builder_element form_builder_column_wrapper"><div class="form_builder_wrapper">';
					}
					echo '<div class="form_builder_column" id="form_builder_element_'.$count.'">';
					echo '	<input type="hidden" name="id['.$count.']" value="'.$field["id"].'" />';
					echo '	<input type="hidden" name="type['.$count.']" value="column_start" />';
					echo '	<div>';
					foreach ($field["fields"] as $subfield) {
						$count++;
						$_POST = array();
						$label = "";
						$d = json_decode($subfield["data"],true);
						if (!empty($d)) {
							foreach ($d as $key => $val) {
								$_POST[$key] = $val;
							}
						}
						$_POST["name"] = "form_builder_element_$count";
						$_POST["type"] = $subfield["type"];
						$_POST["id"] = $subfield["id"];
						echo '<div class="form_builder_element form_builder_'.$subfield["type"].'" data-type="'.$subfield["type"].'" id="form_builder_element_'.$count.'">';
						include EXTENSION_ROOT."ajax/redraw-field.php";
						echo '</div>';
					}
					$count++;
					echo '	</div>';
					echo '	<input type="hidden" name="type['.$count.']" value="column_end" />';
					echo '</div>';
					if ($in_cwrapper) {
						echo '</div><div class="form_builder_controls form_builder_controls_single"><a href="#" class="icon_small icon_small_delete"></a></div></div>';
						$in_cwrapper = false;
					} else {
						$in_cwrapper = true;
					}
				}
				$count++;
			}
		?>
	</fieldset>
	<menu class="form_builder_elements">
		<? include "_elements.php" ?>
	</menu>
</section>

<script type="text/javascript">
	$(document).ready(function() {
		BTXFormBuilder.init(<?=($form["object_count"] ? $form["object_count"] : "0")?>);
	});
</script>