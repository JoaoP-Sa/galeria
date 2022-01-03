<?php 
    require('lib/conexao.php');

    if(!isset($_SESSION)) session_start();

    if(empty($_POST['foto']) || empty($_SESSION['user'])){
         header('Location: galeria.php');
    }
    else{
        $pos = strpos($_POST['foto'], 'user');
        $rotaSize = strlen($_POST['foto']);

        $rota = substr($_POST['foto'], $pos, $rotaSize);


        $query = "delete from `imagens` where (rota = ?)";
        $sql = $pdo -> prepare($query);

        $apagada = $sql -> execute(array($rota));

        if($apagada){
            unlink($rota);
        }
    }
?>