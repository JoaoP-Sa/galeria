<?php 
    require('lib/conexao.php');

    $erro = false;

    if(!empty($_POST)){
        $usuario = $_POST['user'];
        $nome = $_POST['name'];
        $senha = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if(empty($usuario) || empty($nome) || empty($senha)){
            $erro = '<br /><p class="erro">usuário, nome e/ou ou senha vazio(s)</p>';
        }
        else{
            $query = "select id from `usuarios` where usuario = ?";

            $sql = $pdo -> prepare($query);
            $sql -> execute(array($usuario));

            $count = $sql -> rowCount();

            if($count != 0){
                $erro = "<br /><p class=\"erro\">Esse usuário já existe. No campo \"Nome\" você pode escolher o nome que quiser, no entanto, o campo \"Usuário\" deve ser único.</p>";
            }
            else{
                $query = 'insert into `usuarios` (usuario, nome, senha) values (?, ?, ?)';

                $sql = $pdo -> prepare($query);
                $sql -> execute(array($usuario, $nome, $senha));

                $query = "select id from `usuarios` where usuario = ?";
                $sql = $pdo -> prepare($query);
                $sql -> execute(array($usuario));

                $usuarioInfo = $sql -> fetchAll(PDO::FETCH_ASSOC);
                $usuarioInfo = $usuarioInfo[0];

                mkdir('user/'.$usuarioInfo['id']);

                if(!isset($_SESSION)){
                    session_start();
                    $_SESSION['user'] = $usuarioInfo['id'];

                    header('Location: galeria.php');
                }
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
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;800&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Registro</title>
</head>
<body>
    <section class="form-section">
        <form method="post">
            <fieldset>
                <h3>Registro</h3>

                <div class="input-container">
                    <i class="fas fa-user"></i>
                    <input class="input-txt" type="text" name="user" placeholder="Usuário" />
                </div>

                <div class="input-container">
                    <i class="fas fa-pen"></i>
                    <input class="input-txt" type="text" name="name" placeholder="Nome" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" />
                </div>
                
                <div class="input-container">
                    <i class="fas fa-lock"></i>
                    <input class="input-txt" type="password" name="password" placeholder="Senha" />
                </div>

                <?php echo $erro; ?>

                <input type="submit" value="Enviar">
                <br />
               <p>Já tem uma conta? </p><a href="index.php">Logar</a>
            </fieldset>
        </form>
    </section>
</body>
</html>