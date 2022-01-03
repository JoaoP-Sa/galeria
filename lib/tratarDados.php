<?php 
    if(!isset($_SESSION)) session_start();
    if(empty($_SESSION['user'])) header('Location: ../index.php');

    function tratar_dados($dado){
        $dado = str_replace('&', '&amp', $dado);
	
        $dado = str_replace('<', '&lt;', $dado);
        $dado = str_replace('>', '&gt;', $dado);

        return $dado;
    }
?>