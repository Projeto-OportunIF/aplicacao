    <?php
#Nome do arquivo: oportunidadeList.php
#Objetivo: interface para listagem das oportunidades do sistema


require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>


<h3 class="text-center">Inscricao</h3>


<div class="container">
    <div class="row">
    </div>


    <div class="row" style="margin-top: 10px;">
        <div class="col-12">
            <div><span class="info-label">NOME:</span> <?= $dados['oportunidade']->getTitulo() ?></div>



        </div>
    </div>
</div>




<?php
require_once(__DIR__ . "/../include/footer.php");
?>