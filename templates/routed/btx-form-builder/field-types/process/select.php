<?
	foreach ($d["list"] as $key => $item) {
		$value = $item["value"] ? $item["value"] : $item["description"];
		if ($_POST[$field_name] == $value) {
			$total += $item["price"];
		}
	}
	include "text.php";
?>