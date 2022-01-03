<?php 
     if(!isset($_SESSION)) session_start();
     if(empty($_SESSION['user'])) header('Location: ../index.php');

    function deletar_pasta($user){
        $files = glob('user/'.$user.'/*');

        foreach($files as $file){
            if(is_file($file)){
                unlink($file);
            }
        }

        rmdir('user/'.$user);
    }
?>