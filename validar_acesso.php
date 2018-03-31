<?php
	session_start();

	require_once('db.class.php');
	
	$usuario = $_POST['usuario'];
	$senha = md5($_POST['senha']);

    $objDb = new db();
    $link = $objDb->conecta_mysql();

	$sql = "SELECT id, usuario, email, foto FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";
	$resultado_id = mysqli_query($link, $sql); 

	if ($resultado_id)
	{
		$dados_usuario = mysqli_fetch_array($resultado_id);

		if (isset($dados_usuario['usuario']))
		{	
			//recuperar tb o id do usuário para poder salvar os tweets dele no BD
			$_SESSION['id_usuario'] = $dados_usuario['id'];
			$_SESSION['usuario'] = $dados_usuario['usuario'];
			$_SESSION['email'] = $dados_usuario['email'];
			$_SESSION['foto'] = $dados_usuario['foto'];

			header('Location: home.php');
			echo "Usuário existe.";
		}
		else
			header('Location: index.php?erro=1');

	}
	else
		echo "Erro na execução da consulta.";
?>