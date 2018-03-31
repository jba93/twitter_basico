<?php
	class db 
	{
		//host - endereço onde o MySQL está instalado
		private $host = 'localhost'; //é servidor local

		//usuário de conexão com o MySQL
		private $usuario = 'root'; //usuário padrão da instalação do MySQL

		//senha do usuário de conexão com o MySQL
		private $senha = ''; //senha padrão do usuário root

		//banco de dados
		private $database = 'twitter';

		public function conecta_mysql()
		{
			$con = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);
			mysqli_set_charset($con, 'utf8');

			if (mysqli_connect_errno()) 
				echo "Erro ao tentar se conectar com o MySQL: ".mysqli_connect_error();

			return $con;
		}
	}

?>