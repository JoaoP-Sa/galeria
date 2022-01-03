<?php 
    if(!isset($_SESSION)) session_start();
    if(empty($_SESSION['user'])) header('Location: ../index.php');

    function enviar_arquivo($name, $tmp_name, $error, $size, $user){
        global $erro;
        $path = false;


        $ext = pathinfo($name, PATHINFO_EXTENSION);

       if($error){
            $erro = '<br /><span class="php-msg erro">Ocorreu algum erro durante o envio da foto. Tente novamente.</span>';
            return false;
       }
       else if($size > 2097152){
            $erro = '<br /><span class="php-msg erro">Arquivo muito grande! O tamanho máximo permitido é 2MB.</span>';
            return false;
       }
       else if($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg'){
            $erro = '<br /><span class="php-msg erro">Formato de arquivo não aceito! Insira apenas arquivos jpg ou png.</span>';
            return false;
       }
       else{
           $fotoId = uniqid();
           $endereco = 'user/'.$user.'/'.$fotoId.'.'.$ext;

           $enviada = move_uploaded_file($tmp_name, $endereco);

           if($enviada){
               $path = $endereco;
               return $path;
           }
       }
    }
?>