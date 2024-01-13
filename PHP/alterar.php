<?php
if (isset($_GET['id_tarefa']) && is_numeric($_GET['id_tarefa'])) {
    $id_tarefa = $_GET['id_tarefa'];

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

    // Consulta SQL para obter detalhes da tarefa
    $sql = "SELECT * FROM tarefas WHERE id_tarefa = $id_tarefa";
    $result = $conn->query($sql);

    // Verifica se a tarefa existe
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Preenche as variáveis com os valores existentes
        $titulo = $row['titulo'];
        $descricao = $row['descricao'];
        $data_vencimento = $row['data_vencimento'];
        $prioridade = $row['prioridade'];

        // Fecha a conexão com o banco de dados
        $conn->close();
    } else {
        echo "Tarefa não encontrada.";
        exit;
    }
} else {
    echo "ID da tarefa não fornecido.";
    exit;
}
?>