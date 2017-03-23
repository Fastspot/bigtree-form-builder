<?php
	/**
	 * @global array $bigtree
	 */
	
	$form = BTXFormBuilder::getForm($bigtree["commands"][0]);
?>
<div class="container">
	<form method="post" action="<?=MODULE_ROOT?>update/<?=$form["id"]?>/" class="module">
		<?php include "_form.php" ?>
		<footer>
			<input type="submit" class="button blue" value="Update" />	
		</footer>
	</form>
</div>