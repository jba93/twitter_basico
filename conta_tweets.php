<?php 
	session_start();

	if (!$_SESSION['usuario']) 
		header('Location: index.php?erro=1');

	require_once('db.class.php');

	$id_usuario = $_SESSION['id_usuario'];

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = "SELECT COUNT(*) AS qtde_tweets FROM tweet WHERE id_usuario = $id_usuario";

	$resultado_id = mysqli_query($link, $sql);

	if ($resultado_id)
	{
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
		echo $registro['qtde_tweets'];
	}
	else
		echo "Erro ao executar a query.";
?>