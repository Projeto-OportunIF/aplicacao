<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<style>
  body {
    background-color: #c1dba5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  h2 {
    text-align: center;
    color: #f5f5f5;
    font-weight: 700;
    margin-bottom: 30px;
    font-size: 40px;
  }

  .cards-container {
    max-width: 1100px;
    margin: 0 auto 50px;
    display: flex;
    justify-content: space-around;
    gap: 20px;
  }

  .card {
    background-color:#c23956;
    border-radius: 10px;
    padding: 90px 44px 120px 20px;
    width: 300px;
    color: #fff;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .card h3 {
    font-weight: 700;
    margin-bottom: 6px;
    border-bottom: 1px solid #f5f5f5;
    padding-bottom: 5px;
    font-size: 20px;
  }

  .card p {
    font-size: 13px;
    line-height: 1.4;
    margin-bottom: 20px;
    opacity: 0.9;
  }

  /* Ícones com SVG embutidos */
  .icon {
    fill: #f5f5f5;
    width: 700px;
    height: 200px;
    margin-bottom: 25px;
    align-self: center;
  }

  .btn-visualizar {
    width: 110px;
    padding: 8px 14px;
    background-color: #f5f5f5;
    color: #798660;
    border: none;
    border-radius: 15px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    align-self: center;
    transition: background-color 0.3s ease;
    text-decoration: none;
    text-align: center;
  }

  .btn-visualizar:hover {
    background-color: #e4d6d7;
  }
</style>

<h2>Escolha a modalidade que deseja visualizar</h2>

<div class="cards-container">
  <div class="card">
    <h3>Projeto de Pesquisa</h3>
    <p>Projetos de pesquisa buscam responder perguntas ou aprofundar o conhecimento sobre temas específicos.</p>
    <!-- Ícone de documento com lupa -->
    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
      <path d="M44 52H20a4 4 0 01-4-4V16a4 4 0 014-4h13l11 11v19a4 4 0 01-4 4zM33 17v10h10"/>
      <circle cx="27" cy="43" r="7" stroke="#fff" stroke-width="3" fill="none"/>
      <line x1="32" y1="48" x2="38" y2="54" stroke="#fff" stroke-width="3" stroke-linecap="round"/>
    </svg>
    <a href="<?= BASEURL ?>/view/oportunidade/pesquisa.php" class="btn-visualizar">Visualizar</a>

  </div>

  <div class="card">
    <h3>Projeto de Extensão</h3>
    <p>Projeto de extensão leva o conhecimento acadêmico à comunidade, com impacto social e educativo.</p>
    <!-- Ícone globo com setas -->
    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
      <circle cx="32" cy="32" r="28" stroke="#fff" stroke-width="3" fill="none"/>
      <path d="M19 25c5-8 12-12 20-14" stroke="#fff" stroke-width="3" fill="none" stroke-linecap="round"/>
      <path d="M45 39c-5 8-12 12-20 14" stroke="#fff" stroke-width="3" fill="none" stroke-linecap="round"/>
      <path d="M44 12l8 10-8 10" fill="#fff"/>
    </svg>
    <a href="<?= BASEURL ?>/view/oportunidade/extensao.php" class="btn-visualizar">Visualizar</a>

  </div>

  <div class="card">
    <h3>Estágio</h3>
    <p>Estágio é uma vivência prática que complementa a formação do estudante, aproximando-o do mercado de trabalho.</p>
    <!-- Ícone de pasta, diploma e crachá -->
    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
      <rect x="12" y="22" width="40" height="20" stroke="#fff" stroke-width="3" fill="none" rx="3" ry="3"/>
      <path d="M20 22v-6a4 4 0 018 0v6" stroke="#fff" stroke-width="3" fill="none" stroke-linejoin="round"/>
      <rect x="36" y="34" width="14" height="6" stroke="#fff" stroke-width="3" fill="none" rx="2" ry="2"/>
      <circle cx="44" cy="46" r="6" stroke="#fff" stroke-width="3" fill="none"/>
      <path d="M40 54h8" stroke="#fff" stroke-width="3" stroke-linecap="round"/>
    </svg>
    <a href="<?= BASEURL ?>/view/oportunidade/estagio.php" class="btn-visualizar">Visualizar</a>

  </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
