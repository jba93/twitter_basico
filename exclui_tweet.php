<?php 
	session_start();

	if (!$_SESSION['usuario']) 
		header('Location: index.php?erro=1');

	require_once('db.class.php');

	$id_usuario = $_SESSION['id_usuario'];
	$excluir_id_tweet = $_POST['excluir_id_tweet'];

	echo "$id_usuario e $id_tweet";

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = "DELETE FROM tweet WHERE id_usuario = $id_usuario AND id_tweet = $excluir_id_tweet";

	$resultado_id = mysqli_query($link, $sql);

	if ($resultado_id)
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
	else
		echo "Erro ao executar a query.";
?>