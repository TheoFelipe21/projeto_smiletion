<?php

    namespace RedeSocial\Controllers;

    class HomeController{

        public function index(){

            if (isset($_GET['logout'])) {
                session_unset();
                session_destroy();
                \RedeSocial\helper::redirect(INCLUDE_PATH);
            }

            if (isset($_SESSION['login'])) {

                $pdo = \RedeSocial\connect_banco::connect();
                $me = $pdo->prepare("SELECT * FROM amizades WHERE pedinte = $_SESSION[id] AND receptor = $_SESSION[id]");
                $me->execute();

                if ($me->rowCount() == 0) {
                    \RedeSocial\Models\UsuariosModel::solicitarAmizade($_SESSION['id']);
                    \RedeSocial\Models\UsuariosModel::respostaPedidoAmizade($_SESSION['id'], 1);
                }

                if (isset($_GET['recusarAmizade'])) {
                    $idEnviou = (int) $_GET['recusarAmizade'];
                    \RedeSocial\Models\UsuariosModel::respostaPedidoAmizade($idEnviou, 0);

                    \RedeSocial\helper::alerta('Amigo Recusado');
                    \RedeSocial\helper::redirect(INCLUDE_PATH);

                } else if(isset($_GET['aceitarAmizade'])){
                    $idEnviou = (int) $_GET['aceitarAmizade'];
                    if(\RedeSocial\Models\UsuariosModel::respostaPedidoAmizade($idEnviou, 1)){
                    \RedeSocial\helper::alerta('Amizade Aceita');
                    \RedeSocial\helper::redirect(INCLUDE_PATH);
                    }else{
                        \RedeSocial\helper::alerta('Não mexa na URL');
                        \RedeSocial\helper::redirect(INCLUDE_PATH);
                    }
                }

                if (isset($_POST['publicacao'])) {

                    $img = '';

                    if ($_POST['publicacao_content'] == '') {
                        \RedeSocial\helper::alerta('Publicacao Vazia, por favor escreva algo antes de publicar');
                        \RedeSocial\helper::redirect(INCLUDE_PATH);
                    }

                    if($_FILES['file']['tmp_name']!=""){
                        $file = $_FILES['file'];
                        $fileExt = explode('.',$file['name']);
                        $fileExt = $fileExt[count($fileExt)-1];
                        if ($fileExt == 'png' || $fileExt =='jpg' || $fileExt == 'jpeg') {
                            $size = intval($file['size']/1024);
                            if ($size<=600) {
                                $img = uniqid().'.'.$fileExt;
                                move_uploaded_file($file['tmp_name'],'D:\php\xamp\htdocs\projeto_rede_social/uploads/'.$img);
                            }else{
                                \RedeSocial\helper::alerta('A foto esta acima do tamanho permitido');
                                \RedeSocial\helper::redirect(INCLUDE_PATH);
                            }
                        }else{
                            \RedeSocial\helper::alerta('Formato não condisente');
                            \RedeSocial\helper::redirect(INCLUDE_PATH);
                        }
                    }
                    \RedeSocial\Models\HomeModel::postFeed($_POST['publicacao_content'],$img);
                    \RedeSocial\helper::alerta('Publicação realizada');
                    \RedeSocial\helper::redirect(INCLUDE_PATH);

                }

                \RedeSocial\views\MainView::render('home');
           }else{

                if (isset($_POST['login'])) {
                    $login = $_POST['email'];
                    $senha = $_POST['senha'];

                    $verifica = \RedeSocial\connect_banco::connect()->prepare("SELECT * FROM usuarios WHERE email=?");
                    $verifica->execute(array($login));

                    if ($verifica->rowCount()==0){
                        \RedeSocial\helper::alerta('E-mail não cadastrado');
                        \RedeSocial\helper::redirect(INCLUDE_PATH);

                    }else{
                        $dados = $verifica->fetch();
                        $senhaCrypt = $dados['senha'];

                        if (\RedeSocial\Bcrypt::check($senha,$senhaCrypt)) {
                            $_SESSION['id'] = $dados['id'];
                            $_SESSION['login'] = $dados['email'];
                            $_SESSION['nome'] = $dados['nome'];
                            $_SESSION['img_perfil'] = $dados['img_perfil'];
                            //Alerta de logado com sucesso, deixar melhor
                            \RedeSocial\helper::alerta('Logado com sucesso');
                            \RedeSocial\helper::redirect(INCLUDE_PATH);

                        }else{
                            \RedeSocial\helper::alerta('E-mail ou senha incorretos');
                            \RedeSocial\helper::redirect(INCLUDE_PATH);
                        }
                    }
                }

                \RedeSocial\views\MainView::render('login');
            }
        }
    }

?>