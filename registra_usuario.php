<?php
    require_once('db.class.php');
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);
    $foto = $_FILES['foto'];

    //tratamento para armazenar a imagem
    $extensao = strtolower(substr($_FILES['foto']['name'], -4));
    $novo_nome = md5(time()).$extensao;
    $diretorio = "imagens/";
    //armazena a foto postada no meu servidor, na pasta imagens do projeto
    move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$novo_nome);

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $usuario_existe = false;
    $email_existe = false;

    //verificar se o usuario digitado já existe (não pode ser duplicado)
    $sql = " SELECT * FROM usuarios WHERE usuario = '$usuario' ";
    if ($resultado_id = mysqli_query($link, $sql))
    {
        $dados_usuario = mysqli_fetch_array($resultado_id);
        if (isset($dados_usuario['usuario']))
            $usuario_existe = true;
    }
    else
        echo "Erro ao tentar encontrar o registro de usuário.";

    //verificar se o e-mail digitado já existe (não pode ser duplicado)
    $sql = " SELECT * FROM usuarios where email = '$email' ";
    if ($resultado_id = mysqli_query($link, $sql))
    {
        $dados_usuario = mysqli_fetch_array($resultado_id);
        if (isset($dados_usuario['email']))
            $email_existe = true;
    }
    else
        echo "Erro ao tentar encontrar o registro de e-mail.";

    //para por uma mensagem de erro caso o e-mail ou usuário já exista
    if ( $usuario_existe || $email_existe ) 
    {
        $retorno_get = '';

        if ($usuario_existe)
            $retorno_get .= "erro_usuario=1&";

        if ($email_existe)
            $retorno_get .= "erro_email=1&";

        header('Location: inscrevase.php?'.$retorno_get);
        die(); 
    }

    //armazena os dados no MySQL
    $sql = "INSERT INTO usuarios(usuario, email, senha, foto) VALUES ('$usuario', '$email', '$senha', '$novo_nome')";

    if(mysqli_query($link, $sql))
        header('Location: index_inscricao.php');
    else
        echo "Erro no baco de dados ao registrar o(a) usuário(a)!";
?>