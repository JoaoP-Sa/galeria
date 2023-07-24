<?php 
    require('lib/conexao.php');
    require('lib/tratarDados.php');

    if(!isset($_SESSION)):session_start();endif;
    $_SESSION['excluir'] = false;
    $_SESSION['imagem'] = array();

    if(empty($_SESSION['user'])){
        header('Location: index.php');
        die();
    }else{
        $query = "select `nome` from `usuarios` where id = $_SESSION[user]";
        $sql = $pdo -> query($query);

        $info = $sql -> fetchAll(PDO::FETCH_ASSOC);
        $nome = $info[0]['nome'];



        $query = "select imagens.rota, imagens.titulo, imagens.descricao, imagens.data from usuarios inner join imagens on usuarios.id = $_SESSION[user] and imagens.id_usuario = usuarios.id order by data;";
        $sql = $pdo -> query($query);
        $imgInfo = $sql ? $sql -> fetchAll(PDO::FETCH_ASSOC) : [];
        
        
        foreach($imgInfo as $key){
            array_push($_SESSION['imagem'], $key);
        }


        if(isset($_POST['excluir']) && $_POST['excluir']){
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
    <link rel="stylesheet" href="style/galeria.css">
    <link rel="stylesheet" href="style/all.min.css">
    <title>Galeria</title>
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

        <div id="img-infos" class="modal-img">
            <a id="voltar" href="#" onclick="return false;">Fechar &nbsp;&#10006;</a>
            <img src="" alt="" />
            <h2 id="img-title"></h2>
            <p id="img-desc"></p>
            <div class="space-bottom"></div>
        </div>
    </section>

    <header>
        <h2><i class="fas fa-user-circle"></i>&nbsp;&nbsp;<?php echo $nome; ?></h2>
        <nav class="desktop">
            <ul>
                <li><a href="nova-foto.php"><i class="far fa-image"></i><span>Nova Foto</span></a></li>
                <li><a id="exclusao" href="#" onclick="return false;"><i class="far fa-times-circle"></i><span>Excluir Conta</span></a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Sair</span></a></li>
            </ul>
        </nav>
        <i id="mobile-btn" class="fas fa-bars mobile"></i>
    </header>

    <nav class="mobile nav-mobile" id="menu-mobile">
        <ul>
            <li><a href="nova-foto.php"><i class="far fa-image"></i> <span>Nova Foto</span></a></li>
            <li><a id="exclusao-mobile" href="#" onclick="return false;"><i class="far fa-times-circle"></i> <span>Excluir Conta</span></a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Sair</span></a></li>
        </ul>
    </nav>

    <section class="section-galeria">
        <?php if(count($_SESSION['imagem']) != 0){
                foreach($_SESSION['imagem'] as $key){?>
                <div class="foto">
                    <div class="x-content"><span>&#10006;</span></div>
                    <img src="<?php echo $key['rota']?>" alt="foto" data-title="<?php echo $key['titulo'] ?>" data-desc="<?php echo $key['descricao'] ?>"/>
                </div>
        <?php   }
               }
               else{?>
               <div class="galeria-vazia">
                    <h2>Não há nenhuma imagem para exibir ainda. Vá em "Nova Foto" e envie suas primeiras imagens.</h2>
               </div>
        <?php  }?>
    </section>

    <script src="js/deletarImagem.js"></script>
    <script src="js/popUp.js"></script>
    <script src="js/imagemModal.js"></script>
    <script src="js/slideToggle.js"></script>
    <footer><span>Todos os direitos reservados.</span></footer>
</body>
</html>