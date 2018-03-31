<?php 
	session_start();

	if (!$_SESSION['usuario']) 
		header('Location: index.php?erro=1');

	require_once('db.class.php');

	$id_usuario = $_SESSION['id_usuario'];

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = "SELECT date_format(t.data_post, '%d %b %Y %T') AS data_formatada, t.tweet, u.usuario, t.id_tweet, t.id_usuario, u.foto
			FROM tweet AS t JOIN usuarios AS u ON (t.id_usuario = u.id)
			WHERE id_usuario = $id_usuario OR id_usuario IN (SELECT seguindo_id_usuario FROM usuarios_seguidores WHERE id_usuario = $id_usuario) ORDER BY data_post DESC";
	
	$resultado_id = mysqli_query($link, $sql);

	if ($resultado_id) 
	{
		//repetição para pegar todos os tweets
		while ($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)) 
		{
			$btn_exclui_tweet_display = 'none';

			if ($registro['id_usuario'] == $id_usuario)
				$btn_exclui_tweet_display = 'block';

			echo '<div class="list-group-item" >';
				echo '<h4 class="list-group-item-heading">
						<img src="imagens/'.$registro['foto'].'" width="50" height="50" class="img-circle">
						'.$registro['usuario'].'
						<small> - 
						'.$registro['data_formatada'].' 
						</small> 
						<button type="button" class="btn-exclui-tweet btn btn-xs btn-danger pull-right" id="btn-exclui-tweet-'.$registro['id_tweet'].'" style="display: '.$btn_exclui_tweet_display.'" data-id_tweet="'.$registro['id_tweet'].'">
							Excluir
						</button> 
					</h4>';
				echo '<p class="list-group-item-text">'.$registro['tweet'].'</p>';
			echo '</div>';
		}
	}
	else
		echo "Erro na consulta no banco de dados.";
?>