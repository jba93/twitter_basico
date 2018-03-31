<?php
	session_start();

	if (!$_SESSION['usuario']) 
		header('Location: index.php?erro=1');

	require_once('db.class.php');

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$id_usuario = $_SESSION['id_usuario'];
	
	//recuperar quantidade de tweets
	$qtde_tweets = 0;
	$sql = "SELECT COUNT(*) AS qtde_tweets FROM tweet WHERE id_usuario = $id_usuario";

	$resultado_id = mysqli_query($link, $sql);

	if ($resultado_id)
	{
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
		$qtde_tweets = $registro['qtde_tweets'];
	}
	else
		echo "Erro ao executar a query.";

	$foto = '';
	$sql = "SELECT foto FROM usuarios WHERE id = $id_usuario";

	$resultado_id = mysqli_query($link, $sql);

	if ($resultado_id)
	{
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
		$foto = $registro['foto'];		
	}
	else
		echo "Erro ao executar a query.";

	//recuperar quantidade de seguidores
	$qtde_seguidores = 0;
	$sql = "SELECT COUNT(*) AS qtde_seguidores FROM usuarios_seguidores WHERE seguindo_id_usuario = $id_usuario";

	$resultado_id = mysqli_query($link, $sql);

	if ($resultado_id)
	{
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
		$qtde_seguidores = $registro['qtde_seguidores'];
	}
	else
		echo "Erro ao executar a query.";
?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Twitter - Início</title>
		<link rel="icon" href="imagens/icone_twitter.png">

		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script type="text/javascript">

			$(document).ready( function()
			{
				$('#texto-tweet').keypress(function(e) 
				{
					$('#form-tweet').submit(false); 
				    if (e.keyCode == 13)
				        $('#btn-tweet').click();
				});
				
				$('#texto-busca').keypress(function(e) 
				{
					$('#form-busca').submit(false);
				    if (e.keyCode == 13)
				        $('#btn-busca').click();
				});	

				$('#btn-tweet').click( function()
				{
					if($('#texto-tweet').val().length > 0) 
					{
						$.ajax({
							url: 'inclui_tweet.php',
							method: 'POST',
							data: $('#form-tweet').serialize(),
							success: function(data){	
										$('#texto-tweet').val('');
										atualizaTweet();
										atualizaQtdeTweets();
									}
						});
					}
				});

				//atualizar a div de tweets sem precisar recarregar a página
				function atualizaTweet()
				{
					$.ajax({
						url: 'get_tweet.php', 
						success: function (data)
						{
							$('#tweets').html(data);
							$('.btn-exclui-tweet').click( function()
							{
								var id_tweet = $(this).data('id_tweet'); 
								$.ajax({
									url: 'exclui_tweet.php',
									method: 'POST',
									data: { excluir_id_tweet: id_tweet },
									success: function(data){
												alert ('Tweet removido com sucesso!');
												atualizaTweet();
												atualizaQtdeTweets();
									}
								});
							});
						}
					});
				}

				function atualizaQtdeTweets()
				{
					$.ajax({
						url: 'conta_tweets.php', 
						success: function (data){
							$('#qtde_tweets').html(data);
						}
					});
				}

				atualizaTweet();
				atualizaQtdeTweets();

				$('#btn-busca').click( function()
				{
					if($('#texto-busca').val().length > 0) 
					{
						$.ajax({
							url: 'procurar_pessoas.php',
							method: 'POST',
							data: $('#form-busca').serialize(),
							success: function(data)
									{	
										$('#result-busca').html(data);
										$('.btn-seguir').click( function()
										{
											var id_usuario = $(this).data('id_usuario'); 
											$('#btn-seguir-'+id_usuario).hide();
											$('#btn-deixar-de-seguir-'+id_usuario).show();

											$.ajax({
												url: 'seguir.php',
												method: 'POST',
												data: { seguir_id_usuario: id_usuario },
												success: function(data){
													atualizaTweet();
												}
											});
										});

										$('#texto-busca').val('');
										$('.btn-deixar-de-seguir').click( function()
										{
											var id_usuario = $(this).data('id_usuario'); 

											$('#btn-seguir-'+id_usuario).show();
											$('#btn-deixar-de-seguir-'+id_usuario).hide();

											$.ajax({
												url: 'deixar_de_seguir.php',
												method: 'POST',
												data: { deixar_de_seguir_id_usuario: id_usuario },
												success: function(data){
													atualizaTweet();
												}
											});
										});
									}
						});
					}
				});
				
			});
		</script>
	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a href="home.php"><img src="imagens/icone_twitter.png"></a>
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	          	<li><a href="home.php">Home</a></li>
	            <li><a id="link-sair" href="sair.php">Sair</a></li>
	          </ul>
	        </div>
	      </div>
	    </nav>

	    <div class="container">

	    	<div class="col-md-3"s>
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				<?php  
	    					echo '<img src="imagens/'.$foto.'" width="222" height="240" class="img-rounded"> ';
	    				?> 
	    				<h4><?= $_SESSION['usuario'] ?></h4>
	    				<hr/> 
	    				<div class="col-md-6">
	    					TWEETS<br/> <div id="qtde_tweets"><?= $qtde_tweets ?></div> 
	    				</div>
	    				<div class="col-md-6">
							SEGUIDORES<br/> <div id="qtde_seguidores"><?= $qtde_seguidores ?></div>
	    				</div>
	    			</div>
	    		</div>
	    	</div>


	    	<div class="col-md-6">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				<form id="form-tweet" class="input-group"> <!-- agrupa botão e caixa de texto -->
	    					<input type="text" class="form-control" id="texto-tweet" name="texto-tweet" placeholder="O que está acontecendo agora?" maxlength="140"> <!-- 140 caracteres -->
	    					<span class="input-group-btn">
	    						<button class="btn btn-default" id="btn-tweet" type="button">Tweet</button>
	    					</span>
	    				</form>
	    			</div>
	    		</div>

	    		<!-- div onde aparecem os tweets já postados -->
	    		<div id="tweets" class="list-group"> </div>

			</div>

			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<h4>Buscar pessoas no Twitter</h4>
					</div>

					<form id="form-busca" class="input-group"> <!-- agrupa botão e caixa de texto -->
	    					<input type="text" class="form-control" id="texto-busca" name="texto-busca" placeholder="Digite o nome da pessoa que você procura"/>
	    					<span class="input-group-btn">
	    						<button class="btn btn-default" id="btn-busca" type="button">Buscar</button>
	    					</span>
	    			</form>

	    			<!-- div onde aparecem os usuários buscados -->
	    			<div id="result-busca"> </div>
				</div>
			</div>

		</div>
		
		<!-- Adiciona o JS depois que os elementos que receberão suas funções estarem renderizados no navegador -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	</body>
</html>

