<?php 
    define('HOST', 'localhost'); //nome do seu servidor local
    define('DB', 'database'); //nome do seu banco de dados
    define('USER', 'root'); //seu usuário do banco de dados
    define('PASSWORD', ''); //sua senha do banco de dados

    try{
        $pdo = new PDO("mysql:host=".HOST.";dbname=".DB, USER, PASSWORD);
    }
    catch(PDOException $e){
        echo 'A conexão com o banco de dados falhou.<br /><br />';
        die($e -> getMessage());
    }
?>