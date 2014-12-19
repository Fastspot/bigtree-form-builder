<link rel="stylesheet" href="<?=STATIC_ROOT?>extensions/com.fastspot.form-builder/front-end.css" />
<h1><?=$page_header?></h1>
<?=$page_content?>	
<?
	if ($form["limit_entries"] && $form["entries"] >= $form["max_entries"]) {
?>
<h2>Maximum Entries Reached</h2>
<p>This form has reached the maximum number of entries.</p>
<?	
	} else {
?>
<form method="post" action="<?=$page_link?>process/" enctype="multipart/form-data" class="form_builder">
	<?
		$error_count = count($_SESSION["form_builder"]["errors"]);
		if ($error_count) {
	?>
	<div class="form_builder_errors">
		<? if ($error_count == 1) { ?>
		<p>A required field was missing. Please fill out all required fields and submit again.</p>
		<? } else { ?>
		<p>Required fields were missing. Please fill out all required fields out and submit again.</p>
		<? } ?>
	</div>
	<?	
		}
		
		if ($_SESSION["form_builder"]["payment_error"]) {
	?>
	<div class="form_builder_errors">
		<p>Checkout failed — your credit card has not been charged.</p>
		<p class="form_builder_alert">The error returned was: <?=$_SESSION["form_builder"]["payment_error"]?></p>
	</div>
	<?
		}
	?>
	<div class="form_builder_required_message">
		<p><span class="form_builder_required_star">*</span> = required field</p>
	</div>
	<?		
		// Setup price watchers.
		$check_watch = array();
		$radio_watch = array();
		$select_watch = array();

		$last_field = false;
		$count = 0;
		foreach ($form["fields"] as $field) {
			$count++;
			$t = $field["type"];
			$d = json_decode($field["data"],true);

			if ($t != "column") {
				if ($d["name"]) {
					$field_name = $d["name"];
				} else {
					$field_name = "data_".$field["id"];
				}
				$error = false;
				if (isset($_SESSION["form_builder"]["fields"])) {
					$default = $_SESSION["form_builder"]["fields"][$field_name];
				} else {
					if (isset($d["default"])) {
						$default = $d["default"];
					} else {
						$default = false;			
					}
				}
				if (is_array($_SESSION["form_builder"]["errors"]) && in_array($field_name,$_SESSION["form_builder"]["errors"])) {
					$error = true;
				}
				include "field-types/draw/$t.php";
			} else {
				if ($last_field == "column") {
					echo '<div class="form_builder_column form_builder_last">';
				} else {
					echo '<div class="form_builder_column">';
				}
				foreach ($field["fields"] as $subfield) {
					$count++;
					$d = json_decode($subfield["data"],true);
					if ($d["name"]) {
						$field_name = $d["name"];
					} else {
						$field_name = "data_".$subfield["id"];
					}
					$error = false;
					if (isset($_SESSION["form_builder"]["fields"])) {
						$default = $_SESSION["form_builder"]["fields"][$field_name];
					} else {
						if (isset($d["default"])) {
							$default = $d["default"];
						} else {
							$default = false;			
						}
					}
					if (is_array($_SESSION["form_builder"]["errors"]) && in_array($field_name,$_SESSION["form_builder"]["errors"])) {
						$error = true;
					}
					include "field-types/draw/".$subfield["type"].".php";
				}
				echo '</div>';
			}
			$last_field = $t;
		}
	?>
	<input type="submit" class="form_builder_submit" value="Submit" />
</form>
<?
		// Make the price watchers
		if ($form["paid"]) {
			if ($form["early_bird_date"] && strtotime($form["early_bird_date"]) > time()) {
				$bp = $form["early_bird_base_price"] ? $form["early_bird_base_price"] : $form["base_price"];			
			} else {
				$bp = $form["base_price"] ? $form["base_price"] : "0.00";
			}
?>
<script type="text/javascript">
	(function() {
		var PreviousValues = {};
		var Total = <?=$bp?>;

		function formatMoney(places, symbol, thousand, decimal) {
			places = !isNaN(places = Math.abs(places)) ? places : 2;
			symbol = symbol !== undefined ? symbol : "$";
			thousand = thousand || ",";
			decimal = decimal || ".";
			var number = this, 
			    negative = number < 0 ? "-" : "",
			    i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
			    j = (j = i.length) > 3 ? j % 3 : 0;
			return symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
		}

		var element;
		<?
			// Text fields to watch for price changes
			foreach ($text_watch as $id) {
		?>
		element = document.getElementById("<?=$id?>");
		element.addEventListener("change",function() {
			var old_price = PreviousValues[this.getAttribute("name")];
			if (old_price) {
				Total -= old_price;
			}
			var price = parseFloat(this.value.replace(/[^0-9-.]/g, ''));
			if (price < 0) {
				price = 0;
			}
			this.value = formatMoney(price);
			if (isNaN(price)) {
				PreviousValues[this.getAttribute("name")] = 0;
			} else {
				Total += price;
				PreviousValues[this.getAttribute("name")] = price;
			}
			document.getElementById("form_builder_total").innerHTML = formatMoney(Total);
		});
		<?
			}

			// Check boxes to watch for price changes
			foreach ($check_watch as $id) {
		?>
		element = document.getElementById("<?=$id?>");
		element.onchange = function() {
			var price = this.getAttribute("data-price");
			if (this.checked) {
				Total += parseFloat(price);
			} else {
				Total -= parseFloat(price);
			}
			document.getElementById("form_builder_total").innerHTML = formatMoney(Total);
		};
		<?
			}

			// Radio buttons to watch for price changes
			foreach ($radio_watch as $id) {
		?>
		element = document.getElementById("<?=$id?>");
		element.onchange = function() {
			var old_price = PreviousValues[this.getAttribute("name")];
			if (old_price) {
				Total -= old_price;
			}
			var price = this.getAttribute("data-price");
			Total += parseFloat(price);
			PreviousValues[this.getAttribute("name")] = parseFloat(price);
			document.getElementById("form_builder_total").innerHTML = formatMoney(Total);
		};
		<?
			}

			// Select boxes to watch for price changes
			foreach ($select_watch as $id) {
		?>
		element = document.getElementById("<?=$id?>");
		element.onchange = function() {
			var old_price = PreviousValues[this.getAttribute("name")];
			if (old_price) {
				Total -= old_price;
			}
			var price = parseFloat(this.options[this.selectedIndex].getAttribute("data-price"));
			Total += price;
			PreviousValues[this.getAttribute("name")] = price;
			document.getElementById("form_builder_total").innerHTML = formatMoney(Total);
		};
		<?
			}
		?>

		window.addEventListener("load",function() {
			var element;
			<?
				// Get all the fields that affect price and get our initial total
				foreach ($text_watch as $id) {
			?>
			element = document.getElementById("<?=$id?>");
			if (element.value) {
				var price = parseFloat(element.value.replace(/[^0-9-.]/g, ''));
				if (price < 0) {
					price = 0;
				}
				Total += price;
				PreviousValues[item.getAttribute("name")] = price;
				element.value = formatMoney(price);
			}
			<?
				}
	
				foreach ($check_watch as $id) {
			?>
			element = document.getElementById("<?=$id?>");
			if (element.checked) {
				Total += parseFloat(i.getAttribute("data-price"));
			}
			<?
				}
				
				foreach ($radio_watch as $id) {
			?>
			element = document.getElementById("<?=$id?>");
			if (element.checked) {
				Total += parseFloat(i.getAttribute("data-price"));
				PreviousValues[i.getAttribute("name")] = parseFloat(i.getAttribute("data-price"));
			}
			<?
				}
				
				foreach ($select_watch as $id) {
			?>
			element = document.getElementById("<?=$id?>");
			var value = parseFloat(element.options[element.selectedIndex].getAttribute("data-price"));
			if (value) {
				Total += value;
				PreviousValues[element.getAttribute("name")] = parseFloat(element.options[element.selectedIndex].getAttribute("data-price"));
			}
			<?
				}
			?>
			document.getElementById("form_builder_total").innerHTML = formatMoney(Total);
		});
	})();
</script>
<?
		}

		unset($_SESSION["form_builder"]["payment_error"]);
		unset($_SESSION["form_builder"]["errors"]);
		unset($_SESSION["form_builder"]["fields"]);
	}
?>