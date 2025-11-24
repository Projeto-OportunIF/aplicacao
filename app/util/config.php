<?php
#Nome do arquivo: config.php
#Objetivo: define constantes para serem utilizadas no projeto

//Mostrar erros do PHP
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Banco de dados: conexão MySQL
define('DB_HOST', 'localhost');
define('DB_NAME', 'oportunif');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

//Caminho para adionar imagens, scripts e chamar páginas no sistema
//Deve ter o nome da pasta do projeto no servidor APACHE
define('BASEURL', '/aplicacao/app');

//Nome do sistema
define('APP_NAME', 'Template do Projeto Integrador');

//Página de logout do sistema
define('LOGIN_PAGE', BASEURL . '/controller/LoginController.php?action=login');

//Página de login do sistema
define('LOGOUT_PAGE', BASEURL . '/controller/LoginController.php?action=logout');

//Página home do sistema
define('HOME_PAGE', BASEURL . '/controller/HomeController.php?action=home');

define('HOME_PAGE_PROFESSOR', BASEURL . '/controller/HomeController.php?action=homeProfessor');
define('HOME_PAGE_ALUNO', BASEURL . '/controller/HomeController.php?action=homeAluno');
define('HOME_PAGE_ADMIN', BASEURL . '/controller/HomeController.php?action=homeAdministrador');
define('HOME_PAGE_EDITAR', BASEURL . '/app/view/perfil/perfilEdit.php?action=homeEditar');

//Sessão do usuário
define('SESSAO_USUARIO_ID', "usuarioLogadoId");
define('SESSAO_USUARIO_NOME', "usuarioLogadoNome");
define('SESSAO_USUARIO_TIPO', "usuarioLogadoTipo");
define('SESSAO_USUARIO_FOTO_PERFIL', "usuarioLogadoFotoPerfil");
define('SESSAO_USUARIO_NOTIFICACOES', "usuarioLogadoNotificaçoes");

//Arquivos
define('PATH_ARQUIVOS', __DIR__ . "/../../arquivos");
define('BASEURL_ARQUIVOS', BASEURL . "/../arquivos");
