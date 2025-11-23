<?php
if (isset($msgErro) && trim($msgErro) != "") {
    echo ("
	<div style='
		background-color: #f8d7da;
		color: #721c24;
		border: 1px solid #f5c6cb;
		padding: 10px 15px;
		 margin: 15px 0;
        border-radius: 8px;
        width: 200%;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        font-weight: 500;
    
	'>
		$msgErro
	</div>");
}
if (isset($msgSucesso) && trim($msgSucesso) != "") {
    echo ("
    <div style='
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        padding: 10px 15px;
        margin: 15px 0;
        border-radius: 8px;
        width: 200%;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        font-weight: 500;
    '>
        $msgSucesso
    </div>");
}
