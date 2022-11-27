<?php

    namespace RedeSocial\Models;

    class UsuariosModel{

        public static function emailExists($email){

            $pdo = \RedeSocial\connect_banco::connect();
            $verificar = $pdo->prepare("SELECT email FROM usuarios WHERE email = ?");
            $verificar->execute(array($email));

            if($verificar->rowCount()==1){

                return true;
            }else{

                return false;
            }
        }


        public static function nameExists($name){

            $pdo = \RedeSocial\connect_banco::connect();
            $verificar = $pdo->prepare("SELECT nome FROM usuarios WHERE nome = ?");
            $verificar->execute(array($name));

            if($verificar->rowCount()==1 ){

                return true;
            }else{

                return false;
            }
        }

        public static function nameExistsPerfil($name,$nome){

            $pdo = \RedeSocial\connect_banco::connect();
            $verificar = $pdo->prepare("SELECT nome FROM usuarios WHERE nome = ?");
            $verificar->execute(array($name));

            if(($verificar->rowCount()==1) && ($name!=$nome)){

                return true;
            }else{

                return false;
            }
        }


        public static function listarComunidade(){

            $pdo = \RedeSocial\connect_banco::connect();

            $comunidade = $pdo->prepare("SELECT * FROM usuarios");
            $comunidade->execute();

            return $comunidade->fetchAll();
        }


        public static function solicitarAmizade($idPara){

            $pdo = \RedeSocial\connect_banco::connect();

            $verificaAmizade = $pdo->prepare("SELECT * FROM amizades WHERE (pedinte = ? AND receptor = ?) OR (pedinte = ? AND receptor = ?)");
            $verificaAmizade->execute(array($_SESSION['id'], $idPara, $idPara, $_SESSION['id']));

            if ($verificaAmizade->rowCount() == 1) {
                return false;

            }else{
                //Podemos inserir no banco
                $insertAmizade = $pdo->prepare("INSERT INTO amizades VALUES (null,?,?,0)");

                if($insertAmizade->execute(array($_SESSION['id'], $idPara))){
                    return true;
                }
            }

            return true;
        }


        public static function listarPedidosAmizade(){

            $pdo = \RedeSocial\connect_banco::connect();

            $listarPedidosAmizade = $pdo->prepare("SELECT * FROM amizades WHERE  receptor = ? AND status = 0");
            $listarPedidosAmizade->execute(array($_SESSION['id']));

            return $listarPedidosAmizade->fetchAll();
        }


        public static function pegaUsuarioPorId($id){

            $pdo = \RedeSocial\connect_banco::connect();

            $usuario = $pdo->prepare("SELECT * FROM usuarios WHERE  id = ?");
            $usuario->execute(array($id));

            return $usuario->fetch();
        }


        public static function existePedidoAmizade($idPara){
            $pdo = \RedeSocial\connect_banco::connect();

            $verificaAmizade = $pdo->prepare("SELECT * FROM amizades WHERE (pedinte = ? AND receptor = ?) OR (pedinte = ? AND receptor = ?)");
            $verificaAmizade->execute(array($_SESSION['id'], $idPara, $idPara, $_SESSION['id']));

            if ($verificaAmizade->rowCount() == 1) {
                return false;

            }else{
                return true;
            }
        }


        public static function respostaPedidoAmizade($enviou, $status){

            if ($status ==0) {

                $pdo = \RedeSocial\connect_banco::connect();
                $del = $pdo->prepare("DELETE FROM amizades WHERE pedinte = ? AND receptor = ? AND status = 0");
                $del->execute(array($enviou, $_SESSION['id']));

            }else if($status==1){

                $pdo = \RedeSocial\connect_banco::connect();
                $aceitarPedido = $pdo->prepare("UPDATE amizades SET status = 1 WHERE pedinte = ? AND receptor = ?");
                $aceitarPedido->execute(array($enviou, $_SESSION['id']));

                if ($aceitarPedido->rowCount()==1) {
                    return true;
                }else{
                    return false;
                }
            }
        }


        public static function listarAmigos(){

            $pdo = \RedeSocial\connect_banco::connect();

            $amizades = $pdo->prepare("SELECT * FROM amizades WHERE (pedinte = ? AND status = 1) OR (receptor = ? AND status = 1)");
            $amizades->execute(array($_SESSION['id'], $_SESSION['id']));
            $amizades = $amizades->fetchAll();

            $amigosConfirmados = array();
            foreach ($amizades as $key => $value) {
                if($value['pedinte'] == $_SESSION['id']){
                    $amigosConfirmados[] = $value['receptor'];

                }else{
                    $amigosConfirmados[] = $value['pedinte'];
                }
            }

            $listaAmigos = array();

            foreach ($amigosConfirmados as $key => $value) {
                $listaAmigos[$key]['nome'] = self::pegaUsuarioPorId($value)['nome'];
                $listaAmigos[$key]['email'] = self::pegaUsuarioPorId($value)['email'];
                $listaAmigos[$key]['img_perfil'] = self::pegaUsuarioPorId($value)['img_perfil'];
            }

            return $listaAmigos;

        }

    }

?>