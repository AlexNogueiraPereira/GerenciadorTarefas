<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../estilos/estilo.css">
    <title>Editar Tarefa</title>
     <style>
        body{
            background-color: #f8f8f8;
        }
        .container-color{
            background-color: #f8f8f8;
            width: 100%;
            max-width: 100%;
            height: 100%;
        }

        .navbar-custom{
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-fluid navbar navbar-expand-lg navbar-light navbar-custom">
        <a class="navbar-brand text-light" href="inicio.php">Gerenciador de Tarefas</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-light" href="inicio.php">Inserir Tarefa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="listar.php">Listar Tarefas</a>
                </li>
            </ul>
        </div>
    </div>  

    <div class="container mx-auto container-color">
        <?php
            //configurações do banco de dados
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bd_gerenciador";

            //conectando ao banco de dados
            $conn = new mysqli($servername, $username, $password, $dbname);

                //verificando a conexão
                if ($conn->connect_error) {
                    die("Conexão falhou: " . $conn->connect_error);
                }

            //verificando se o formulário foi enviado
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $id_tarefa = $_POST['id_tarefa'];

                //obtém os dados do formulário e valida/sanitiza
                $titulo = isset($_POST['titulo']) ? validateAndSanitize($_POST['titulo']) : "";
                $descricao = isset($_POST['descricao']) ? validateAndSanitize($_POST['descricao']) : "";
                $data_vencimento = isset($_POST['data_vencimento']) ? validateAndSanitize($_POST['data_vencimento']) : "";
                $prioridade = isset($_POST['prioridade']) ? validateAndSanitize($_POST['prioridade']) : "";

                //preparando a instrução SQL que irá atualizar os dados
                $stmt = $conn->prepare("UPDATE tarefas SET titulo = ?, descricao = ?, data_vencimento = ?, prioridade = ? WHERE id_tarefa = ?");

                    //verifica se a preparação foi bem-sucedida
                    if ($stmt === false) {
                        die("Erro na preparação da instrução SQL: " . $conn->error);
                    }

                //bind dos parâmetros
                $stmt->bind_param("ssssi", $titulo, $descricao, $data_vencimento, $prioridade, $id_tarefa);

                //executando a instrução preparada
                    if ($stmt->execute()) {
                        echo "<br>Tarefa atualizada com sucesso!";
                        echo "<br><br><a class='btn btn-primary' href='listar.php' role='button'>Voltar</a>";
                    } else {
                        echo "Erro ao atualizar tarefa: " . $stmt->error;
                    }

                //fechando o statement
                $stmt->close();
            }

                //função para validar e sanitizar dados
                function validateAndSanitize($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }
        ?>
</div></body></html>