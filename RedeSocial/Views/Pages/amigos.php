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
		<link href="<?php echo INCLUDE_PATH_STATIC ?>Styles/amigos.css" rel="stylesheet">


	</head>

	<body>

		<section class="main-feed">
			<?php include('includes/sidebar.php'); ?>
			<div class="feed">
				<div class="amigos">
					<div class="container-amigos">
						<h4>Amigos</h4>
						<div class="container-amigos-wraper">
							<?php
								foreach(\RedeSocial\Models\UsuariosModel::listarAmigos() as $key => $value){
							?>
							<div class="container-amigos-single">
								<div class="img-amigos-user-single">
									<?php
										if($value['img_perfil'] ==''){
									?>
									<img src="<?php echo INCLUDE_PATH_STATIC ?>images/avatar.png" />

									<?php }else{ ?>
										<img src="<?php echo INCLUDE_PATH ?>uploads_perfil/<?php echo $value['img_perfil']?>" />
									<?php } ?>
								</div>
								<div class="info-amigos-user-single">
									<h2><?php echo $value['nome'];?></h2>
									<p><?php echo $value['email'];?></p>
								</div>
							</div>

							<?php } ?>

						</div>
					</div>
					<br/>

					<div class="container-amigos">
						<h4>Comunidade</h4>
						<div class="container-amigos-wraper">
							<?php

								$comunidade = RedeSocial\Models\UsuariosModel::listarComunidade();
								foreach ($comunidade as $key => $value) {

									$pdo = \RedeSocial\connect_banco::connect();
									$verificaAmizade = $pdo->prepare("SELECT * FROM amizades WHERE (pedinte = ? AND receptor = ? AND status = 1)
									OR (pedinte = ? AND receptor = ? AND status = 1)");
									$verificaAmizade ->execute(array($value['id'], $_SESSION['id'],$_SESSION['id'], $value['id']));

									if ($verificaAmizade->rowCount()==1) {
										continue;
									}

									if ($value['id'] == $_SESSION['id']) {
										continue;
									}

							?>
							<div class="container-amigos-single">
								<div class="img-amigos-user-single">
								<?php
									if($value['img_perfil'] ==''){
								?>
									<img src="<?php echo INCLUDE_PATH_STATIC ?>images/avatar.png" />

								<?php }else{ ?>
									<img src="<?php echo INCLUDE_PATH ?>uploads_perfil/<?php echo $value['img_perfil']?>" />
								<?php } ?>
								</div>
								<div class="info-amigos-user-single">
									<h2><?php echo $value['nome'];?></h2>
									<p><?php echo $value['email'];?></p>
									<div class="btn-solicitar-amizade">
										<?php
											if (RedeSocial\Models\UsuariosModel::existePedidoAmizade($value['id'])) {
										?>
										<a href="<?php echo INCLUDE_PATH ?>amigos?solicitarAmizade=<?php echo $value['id'];?>">Solicitar Amizade</a>
										<?php }else{ ?>
											<a href="javascript:void(0)" style= "border:none; color: #FF8C00">Pedido Pendente</a>
										<?php }?>
									</div>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</section>


	</body>


</html>