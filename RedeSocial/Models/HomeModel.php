<?php

    namespace RedeSocial\Models;

    class HomeModel{

        public static function postFeed($post,$img){

            if ($img=='') {
                $img = '';
            }

            $pdo = \RedeSocial\connect_banco::connect();

            $post = strip_tags($post);


            $postFeed = $pdo->prepare("INSERT INTO `publicacoes` VALUES(null, ?,?,?,?)");
            $postFeed->execute(array($_SESSION['id'],$post, date('Y-m-d H:i:s', time()), $img));

            $atualizaUsuario = $pdo->prepare("UPDATE usuarios SET ultima_publicacao = ? WHERE id= ?");
            $atualizaUsuario->execute(array(date('Y-m-d H:i:s', time()),$_SESSION['id']));
        }



        public static function retrieveFriendsPosts(){
			$pdo = \RedeSocial\connect_banco::connect();

			$amizades = $pdo->prepare("SELECT * FROM amizades WHERE (pedinte = ? AND status = 1) OR (receptor = ? AND status = 1)");
			$amizades->execute(array($_SESSION['id'],$_SESSION['id']));

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

				$listaAmigos[$key]['id'] = \RedeSocial\Models\UsuariosModel::pegaUsuarioPorId($value)['id'];
				$listaAmigos[$key]['nome'] = \RedeSocial\Models\UsuariosModel::pegaUsuarioPorId($value)['nome'];
				$listaAmigos[$key]['email'] = \RedeSocial\Models\UsuariosModel::pegaUsuarioPorId($value)['email'];
				$listaAmigos[$key]['img_perfil'] = \RedeSocial\Models\UsuariosModel::pegaUsuarioPorId($value)['img_perfil'];
				$listaAmigos[$key]['ultima_publicacao'] = \RedeSocial\Models\UsuariosModel::pegaUsuarioPorId($value)['ultima_publicacao'];

			}
			usort($listaAmigos,function($a,$b){
                    if(strtotime($a['ultima_publicacao']) >  strtotime($b['ultima_publicacao'])){
                        return -1;

                    }else{
                        return +1;
                    }

			    }
            );

			$me = $pdo->prepare("SELECT * FROM usuarios WHERE id = $_SESSION[id]");
			$me->execute();
			$me = $me->fetch();

			$posts = [];

			foreach ($listaAmigos as $key => $value) {
				$ultimoPost = $pdo->prepare("SELECT * FROM publicacoes WHERE usuario_id = ? ORDER BY data DESC");
				$ultimoPost->execute(array($value['id']));

				$meusPosts= $pdo->prepare("SELECT * FROM publicacoes WHERE usuario_id = $_SESSION[id] ORDER BY data DESC");
				$meusPosts->execute();

				if(($ultimoPost->rowCount() >= 1) && ($meusPosts->rowCount() >= 1)){
					$meusPosts = $meusPosts->fetchAll();
					$ultimoPost = $ultimoPost->fetchAll();
					foreach ($ultimoPost as $chave => $valor) {
							$posts[$key][$chave]['usuario'] = $value['nome'];
							$posts[$key][$chave]['img_perfil'] = $value['img_perfil'];
							$posts[$key][$chave]['data'] = $valor['data'];
							$posts[$key][$chave]['conteudo'] = $valor['publicacao'];
							$posts[$key][$chave]['imagem'] = $valor['img'];
					}
				}
			}
			return $posts;
		}
    }
?>