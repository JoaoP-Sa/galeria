<?php 
    require('./lib/conexao.php');

    $erro = false;

    if(!empty($_POST)){
        $usuario = $_POST['user'];
        $senha = $_POST['password'];

        if(empty($usuario) || empty($senha)){
            $erro = '<div class="erro"><p><i class="fas fa-exclamation-triangle"></i>Usuário e/ou senha vazio(s)</p></div>';
        }
        else{
            $query = 'select * from `usuarios` where usuario = ?';
            $sql = $pdo -> prepare($query);

            $sql -> execute(array($usuario));

            $count = $sql -> rowCount();

            if($count != 0){
                $usuarioInfo = $sql -> fetchAll(PDO::FETCH_ASSOC);
                $usuarioInfo = $usuarioInfo[0];

                $checkPassword = password_verify($senha, $usuarioInfo['senha']);

        
                if($checkPassword){
                    if(!isset($_SESSION)){
                        session_start();
        
                        $_SESSION['user'] = $usuarioInfo['id'];
                        header('Location: galeria.php');
                    }
                }
                else{
                    $erro = "<div class=\"erro\"><p><i class=\"fas fa-exclamation-triangle\"></i>Usuário e/ou senha incorreto(s).</p></div>";
                }
            }else{
                $erro = "<div class=\"erro\"><p><i class=\"fas fa-exclamation-triangle\"></i>Usuário e/ou senha incorreto(s).</p></div>";
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
    <link rel="stylesheet" href="style/registro.css">
    <link rel="stylesheet" href="style/all.min.css">
    <title>Início</title>
</head>
<body>
    <section class="form-section">
        <form method="post">
            <fieldset>
                <h3>Login</h3>

                <div class="input-container">
                    <i class="fas fa-user"></i>
                    <input class="input-txt" type="text" name="user" placeholder="Usuário" value="<?php if(isset($_POST['user'])) echo $_POST['user']; ?>" />
                </div>

                <div class="input-container">
                    <i class="fas fa-lock"></i>
                    <input class="input-txt" type="password" name="password" placeholder="Senha" />
                </div>

                <?php echo $erro; ?>

                <input type="submit" value="Enviar">
               <p>Ainda não tem conta? </p><a href="registro.php">Criar conta</a>
            </fieldset>
        </form>
    </section>
</body>
</html>