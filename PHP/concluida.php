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

    //atualiza o status da tarefa para "concluida"
    $stmt = $conn->prepare("UPDATE tarefas SET status = 'concluida' WHERE id_tarefa = ?");
    
        // Verifica se a preparação foi bem-sucedida
        if ($stmt === false) {
            die("Erro na preparação da instrução SQL: " . $conn->error);
        }

    //bind do parâmetro
    $stmt->bind_param("i", $id_tarefa);

        //executa a instrução preparada
        if ($stmt->execute()) {
            echo "Tarefa concluída com sucesso!";
            echo "<br><a href='exibir.php'><button>Voltar</button></a>";
        } else {
            echo "Erro ao concluir tarefa: " . $stmt->error;
        }

    //fecha o statement e a conexão
    $stmt->close();
    $conn->close();
    
} else {
    echo "ID da tarefa não fornecido.";
}
?>
