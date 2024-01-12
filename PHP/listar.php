<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Tarefas</title>
</head>
<body>

    <h2>Listagem de Tarefas</h2>

    <form action="listar.php" method="post">
    <label for="escolha">Ordenar por:</label>
    <select id="escolha" name="escolha">
        <?php
            $prioridadeSelected = ($escolha == 'prioridade') ? 'selected' : '';
            $dataAdicionadaSelected = ($escolha == 'data_adicionada') ? 'selected' : '';
        ?>
        <option value="prioridade" <?php echo $prioridadeSelected; ?>>Prioridade</option>
        <option value="data_adicionada" <?php echo $dataAdicionadaSelected; ?>>Data de criação das tarefas</option>
    </select>

    <br><br>

    <input type="submit" value="Listar Tarefas">
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
        $escolha = $_POST['escolha'];

    // Consulta SQL para obter as tarefas ordenadas
    if ($escolha == "prioridade") {
        $sql = "SELECT * FROM tarefas ORDER BY
            CASE
                WHEN prioridade = 'alta' THEN 1
                WHEN prioridade = 'media' THEN 2
                WHEN prioridade = 'baixa' THEN 3
                ELSE 4 END";
    } elseif ($escolha == "data_adicionada") {
        $sql = "SELECT * FROM tarefas ORDER BY data_adicionada";
    }

        $result = $conn->query($sql);

        // Exibe as tarefas
    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li><strong>Tarefa:</strong> " . $row["titulo"] . " - <strong>Descrição:</strong> " . $row["descricao"] . " - <strong>Prioridade:</strong> " . $row["prioridade"] . " - <strong>Tarefa criada em:</strong> " . $row["data_adicionada"] . 
                " - <a href='excluir.php?id=" . $row['id_tarefa'] . "'>Excluir</a> - <a href='alterar.php?id=" . $row['id_tarefa'] . "'>Alterar</a> - <a href='concluir.php?id=" . $row['id_tarefa'] . "'>Concluir</a></li>";
        }
        echo "</ul>";
    } else {
        echo "Nenhuma tarefa encontrada.";
    }
}

    // Fecha a conexão com o banco de dados
    $conn->close();
    ?>

    <br>
    <a href="inserir.php"><button>Voltar</button></a>

</body>
</html>
