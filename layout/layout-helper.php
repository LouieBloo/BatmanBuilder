<?php


function createError($inputError)
{
	ob_start();
?>

	<div class="alert alert-danger alert-dismissable">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<p><?php echo $inputError;?></p>
	</div>

<?php

	$output = ob_get_clean();
	return $output;
}


function createSuccess($input)
{
	ob_start();
?>

	<div class="alert alert-success alert-dismissable">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<p><?php echo $input;?></p>
	</div>

<?php

	$output = ob_get_clean();
	return $output;
}






?>