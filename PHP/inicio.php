<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/estilo.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Gerenciador de Tarefas</title>

      <style>

        .container-color, .bemvindo{
            background-color: #f8f8f8;
            font-family:;
            padding: 20px;
            width: 100%;
            max-width: 100%;
            margin: 20px auto;
            height: 100%;
        }

        .borda {
            border: 1px solid #ccc; /* Cor e estilo da borda */
            border-radius: 5px; /* Borda arredondada */
            padding: 20px; 
            margin: 20px auto;
            max-width: 100%; 
        }

        .navbar-custom {
        	background-color: red;
        }

    </style>
</head>
<body> 

        <div class="container-fluid navbar navbar-expand-lg navbar-light navbar-custom">
        <a class="navbar-brand" href="#">Gerenciador de Tarefas</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="inicio.php">Inserir Tarefa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="listar.php">Listar Tarefas</a>
                </li>
            </ul>
        </div>
    </div>  

    <div class="container mx-auto container-color">
    <div class="row">
        <div class="col-md-6">
            <!-- Quadro de Bem-Vindo -->
            <div class="bemvindo">
                <h3>Bem-vindo ao seu Gerenciador de Tarefas</h3>
            </div>
        </div>

        <div class="col-md-6">
     <div class="container mx-auto container-color text-center">

        <center><h2>Inserir Tarefa</h2></center>

        <form class="borda"action="inicio.php" method="post">
        <table class="mx-auto">

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
        <br>
        <button class="btn btn-primary" type="submit">Adicionar Tarefa</button>
        <a class="btn btn-primary" href="exibir.php" role="button">Listar Tarefas</a>
    </form>
        
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


 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEX0fAz4lF2Rx4A3Cq5axrV+5SEFhY6F5MI5W" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
