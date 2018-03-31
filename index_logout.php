<?php
	$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Twitter - Página inicial</title>
		<link rel="icon" href="imagens/icone_twitter.png">

		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	
		<script type="text/javascript">
			$(document).ready( function ()
			{

				//verificar se usuário e senha foram devidamente preenchidos
				$('#btn_login').click(function()
				{
					var campo_vazio = false;
					if ($('#campo_usuario').val() == '')
					{
						$('#campo_usuario').css({'border-color': 'red'});
						campo_vazio = true;
					}else
					{	//volta a cor normal
						$('#campo_usuario').css({'border-color': ''});
					}

					if ($('#campo_senha').val() == '')
					{
						$('#campo_senha').css({'border-color': 'red'});
						campo_vazio = true;
					}else
					{	//volta a cor normal
						$('#campo_senha').css({'border-color': ''});
					}

					if (campo_vazio) 
					{
						return false; //cancela o envio do formulário
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
	          <img src="imagens/icone_twitter.png" />
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="inscrevase.php">Inscrever-se</a></li>

	          	<!-- se houver erro de login, a aba do login continua aberta -->
	            <li class=" <?php echo $erro == 1 ? 'open' : '' ?>">

	            	<a id="entrar" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Entrar</a>
					<ul class="dropdown-menu" aria-labelledby="entrar">
						<div class="col-md-12">
				    		<p>Já possui uma conta?</h3>
				    		<br />
							<form method="post" action="validar_acesso.php" id="formLogin">
								<div class="form-group">
									<input type="text" class="form-control" id="campo_usuario" name="usuario" placeholder="Usuário" />
								</div>
								
								<div class="form-group">
									<input type="password" class="form-control red" id="campo_senha" name="senha" placeholder="Senha" />
								</div>
								
								<button type="buttom" class="btn btn-primary" id="btn_login">Entrar</button>

								<br/><br/>
							</form>

							<?php
								if ($erro == 1)
									echo '<font color= red> Usuário e/ou senha inválidos. </font>';
							?>

						</div>
				  	</ul>
	            </li>
	          </ul>
	        </div>
	      </div>
	    </nav>


	    <div class="container">
		    <div class="jumbotron">
		        <h1>Bem vindo ao Twitter</h1>
		        <p>Veja o que está acontecendo no mundo agora</p>
		    </div>

			<div>
			    <center><h4 class="btn-success">Logout realizado com sucesso!</h4></center>	
			</div>

		    <div class="clearfix"></div>
	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>