<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Estilos/estilo.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Gerenciador de Tarefas</title>
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
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_tarefa'])) {
                $id_tarefa = $_GET['id_tarefa'];

                //configurações do banco de dados
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "bd_gerenciador";

                //conexão com o banco de dados
                $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Conexão falhou: " . $conn->connect_error);
                    }

                //atualiza o status da tarefa para "concluida"
                $stmt = $conn->prepare("UPDATE tarefas SET status = 'concluida' WHERE id_tarefa = ?");
            
                //verifica se a preparação foi bem-sucedida
                    if ($stmt === false) {
                        die("Erro na preparação da instrução SQL: " . $conn->error);
                    }

                //bind do parâmetro
                $stmt->bind_param("i", $id_tarefa);

                    //executa a instrução preparada
                    if ($stmt->execute()) {
                        echo "<br>Tarefa concluída com sucesso!";
                        echo "<br><br><a class='btn btn-primary' href='listar.php' role='button'>Voltar</a>";
                    } else {
                        echo "Erro ao concluir tarefa: " . $stmt->error;
                    }

                // Fecha o statement e a conexão
                $stmt->close();
                $conn->close();
            } else {
                echo "ID da tarefa não fornecido.";
            }
        ?>
</div></body></html>