<?php 
	session_start();

	if (!$_SESSION['usuario']) 
		header('Location: index.php?erro=1');

	require_once('db.class.php');

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$usuario_buscado = $_POST['texto-busca']; 
	$id_usuario = $_SESSION['id_usuario'];

	$sql = " SELECT u.*, us.*
			 FROM usuarios AS u
			 LEFT JOIN usuarios_seguidores AS us ON (us.id_usuario = $id_usuario AND u.id = us.seguindo_id_usuario) 
			 WHERE u.usuario LIKE '%$usuario_buscado%' AND id <> $id_usuario "; 

	$resultado_id = mysqli_query($link, $sql);

	if($resultado_id->num_rows === 0) 
	{
		echo '<center><h5>Nenhum usuário foi encontrado.</h5></center>';
	}
	else 
	{
		//repetição para pegar todos os usuários
		while ($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)) 
		{
			echo '<div class="list-group-item" >';
			$esta_seguindo_usuario = isset($registro['id_usuario_seguidor']) && !empty($registro['id_usuario_seguidor']) ? 'S' : 'N';

			$btn_seguir_display = 'block';
			$btn_deixar_de_seguir_display = 'block';

			if ($esta_seguindo_usuario == 'N') //o usuário não está seguindo a pessoa
				$btn_deixar_de_seguir_display = 'none';//então não exibe o botão de deixar de seguir a pessoa
			else
				$btn_seguir_display = 'none';

			echo '<h4 class="list-group-item-heading">'.$registro['usuario'].'
					<button type="button" class="btn btn-default btn-seguir pull-right" style="display: '.$btn_seguir_display.'"id="btn-seguir-'.$registro['id'].'" data-id_usuario="'.$registro['id'].'" > Follow 
					</button> 
					<button type="button" class="btn btn-default btn-deixar-de-seguir pull-right" style="display: '.$btn_deixar_de_seguir_display.'" id="btn-deixar-de-seguir-'.$registro['id'].'" data-id_usuario="'.$registro['id'].'" > Unfollow 
					</button> 
				</h4> ';
			echo '<small>'.$registro['email'].'</small> <br/>';
			echo '
				';
			echo '</div>';
		}
	}
	
?>