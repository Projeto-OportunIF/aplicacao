<?php
#Nome do arquivo: oportunidadeList.php
#Objetivo: interface para listagem das oportunidades do sistema
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");

?>

<!-- Link para CSS externo -->
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/oportunidade_lista.css">

<h3 class="text-center">Oportunidades Inseridas</h3>


<div class="col-12">
    <a class="btn btn-secondary"
        href="<?= BASEURL ?>/controller/HomeController.php?action=homeProfessor">← Voltar</a>
</div>

<div class="cards-container">
    <?php foreach ($dados['lista'] as $op): ?>
        <div class="card-oportunidade">
            <h3><?= $op->getTitulo(); ?></h3>
            <p><strong>Descrição:</strong> <?= $op->getDescricao(); ?></p>
            <p><strong>Professor Responsável:</strong> <?= $op->getProfessorResponsavel(); ?></p> <!-- Adicione esta linha -->
            <p><strong>Tipo:</strong> <?= $op->getTipoOportunidade(); ?></p>
            <p><strong>Vagas:</strong> <?= $op->getVaga(); ?></p>
            <p><strong>Cursos:</strong>
                <?php
                $nomesCursos = array_map(fn($c) => $c->getNome(), $op->getCursos() ?? []);
                echo implode(", ", $nomesCursos);
                ?>
            </p>



            <div class="acoes">
                <a class="btn btn-primary"
                    href="<?= BASEURL ?>/controller/OportunidadeController.php?action=edit&id=<?= $op->getId() ?>">Alterar</a>
                <a class="btn btn-danger"
                    onclick="return confirm('Confirma a exclusão da oportunidade?');"
                    href="<?= BASEURL ?>/controller/OportunidadeController.php?action=delete&id=<?= $op->getId() ?>">Excluir</a>
                <a class="btn btn-info"
                    href="<?= BASEURL ?>/controller/OportunidadeController.php?action=visualizarInscritos&idOport=<?= $op->getId() ?>">Inscritos</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>


</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>