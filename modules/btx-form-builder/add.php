<?
	if ($_GET["template"]) {
		$form = BTXFormBuilder::getForm($_GET["template"]);
	}
?>
<div class="container">
	<form method="post" action="<?=MODULE_ROOT?>create/" class="module">
		<? include "_form.php" ?>
		<footer>
			<input type="submit" class="button blue" value="Create" />	
		</footer>
	</form>
</div>