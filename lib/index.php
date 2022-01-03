<?php 
    if(!isset($_SESSION)) session_start();

    if(!isset($_SESSION['user'])){
        header('Location: ../index.php');
    }
    else{
        header('Location: ../galeria.php');
    }
?>