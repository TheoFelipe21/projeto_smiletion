<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrar</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <link href="<?php echo INCLUDE_PATH_STATIC ?>Styles/style.css" rel="stylesheet">
    </head>

    <body>
        <div class="form-container-login">
            <div class = "logo-chamada-login">
                <img src="<?php echo INCLUDE_PATH_STATIC ?>images/logo.png" />
                <p>Se conecte com todos os seus amigos e divida seus melhores momentos</p>
            </div>

            <div class = "form-login">
                <h3 style ="text-align: center;">Crie sua conta</h3>
                <form method = "post">
                    <input type="text" name="nome" placeholder="Seu Nome">
                    <input type="text" name="email" placeholder="E-mail">
                    <input type="password" name="senha" placeholder="Senha">
                    <input type="submit" name="acao" value="Criar Conta">
                    <input type="hidden" name="registrar" value="registrar">
                </form>
            </div>
        </div>
    </body>
</html>