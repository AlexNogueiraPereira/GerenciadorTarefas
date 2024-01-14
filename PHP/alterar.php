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

        // Preencha as variáveis com os valores existentes
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Editar Tarefa</title>
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
                    <a class="nav-link text-light" href="inicio.php">Inserir Tarefa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="exibir.php">Listar Tarefas</a>
                </li>
            </ul>
        </div>
    </div>  

    <div class="container mx-auto container-color">

    <form action="atualizar.php" method="post">
            <center><h2>Editar Tarefa</h2></center>
        <table class="mx-auto">

        <tr>
            <td><input type="hidden" name="id_tarefa" value="<?php echo $id_tarefa; ?>"> </td>
        </tr>

        <tr>
            <td><label for="titulo">Título:</label></td>
            <td><input type="text" id="titulo" name="titulo" value="<?php echo $titulo; ?>" required></td>
        </tr>

        <br>

        <tr>
            <td><label for="descricao">Descrição:</label></td>
            <td><textarea id="descricao" name="descricao" rows="4" required><?php echo $descricao; ?></textarea></td>
        </tr>

        <br>

        <tr>
            <td><label for="data_vencimento">Data de Vencimento:</label></td>
            <td><input type="date" id="data_vencimento" name="data_vencimento" value="<?php echo $data_vencimento; ?>" required></td>
        </tr>

        <br>

        <tr>
           <td><label for="prioridade">Nível de prioridade:</label></td>
            <td><select id="prioridade" name="prioridade">
                <option value="baixa" <?php echo ($prioridade == 'baixa') ? 'selected' : ''; ?>>Baixa</option>
                <option value="media" <?php echo ($prioridade == 'media') ? 'selected' : ''; ?>>Média</option>
                <option value="alta" <?php echo ($prioridade == 'alta') ? 'selected' : ''; ?>>Alta</option>
            </select></td>
     </tr>

        <br>

        <tr>
           <td><button class="btn btn-primary" type="submit">Atualizar tarefa</button></td>
           <td><a class='btn btn-primary' href='inserir.php' role='button'>Voltar</a></td>
       </tr>
        </table>
    </form>
    <br><br>
    
</div>
</body>
</html>
