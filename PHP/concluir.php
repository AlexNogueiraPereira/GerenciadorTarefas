<?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_tarefa'])) {
        $id_tarefa = $_GET['id_tarefa'];

        // configurando o banco de dados
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bd_gerenciador";

        // conexão com o banco de dados
        $conn = new mysqli($servername, $username, $password, $dbname);

        // verificando a conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // comando de atualização do status da tarefa para "concluida"
        $stmt = $conn->prepare("UPDATE tarefas SET status = 'concluida' WHERE id_tarefa = ?");
        
        //verifica se a preparação ocorreu bem
        if ($stmt === false) {
            die("Erro na preparação da instrução SQL: " . $conn->error);
        }

        //"bind" do parâmetro
        $stmt->bind_param("i", $id_tarefa);

        //executando a instrução preparada
        if ($stmt->execute()) {
            echo "Tarefa concluída com sucesso!";
            echo "<br><a href='exibir.php'><button>Voltar</button></a>";
        } else {
            echo "Erro ao concluir tarefa: " . $stmt->error;
        }

        //fechando o statement e a conexão
        $stmt->close();
        $conn->close();
    } else {
        echo "ID da tarefa não fornecido.";
    }
?>
