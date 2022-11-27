<?php

    namespace RedeSocial\Controllers;

    class AmigosController{

        public function index(){
            if (isset($_SESSION['login'])){
                if (isset($_GET['solicitarAmizade'])) {
                    $idPara = (int) $_GET['solicitarAmizade'];
                    if (\RedeSocial\Models\UsuariosModel::solicitarAmizade($idPara)) {
                        \RedeSocial\helper::alerta('Amizade Solicitada!');
                        \RedeSocial\helper::redirect(INCLUDE_PATH.'amigos');

                    }else{
                        \RedeSocial\helper::alerta('Erro Inesperado!!!');
                        \RedeSocial\helper::redirect(INCLUDE_PATH.'amigos');
                    }
                }

                \RedeSocial\views\MainView::render('amigos');

            }else {
                \RedeSocial\helper::redirect(INCLUDE_PATH);
            }
        }
    }


?>