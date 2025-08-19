<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<!-- Link para CSS externo -->
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/homeAluno.css">

<h2>Escolha a modalidade que deseja visualizar</h2>
<div class="cards-container">
  <div class="card">
    <h3>Projeto de Pesquisa</h3>
    <p>Projetos de pesquisa buscam responder perguntas ou aprofundar o conhecimento sobre temas específicos.</p>
    <!-- Imagem no lugar do ícone -->
    <img src="<?= BASEURL ?>/view/img/pesquisa.png" alt="Projeto de Pesquisa" class="icon">
    <a href="<?= BASEURL ?>/controller/OportunidadeController.php?action=projetopesquisa" class="btn-visualizar">Visualizar</a>
  </div>

  <div class="card">
    <h3>Projeto de Extensão</h3>
    <p>Projeto de extensão leva o conhecimento acadêmico à comunidade, com impacto social e educativo.</p>
    <img src="<?= BASEURL ?>/view/img/extensao.png" alt="Projeto de Extensão" class="icon">
    <a href="<?= BASEURL ?>/controller/OportunidadeController.php?action=projetoextensao" class="btn-visualizar">Visualizar</a>
  </div>

  <div class="card">
    <h3>Estágio</h3>
    <p>Estágio é uma vivência prática que complementa a formação do estudante, aproximando-o do mercado de trabalho.</p>
    <img src="<?= BASEURL ?>/view/img/estagio.png" alt="Estágio" class="icon">
    <a href="<?= BASEURL ?>/controller/OportunidadeController.php?action=estagios" class="btn-visualizar">Visualizar</a>

  </div>
</div>

</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
