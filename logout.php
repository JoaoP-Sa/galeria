<?php 
    if(!isset($_SESSION)): session_start(); endif;

    session_destroy();
    header('Location: index.php');

    die();
?>