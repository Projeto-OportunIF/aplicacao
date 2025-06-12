<?php
#Nome do arquivo: login/login.php
#Objetivo: interface para logar no sistema

require_once(__DIR__ . "/../include/header.php");
?>

<div class="container">
    <div class="row" style="margin-top: 20px;">
        <div class="col-6">
            <div class="alert alert-info">
                <h4>Informe os dados para logar:</h4>
                <br>

                <!-- Formulário de login -->
                <form id="frmLogin" action="./LoginController.php?action=logon" method="POST" >
                    <div class="mb-3">
                        <label class="form-label" for="txtEmail">Email:</label>
                        <input type="text" class="form-control" name="email" id="txtEmail"
                            maxlength="45" placeholder="Informe o email"
                            value="<?php echo isset($dados['email']) ? $dados['email'] : '' ?>" />        
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="txtSenha">Senha:</label>
                        <input type="password" class="form-control" name="senha" id="txtSenha"
                            maxlength="15" placeholder="Informe a senha"
                            value="<?php echo isset($dados['senha']) ? $dados['senha'] : '' ?>" />        
                    </div>

                    <button type="submit" class="btn btn-success mt-3">Logar</button>
                </form>
            </div>

            <span>Não possui cadastro?</span>
            <a href="./CadastroController.php?action=cadastrar">Clique aqui</a>
        </div>

        <div class="col-6">
            <?php include_once(__DIR__ . "/../include/msg.php") ?>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
