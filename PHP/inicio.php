<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<h1>Adicionar Tarefa</h1>
	<center><hr class="red-hr"></center>

	<form action="inicio.php" method="post">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>
        <br>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="4" required></textarea>
        <br>

        <label for="data_vencimento">Data de Vencimento:</label>
        <input type="date" id="data_vencimento" name="data_vencimento" required>
        <br>

        <label for="prioridade">Nível de prioridade:</label>
        <select id="prioridade" name="escolha">  
            <option value="baixo">Baixo</option>
            <option value="medio">Médio</option>
            <option value="alto">Alto</option>
        </select>

        <input type="submit" value="Adicionar Tarefa">
    </form>

    <?php
        //configurações do banco de dados
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bd_gerenciador";

        //realizando a conexão com o banco de dados
        $conn = new mysqli($servername, $username, $password, $dbname);

            //verificando a conexão
            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }

        //verificando se o formulário foi enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // obtendo os dados do formulário e validando/sanitizando
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
                echo "Tarefa adicionada com sucesso!";
            } else {
                echo "Erro ao adicionar tarefa: " . $stmt->error;
            }
        }

        //fechando a conexão com o banco de dados
        $conn->close();

        //função para validar e sanitizar os dados
        function validateAndSanitize($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
        return $data;
        }
?>
</body>
</html>


