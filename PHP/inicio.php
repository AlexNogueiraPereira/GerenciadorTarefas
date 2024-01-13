<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/estilo.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Gerenciador de Tarefas</title>
</head>
<body>
    <div class='conteiner'>
    <h2>Inserir Tarefa</h2>
    <form action="inserir.php" method="post">
        <table width="100%">

            <tr>
                <td><label for="titulo">Título:</label></td>
                <td> <input type="text" id="titulo" name="titulo" required></td>
            </tr>

            <tr>
                <td><label for="descricao">Descrição:</label></td>
                <td><textarea id="descricao" name="descricao" rows="4" required></textarea></td>
            </tr>

            <tr>
                <td><label for="data_vencimento">Data de Vencimento:</label></td>
                <td><input type="date" id="data_vencimento" name="data_vencimento" required></td>
            </tr>

            <tr>
                <td><label for="prioridade">Nível de prioridade:</label></td>
                <td><select id="prioridade" name="prioridade">  
                    <option value="baixa">Baixa</option>
                    <option value="media">Média</option>
                    <option value="alta">Alta</option>
                </select> </td>
            </tr>
        </table>

        <input type="submit" value="Adicionar Tarefa">    
    </form>
        <a href="exibir.php"><button>Listar Tarefas</button></a>
        <br>
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
            // Obtém os dados do formulário e valida/sanitiza
            $titulo = isset($_POST['titulo']) ? validateAndSanitize($_POST['titulo']) : "";
            $descricao = isset($_POST['descricao']) ? validateAndSanitize($_POST['descricao']) : "";
            $data_vencimento = isset($_POST['data_vencimento']) ? validateAndSanitize($_POST['data_vencimento']) : "";
            $prioridade = isset($_POST['prioridade']) ? validateAndSanitize($_POST['prioridade']) : "";
            $data_adicionada = date("Y-m-d H:i:s");

            // Usando "prepared statement" para preparar a instrução SQL que irá inserir dados 
            $stmt = $conn->prepare("INSERT INTO tarefas (titulo, descricao, data_vencimento, prioridade, data_adicionada) VALUES (?, ?, ?, ?, ?)");

            // Verifica se a preparação foi bem-sucedida
            if ($stmt === false) {
                die("Erro na preparação da instrução SQL: " . $conn->error);
            }

            // Bind dos parâmetros
            $stmt->bind_param("sssss", $titulo, $descricao, $data_vencimento, $prioridade, $data_adicionada);

            // Executando a instrução agora preparada
            if ($stmt->execute()) {
                echo "<div class='alert alert-success' role='alert'>";
                echo "Tarefa adicionada com sucesso!";
                echo "</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>";
                echo "Erro ao adicionar tarefa: " . $stmt->error;
                echo "</div>";
            }
        }


        //fechando a conexão com o banco de dados
        $conn->close();

        // Função para validar e sanitizar dados
        function validateAndSanitize($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
        return $data;
        }
?>
</div>
</body>
</html>
