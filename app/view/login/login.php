<?php
#Nome do arquivo: login/login.php
#Objetivo: interface para logar no sistema

require_once(__DIR__ . "/../include/header.php");
?>

<style>
    


body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #afc38b;
}

.container-login {
    display: flex;
    justify-content: space-around;
    align-items: center;
    height: 90vh;
}

.welcome {
    font-size: 5em;
    color: #c63d5d;
    font-weight: bold;
}

.form-box {
    background-color: #e8f0d9;
    padding: 30px;
    border-radius: 12px;
    width: 300px;
}

.form-box label {
    font-weight: bold;
}

.form-box input {
    width: 100%;
    margin-bottom: 15px;
    border: none;
    border-bottom: 1px solid #999;
    background: transparent;
    padding: 5px;
}

.login-btn {
    background-color: #c63d5d;
    color: white;
    border: none;
    padding: 10px;
    width: 100%;
    border-radius: 20px;
    cursor: pointer;
}

.login-btn:hover {
    background-color: #a7324a;
}

.cadastro {
    margin-top: 20px;
    color: #c63d5d;
    text-align: center;
}

.cadastro a {
    color: #c63d5d;
    text-decoration: none;
    font-weight: bold;
}

.illustration {
    max-width: 300px;
}
</style>

<div class="container-login">
    <div>
        <div class="welcome">Bem-vindo!!</div>
        <img src="/aplicacao/app/view/img/login1.png" alt="Ilustração">

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

                <button type="submit" class="login-btn">login</button>
            </form>
        </div>

        <div class="cadastro">
            Não tem cadastro? <br>
            <a href="./CadastroController.php?action=cadastrar">Clique aqui para criar uma conta.</a>
        </div>
        <div class="col-6">
            <?php include_once(__DIR__ . "/../include/msg.php") ?>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
