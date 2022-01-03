<?php
    require('lib/conexao.php');
    require('lib/upload.php');
    require('lib/tratarDados.php');

    if(!isset($_SESSION)):session_start();endif;
    $_SESSION['excluir'] = false;
    

    if(empty($_SESSION['user'])){
        header('Location: index.php');
        die();
    }else{
        $erro = false;
        $sucesso = false;

        $query = "select `nome` from `usuarios` where id = $_SESSION[user]";
        $sql = $pdo -> query($query);

        $info = $sql -> fetchAll(PDO::FETCH_ASSOC);
        $nome = $info[0]['nome'];

        $out = ob_get_contents();
        if(ob_get_contents())ob_end_clean();

        if($out){
            $erro = '<br /><span class="php-msg erro">Arquivo muito grande! O tamanho máximo permitido é 2MB.</span>';
        }

        if(!empty($_FILES['foto']['type'])){
            $FILES = $_FILES['foto'];
            $titulo = $_POST['titulo'];
            $desc = $_POST['descricao'];

            if(empty($titulo) || empty($desc)){
                $erro = '<br /><span class="php-msg erro">Coloque título e descrição na foto.</span>';
            }else{
                $rota = enviar_arquivo($FILES['name'], $FILES['tmp_name'], $FILES['error'], $FILES['size'], $_SESSION['user']);
    
                if($rota){
                    $titulo = tratar_dados($titulo);
                    $desc = tratar_dados($desc);

                    $query = "insert into `imagens`(id_usuario, rota, titulo, descricao) values(?, ?, ?, ?)";
                    $sql = $pdo -> prepare($query);
    
                    $sql -> execute(array($_SESSION['user'], $rota, $titulo, $desc));

                    $erro = false;
                    $sucesso = '<br /><span class="php-msg sucesso">Sua foto foi enviada com sucesso.</span>';
                }
            }
        }
        else{
            $erro = '<br /><span class="php-msg">Selecione alguma foto para enviar.</span>';
        }

        if(isset($_POST['excluir'])){
            if(boolval($_POST['excluir'])){
                $_SESSION['excluir'] = true;
                header('Location: exclusao.php');
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/nova-foto.css">
    <link rel="stylesheet" href="style/all.min.css">
    <title>Nova Foto</title>
</head>
<body>
    <section class="pop-up-container" id="popUpContainer">
        <div class="pop-up" id="pop-up">
            <form method="post">
                <h2>Você tem certeza que deseja excluir sua conta <strong>permanentemente?</strong></h2>
                <button id="yes" type="submit" name="excluir" value="1">Sim</button>
                <button id="no" name="excluir" onclick="return false;" value="0">Não</button>
            </form>
        </div>
    </section>

    <header>
        <h2><i class="fas fa-user-circle"></i>&nbsp;&nbsp;<?php echo $nome; ?></h2>
        <nav class="desktop">
            <ul>
                <li><a href="galeria.php"><i class="fas fa-arrow-left"></i><span>Voltar</span></a></li>
                <li><a id="exclusao" href="#" onclick="return false;"><i class="far fa-times-circle"></i><span>Excluir Conta</span></a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Sair</span></a></li>
            </ul>
        </nav>
        <i id="mobile-btn" class="fas fa-bars mobile"></i>
    </header>

    <nav class="mobile nav-mobile" id="menu-mobile">
        <ul>
        <li><a href="galeria.php"><i class="fas fa-arrow-left"></i> <span>Voltar</span></a></li>
            <li><a id="exclusao-mobile" href="#" onclick="return false;"><i class="far fa-times-circle"></i> <span>Excluir Conta</span></a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Sair</span></a></li>
        </ul>
    </nav>

    <section class="form-section">
        <form method="post" enctype="multipart/form-data">
            <h3>Nova Foto</h3>
            <fieldset>
                <input type="text" name="titulo" placeholder="Nome da Foto" />
                <textarea placeholder="Descrição da Foto" name="descricao" ></textarea>

                <input type="file" id="foto" name="foto" />
                <label class="input-file-label" for="foto"><i class="fas fa-image"></i> <span id="span-select">Selecione uma imagem</span></label>
                <input type="submit" value="Enviar">
            </fieldset>

            <?php echo $erro; echo $sucesso;?>
        </form>
    </section>

    <script src="js/popUp.js"></script>
    <script src="js/slideToggle.js"></script>
    <script src="js/checarArquivos.js"></script>
    <footer><span>Todos os direitos reservados.</span></footer>
</body>
</html>