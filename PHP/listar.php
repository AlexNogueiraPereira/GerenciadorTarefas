<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../estilos/estilo.css">
    <title>Listagem de Tarefas</title>

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
         <a class="navbar-brand text-light" href="inserir.php">Gerenciador de Tarefas</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-light" href="inserir.php">Inserir Tarefa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="exibir.php">Listar Tarefas</a>
                </li>
            </ul>
        </div>
    </div>  


    <div class="container mx-auto container-color">
        <h2>Listagem de Tarefas</h2>

    <form action="exibir.php" method="post">
    <label for="sortOption">Ordenar por:</label>
    <select id="sortOption" name="sortOption">
        <?php
            $prioridadeSelected = ($sortOption == 'prioridade') ? 'selected' : '';
            $dataAdicionadaSelected = ($sortOption == 'data_adicionada') ? 'selected' : '';
        ?>
        <option value="prioridade" <?php echo $prioridadeSelected; ?>>Prioridade</option>
        <option value="data_adicionada" <?php echo $dataAdicionadaSelected; ?>>Data de criação das tarefas</option>
    </select>
<br>
    <button class="btn btn-primary" type="submit">Listar tarefas</button>
</form>


<?php
    // Configurações do banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bd_gerenciador";

    // Conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtém a opção de ordenação escolhida
        $sortOption = $_POST['sortOption'];

    // Consulta SQL para obter as tarefas ordenadas
    if ($sortOption == "prioridade") {
        $sql = "SELECT * FROM tarefas ORDER BY
            CASE
                WHEN prioridade = 'alta' THEN 1
                WHEN prioridade = 'media' THEN 2
                WHEN prioridade = 'baixa' THEN 3
                ELSE 4 END";
    } elseif ($sortOption == "data_adicionada") {
        $sql = "SELECT * FROM tarefas ORDER BY data_adicionada";
    }

        $result = $conn->query($sql);

        // Exibe as tarefas
       if ($result->num_rows > 0) {
        echo "<form action='marcar_tarefa.php' method='post'>";
        echo "<table class='table table-striped'>"; // Adicionei 'table-striped' para listras na tabela
        echo "<thead>";
        echo "<tr>";
        echo "<th>Status</th>";  // Coluna Status vem primeiro
        echo "<th>Tarefa</th>";
        echo "<th>Descrição</th>";
        echo "<th>Data de Vencimento</th>";
        echo "<th>Criada em</th>";
        echo "<th>Ações</th>";  // Coluna Ações vem por último
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . ($row["status"] == 'concluida' ? 'Concluída' : 'Não concluída') . "</td>";  // Coluna Status
            echo "<td>" . $row["titulo"] . "</td>";
            echo "<td>" . $row["descricao"] . "</td>";
            echo "<td>" . $row["data_vencimento"] . "</td>"; // Adicionado campo de Data de Vencimento
            echo "<td>" . $row["data_adicionada"] . "</td>";
            echo "<td>
                    <a href='excluir.php?id_tarefa=" . $row['id_tarefa'] . "'>Excluir</a>
                    <a href='alterar.php?id_tarefa=" . $row['id_tarefa'] . "'>Alterar</a>
                    <a href='concluir.php?id_tarefa=" . $row['id_tarefa'] . "'>Concluir</a>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "<br><br>";
        echo "<a class='btn btn-primary' href='inserir.php' role='button'>Voltar</a>";
        echo "</form>";
    } else {
        echo "Nenhuma tarefa encontrada.";
    }
    }
    // Fecha a conexão com o banco de dados
    $conn->close();
    ?>

</div>
</body>
</html>
