<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/estilo.css">
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

                // Verifica a conexão
                if ($conn->connect_error) {
                    die("Conexão falhou: " . $conn->connect_error);
                }

            //consulta SQL para obter detalhes da tarefa
            $sql = "SELECT * FROM tarefas WHERE id_tarefa = $id_tarefa";
            $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    echo "<h2>Confirmação de Exclusão</h2>";
                    echo "<p><strong>ID da tarefa:</strong> " . $row["id_tarefa"] . "</p>";
                    echo "<p><strong>Tarefa:</strong> " . $row["titulo"] . "</p>";
                    echo "<p><strong>Descrição:</strong> " . $row["descricao"] . "</p>";
                    echo "<p><strong>Prioridade:</strong> " . $row["prioridade"] . "</p>";
                    echo "<p><strong>Tarefa criada em:</strong> " . $row["data_adicionada"] . "</p>";

                    echo '<form action="excluir.php" method="post">';
                    echo '<input type="hidden" name="id_tarefa" value="' . $row["id_tarefa"] . '">';
                    echo '<button class="btn btn-primary" type="submit" name="confirmar" value="Confirmar Exclusão">Confirmar Exclusão</button>';
                    echo ' ';
                    echo '<button class="btn btn-primary" type="submit" name="cancelar" value="Cancelar">Cancelar</button>';
                    echo '</form>';

                } else {
                    echo "Tarefa não encontrada.";
                }

            //fecha a conexão com o banco de dados
            $conn->close();

        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['confirmar'])) {
                // Verifica se o formulário foi enviado
                $id_tarefa = $_POST['id_tarefa'];
                $sql_delete = "DELETE FROM tarefas WHERE id_tarefa = $id_tarefa";

                //vonexão com o banco de dados
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "bd_gerenciador";

                $conn = new mysqli($servername, $username, $password, $dbname);

                    //verifica a conexão
                    if ($conn->connect_error) {
                        die("Conexão falhou: " . $conn->connect_error);
                    }

                    if ($conn->query($sql_delete) === TRUE) {
                        echo "<br>Tarefa excluída com sucesso.";
                        echo "<br><br><a class='btn btn-primary' href='inicio.php' role='button'>Voltar</a>";
                    } else {
                        echo "Erro ao excluir tarefa: " . $conn->error;
                    }

            } else {
                header("Location: listar.php");
                exit();
            }

            //fecha a conexão com o banco de dados após a exclusão
            $conn->close();

        } else {
            echo "ID da tarefa não fornecido.";
        }
    ?>
</div></body></html>