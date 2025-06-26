<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");

?>

<h3 class="text-center">
    <?php if($dados['id'] == 0) echo "Inserir"; else echo "Alterar"; ?> 
    Usuário
</h3>

<div class="container">
    
    <div class="row" style="margin-top: 10px;">
        
        <div class="col-6">
            <form id="frmUsuario" method="POST" 
                action="<?= BASEURL ?>/controller/UsuarioController.php?action=save" >
                <div class="mb-3">
                    <label class="form-label" for="txtNomeCompleto">Nome Completo:</label>
                    <input class="form-control" type="text" id="txtNomeCompleto" name="nomeCompleto" 
                        maxlength="70" placeholder="Informe o nome"
                        value="<?php echo (isset($dados["usuarios"]) ? $dados["usuarios"]->getNomeCompleto() : ''); ?>" />
                </div>
                 
                 <div class="mb-3">
                    <label class="form-label" for="txtCpf">CPF:</label>
                    <input class="form-control" type="text" id="txtcpf" name="cpf" 
                        maxlength="70" placeholder="Informe o CPF"
                        value="<?php echo (isset($dados["usuarios"]) ? $dados["usuarios"]->getCpf() : ''); ?>" />
                </div>

                 <div class="mb-3">
                    <label class="form-label" for="txtmatricula">Matricula ou Siap:</label>
                    <input class="form-control" type="text" id="txtmatricula" name="matricula" 
                        maxlength="70" placeholder="Informe a Matricula"
                        value="<?php echo (isset($dados["usuarios"]) ? $dados["usuarios"]->getMatricula() : ''); ?>" />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtemail">E-mail:</label>
                    <input class="form-control" type="text" id="txtemail" name="email" 
                        maxlength="70" placeholder="Informe o e-mail"
                        value="<?php echo (isset($dados["usuarios"]) ? $dados["usuarios"]->getEmail() : ''); ?>" />
                </div>

                 <div class="mb-3">
                    <label class="form-label" for="txtCurso">Curso:</label>
                    <input class="form-control" type="text" id="txtCurso" name="curso"
                        maxlength="70" placeholder="Informe o curso"
                        value="<?php echo (isset($dados["usuarios"]) ? $dados["usuarios"]->getCurso() : ''); ?>" />
                </div>

    
                <div class="mb-3">
                    <label class="form-label" for="txtSenha">Senha:</label>
                    <input class="form-control" type="text" id="txtSenha" name="senha" 
                        maxlength="90" placeholder="Informe a senha"
                        value="<?php echo (isset($dados["usuarios"]) ? $dados["usuarios"]->getSenha() : ''); ?>" />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtconf_senha">Confirmação da senha:</label>
                    <input class="form-control" type="password" id="txtconf_senha" name="conf_senha" 
                        maxlength="15" placeholder="Informe a confirmação da senha"
                        value="<?php echo isset($dados['usuarios']) ? $dados['usuarios'] : '';?>"/>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="seltipoUsuario">Tipo Usuario:</label>
                    <select class="form-select" name="tipoUsuario" id="seltipoUsuario">
                        <option value="">Selecione o usuario</option>
                        <?php foreach($dados["tipoUsuario"] as $tipoUsuario): ?>
                            <option value="<?= $tipoUsuario ?>" 
                                <?php 
                                    if(isset($dados["usuarios"]) && $dados["usuarios"]->getTipoUsuario() == $tipoUsuario) 
                                        echo "selected";
                                ?>    
                            >
                                <?= $tipoUsuario ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <input type="hidden" id="hddId" name="id" 
                    value="<?= $dados['id']; ?>" />

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Gravar</button>
                </div>
            </form>            
        </div>

        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 30px;">
        <div class="col-12">
        <a class="btn btn-secondary" 
                href="<?= BASEURL ?>/controller/UsuarioController.php?action=list">Voltar</a>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>

