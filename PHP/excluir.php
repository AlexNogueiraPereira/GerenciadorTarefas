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

        //verifica a conexão
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
            echo '<input type="submit" name="confirmar" value="Confirmar Exclusão">';
            echo '</form>';
        } else {
            echo "Tarefa não encontrada.";
        }

    //fecha a conexão
    $conn->close();

} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    //verifica se o formulário foi enviado
    $id_tarefa = $_POST['id_tarefa'];
    $sql_delete = "DELETE FROM tarefas WHERE id_tarefa = $id_tarefa";

    //conecta ao banco de dados
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
            echo "Tarefa excluída com sucesso.";
            echo "<br><a href='exibir.php'><button>Voltar</button></a>";
        } else {
            echo "Erro ao excluir tarefa: " . $conn->error;
        }

    //fecha a conexão após a exclusão
    $conn->close();

} else {
    echo "ID não fornecido.";
}
?>
