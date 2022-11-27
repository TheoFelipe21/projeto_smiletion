<?php

    namespace RedeSocial\Controllers;

    class RegistrarController{

        public function index(){

            if (isset($_POST['registrar'])) {
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $senha = $_POST['senha'];

                if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {

                    \RedeSocial\helper::alerta('E-mail Inválido!!');
                    \RedeSocial\helper::redirect(INCLUDE_PATH.'registrar');

                }else if(strlen($senha)<6){

                    \RedeSocial\helper::alerta('A senha deve conter um mínimo de 6 caracteres');
                    \RedeSocial\helper::redirect(INCLUDE_PATH.'registrar');

                }else if(\RedeSocial\Models\UsuariosModel::emailExists($email)){

                    \RedeSocial\helper::alerta('Este e-mail ja foi cadastrado');
                    \RedeSocial\helper::redirect(INCLUDE_PATH.'registrar');

                }else if(\RedeSocial\Models\UsuariosModel::nameExists($nome)){

                    \RedeSocial\helper::alerta('Este nome ja esta em uso');
                    \RedeSocial\helper::redirect(INCLUDE_PATH.'registrar');

                }else{

                    $senha = \RedeSocial\Bcrypt::hash($senha);
                    $registro = \RedeSocial\connect_banco::connect()->prepare("INSERT INTO usuarios VALUES (null,?,?,?,'','')");
                    $registro->execute(array($nome,$email,$senha));

                    \RedeSocial\helper::alerta('Registrado com sucesso');
                    \RedeSocial\helper::redirect(INCLUDE_PATH);
                }

            }

            \RedeSocial\views\MainView::render('registrar');
        }
    }

?>