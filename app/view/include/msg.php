<?php
if (isset($msgErro) && trim($msgErro) != "") {
	echo("
	<div style='
		background-color: #f8d7da;
		color: #721c24;
		border: 1px solid #f5c6cb;
		padding: 10px;
		margin: 10px 0;
		border-radius: 8px;
		width: 200%;
  		padding: 5px;
	'>
		$msgErro
	</div>");
}
	if(isset($msgSucesso) and (trim($msgSucesso) != "")){
		echo("<div class='alert alert-success'>" . $msgSucesso . "</div>");
	}
?>



