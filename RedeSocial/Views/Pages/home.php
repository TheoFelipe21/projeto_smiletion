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
    </head>

    <body>

        <section class='main-feed'>
            <?php include('includes/sidebar.php');?>

            <div class = 'feed'>
                <div class = 'feed-wraper'>
                    <div class = feed-form>
                        <form method="post" enctype="multipart/form-data">
                            <textarea name = "publicacao_content" placeholder = "Compartilhe seus melhores momentos!" required></textarea>
                            <table>
                                <tr>
                                    <th>
                                        <input type="hidden" name="publicacao">
                                        <input type="submit" name="acao" value="Postar!">
                                    </th>
                                    <th>
                                        <label>
                                            <span>+</span>
                                            <input type="file" name = "file" accept="image/*"/>
                                        </label>
                                    </th>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <?php
                        $retrivePosts = \RedeSocial\Models\HomeModel::retrieveFriendsPosts();

                        foreach ($retrivePosts as $key => $value) {
                            foreach ($value as $key => $value2) {
                    ?>
                    <div class='feed-single-post'>
                        <div class='feed-single-post-author'>
                            <div class = 'img-single-post-author'>
                                <?php if ($value2['img_perfil'] == '') {
                                    ?>
                                    <img src="<?php echo INCLUDE_PATH_STATIC ?>images/avatar.png" />

                                <?php }else {?>
                                    <img src="<?php echo INCLUDE_PATH ?>uploads_perfil/<?php echo $value2['img_perfil'] ?>" />

                                <?php } ?>
                            </div>
                            <div class = 'feed-single-post-author-info'>

                                    <h3><?php echo $value2['usuario']?></h3>

                                <p><?php echo date('d/m/Y H:i:s',strtotime($value2['data']))?></p>
                            </div>
                        </div>
                        <div class='feed-single-post-content'>
                            <?php echo $value2['conteudo']?>

                            <div class='feed-single-post-content-img'>
                                <?php if ($value2['imagem']!='') {?>
                                    <img src="<?php echo INCLUDE_PATH ?>uploads/<?php echo $value2['imagem']?>">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class='friends-request-feed'>
                    <h3>Solicitações de amizade</h3>

                    <?php
                        foreach (\RedeSocial\Models\UsuariosModel::listarPedidosAmizade() as $key=>$value) {
                           $usuarioInfo = \RedeSocial\Models\UsuariosModel::pegaUsuarioPorId($value['pedinte']);
                    ?>
                    <br/>
                    <div class ='friend-request-single'>
                        <img src="<?php echo INCLUDE_PATH_STATIC ?>images/avatar.png" />
                        <div class='friend-request-single-info'>
                            <h4><?php echo $usuarioInfo['nome']?></h4>
                            <p><a href="<?php echo INCLUDE_PATH?>?aceitarAmizade=<?php echo $usuarioInfo['id']?>">Aceitar</a> |
                            <a href="<?php echo INCLUDE_PATH?>?recusarAmizade=<?php echo $usuarioInfo['id']?>">Recusar</a></p>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </section>

    </body>
</html>