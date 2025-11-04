<?php
if (isset($msgErro) && trim($msgErro) != "") {
	echo ("
	<div style='

		color: #cf3b4aff;
		
	'>
		$msgErro
	</div>");
}
if (isset($msgSucesso) and (trim($msgSucesso) != "")) {
	echo ("<div class='alert alert-success'>" . $msgSucesso . "</div>");
}
