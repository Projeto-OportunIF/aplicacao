<?php
#Nome do arquivo: oportunidadeList.php
#Objetivo: interface para listagem das oportunidades do sistema


require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>


<h3 class="text-center">Oportunidades</h3>


<div class="container">
    <div class="row">
        <div class="col-3">
            <a class="btn btn-success"
                href="<?= BASEURL ?>/controller/OportunidadeController.php?action=create">
                Inserir</a>
        </div>


        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>


    <div class="row" style="margin-top: 10px;">
        <div class="col-12">
            <table id="tabOportunidadeList" class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                         <th>Vagas</th>
                        <th>Alterar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($dados['lista'] as $op): ?>
                        <tr>
                            <td><?= $op->getId(); ?></td>
                            <td><?= $op->getTitulo(); ?></td>
                            <td><?= $op->getDescricao(); ?></td>
                            <td><?= $op->getTipoOportunidade(); ?></td>
                              <td><?= $op->getVaga(); ?></td>
                            <td>
                                <a class="btn btn-primary"
                                   href="<?= BASEURL ?>/controller/OportunidadeController.php?action=edit&id=<?= $op->getId() ?>">
                                    Alterar
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-danger"
                                   onclick="return confirm('Confirma a exclusão da oportunidade?');"
                                   href="<?= BASEURL ?>/controller/OportunidadeController.php?action=delete&id=<?= $op->getId() ?>">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <div class="row" style="margin-top: 30px;">
        
            <a class="btn btn-secondary"
               href="<?= BASEURL ?>/controller/HomeController.php?action=homeProfessor">Voltar</a>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>


