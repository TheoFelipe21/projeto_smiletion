<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $_SESSION['nome']; ?></title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/184c7b81c1.js" crossorigin="anonymous"></script>
        <link href="<?php echo INCLUDE_PATH_STATIC ?>Styles/feed.css" rel="stylesheet">
        <link href="<?php echo INCLUDE_PATH_STATIC ?>Styles/perfil.css" rel="stylesheet">
    </head>

    <body>

        <section class='main-perfil'>
            <?php include('includes/sidebar.php');?>

            <div class = 'perfil'>
                <div class = "editar-perfil">
                    <h2>Editando Perfil</h2>
                    <br/>
                    <?php
                        if (isset($_SESSION['img_perfil']) && $_SESSION['img_perfil']=='') {
                            echo '<img src="'.INCLUDE_PATH_STATIC.'images/avatar.png" />';
                        }else{
                            echo '<img src="'.INCLUDE_PATH.'uploads_perfil/'.$_SESSION['img_perfil'].'" />';
                        }
                    ?>
                    <br/>
                    <form method="post" enctype="multipart/form-data">
                        <h4>Nome:</h4>
                        <input type="text" name ="nome" value="<?php echo $_SESSION['nome']?>">
                        <br/>
                        <h4>Senha:</h4>
                        <input type="password" name ="senha" placeholder="Sua nova senha...">
                        <br/>
                        <label>
                            <h5>Alterar Foto <i class="fa-solid fa-camera"></i></h5>
                            <input type="file" name='file_perfil' accept="image/*">
                        </label>
                        <br/>
                        <input type="hidden" name="atualizar" value="atualizar">
                        <input type="submit" name="acao" value="Salvar">
                    </form>
                </div>
            </div>
        </section>

    </body>
</html>