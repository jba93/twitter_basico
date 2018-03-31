<?php
	session_start();

	//unset() elimina índices de um array (índices usuario e email)
	unset ($_SESSION['usuario']);
	unset ($_SESSION['email']);

	header('Location: index_logout.php');
?>