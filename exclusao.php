<?php 
    require('lib/conexao.php');
    require('lib/deleteFolder.php');
    $msg = false;

    if(!isset($_SESSION)) session_start();

    if(empty($_SESSION['user']) && empty($_SESSION['excluir'])){
        header('Location: index.php');
        die();
    }
    else if(empty($_SESSION['excluir'])){
        header('Location: galeria.php');
    }else{
        $userId = $_SESSION['user'];
        deletar_pasta($userId);
        
        $query = "delete from imagens where id_usuario = $userId";
        $sql = $pdo -> query($query);
            
        $query = "delete from usuarios where id = $userId";
        
        if($sql = $pdo -> query($query)){
            $msg = 'Sua conta foi excluída com sucesso.';
            session_destroy();
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/exclusao.css">
    <title>Exclusão</title>
</head>
<body>
    <h1><?php if(isset($msg))echo $msg; ?></h1>
    <a href="index.php">Voltar a página de login</a>
</body>
</html>