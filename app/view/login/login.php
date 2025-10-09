<?php
#Nome do arquivo: login/login.php
#Objetivo: interface para logar no sistema

require_once(__DIR__ . "/../include/header.php");
?>

<!-- Link para CSS externo -->
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/login.css">

<div class="container-login">
    <div>
        <div class="welcome">Bem-vindo!!</div>
        <img src="/aplicacao/app/view/img/login1.png" alt="Ilustração" class="illustration">
    </div>

    <div>
        <div class="form-box">
            <form id="frmLogin" action="./LoginController.php?action=logon" method="POST">
                <label for="txtEmail">EMAIL</label><br>
                <input type="text" name="email" id="txtEmail"
                    maxlength="45" placeholder="Informe o email"
                    value="<?php echo isset($dados['email']) ? $dados['email'] : '' ?>" />



                <label for="txtSenha">SENHA</label><br>
                <input type="password" name="senha" id="txtSenha"
                    maxlength="15" placeholder="Informe a senha"
                    value="<?php echo isset($dados['senha']) ? $dados['senha'] : '' ?>" />
                <!-- Mensagem de Caps Lock -->
                <div id="capsLockMsg" style="color: #d6425c; font-family: Arial, sans-serif; font-weight: bold; display:
                     none; margin-top: 5px; font-size: 14px;">
                    Atenção: Caps Lock está ativado!
                </div>


                <script>
                    const senhaInput = document.getElementById('txtSenha');
                    const capsMsg = document.getElementById('capsLockMsg');

                    // Função para verificar Caps Lock
                    function verificarCaps(event) {
                        const isCaps = event.getModifierState && event.getModifierState('CapsLock');
                        capsMsg.style.display = isCaps ? 'block' : 'none';
                    }

                    // Detecta quando o usuário digita
                    senhaInput.addEventListener('keydown', verificarCaps);
                    senhaInput.addEventListener('keyup', verificarCaps);

                    // Detecta quando o usuário foca no campo (para casos em que Caps Lock já estava ativo)
                    senhaInput.addEventListener('focus', function() {
                        // Simula um evento para disparar a verificação
                        const e = new KeyboardEvent('keydown', {
                            bubbles: true
                        });
                        senhaInput.dispatchEvent(e);
                    });
                    senhaInput.addEventListener('blur', function() {
                        capsMsg.style.display = 'none';
                    });
                </script>




                <button type="submit" class="login-btn">login</button>
            </form>
        </div>

        <div class="cadastro">
            Não tem cadastro? <br>
            <a href="./AutoCadastroController.php?action=cadastrar">Clique aqui para criar uma conta.</a>
        </div>

        <div class="col-6">
            <?php include_once(__DIR__ . "/../include/msg.php") ?>
        </div>
    </div>
</div>



<?php
require_once(__DIR__ . "/../include/footer.php");
?>