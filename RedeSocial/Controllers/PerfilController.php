<?php

    namespace RedeSocial\Controllers;

    class PerfilController{

        public function index(){
            if (isset($_SESSION['login'])){

                if (isset($_POST['atualizar'])) {
                    $pdo = \RedeSocial\connect_banco::connect();
                    $nome = strip_tags($_POST['nome']);
                    $senha = $_POST['senha'];


                    if ($nome =='' || strlen($nome) < 3) {
                        \RedeSocial\helper::alerta('Ops... O nome esta muito pequeno, deve conter um minimo de 3 caracteres');
                        \RedeSocial\helper::redirect(INCLUDE_PATH.'perfil');
                    }

                    if (\RedeSocial\Models\UsuariosModel::nameExistsPerfil($nome,$_SESSION['nome'])) {
                        \RedeSocial\helper::alerta('Nome ja cadastrado, por favor tentar outro');
                        \RedeSocial\helper::redirect(INCLUDE_PATH.'perfil');
                    }

                    if ($senha != '') {
                        $senha = \RedeSocial\Bcrypt::hash($senha);
                        $atualizar = $pdo->prepare("UPDATE usuarios SET nome = ?, senha = ? WHERE id = ?");
                        $atualizar->execute(array($nome, $senha, $_SESSION['id']));
                        $_SESSION['nome'] = $nome;

                    }else{

                        $senha = \RedeSocial\Bcrypt::hash($senha);
                        $atualizar = $pdo->prepare("UPDATE usuarios SET nome = ? WHERE id = ?");
                        $atualizar->execute(array($nome, $_SESSION['id']));
                        $_SESSION['nome'] = $nome;

                    }

                    if ($_FILES['file_perfil']['tmp_name'] != "") {
                        $file = $_FILES['file_perfil'];
                        $fileExt = explode('.',$file['name']);
                        $fileExt = $fileExt[count($fileExt)-1];
                        if ($fileExt == 'png' || $fileExt =='jpg' || $fileExt == 'jpeg') {
                            $size = intval($file['size']/1024);
                            if ($size<=600) {
                                $img = uniqid().'.'.$fileExt;
                                $atualizaImagem = $pdo->prepare("UPDATE usuarios SET img_perfil = ? WHERE id = ?");
                                $atualizaImagem->execute(array($img, $_SESSION['id']));
                                $_SESSION['img_perfil'] = $img;
                                move_uploaded_file($file['tmp_name'],'D:\php\xamp\htdocs\projeto_rede_social/uploads_perfil/'.$img);
                                \RedeSocial\helper::alerta('Seu perfil foi atualizado junto com a foto');
                                \RedeSocial\helper::redirect(INCLUDE_PATH.'perfil');
                            }else{
                                \RedeSocial\helper::alerta('A foto esta acima do tamanho permitido');
                                \RedeSocial\helper::redirect(INCLUDE_PATH.'perfil');
                            }
                        }else{
                            \RedeSocial\helper::alerta('Formato não condisente');
                            \RedeSocial\helper::redirect(INCLUDE_PATH.'perfil');
                        }
                    }

                    \RedeSocial\helper::alerta('Senha e/ou nome do perfil atualizados');
                    \RedeSocial\helper::redirect(INCLUDE_PATH.'perfil');
                }
                \RedeSocial\views\MainView::render('perfil');

            }else {
                \RedeSocial\helper::redirect(INCLUDE_PATH);
            }
        }
    }


?>