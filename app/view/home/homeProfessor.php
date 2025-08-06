<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");


?>


<link rel="stylesheet" href="<?= BASEURL ?>/view/css/home.css">


<h3 class="text-center">Página inicial Professor</h3>


<!-- Botão para mostrar/ocultar formulário -->
<div class="text-center my-3">
  <a class="btn btn-primary" href="<?= BASEURL ?>/controller/OportunidadeController.php?action=list">Minhas Oportunidade</a>
</div>


<!-- Formulário embutido -->
<div id="formOportunidade" class="container d-none">
    <?php include(__DIR__ . '/../oportunidade/form.php'); ?>
</div>




<?php require_once(__DIR__ . "/../include/footer.php"); ?>







