<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<form action="listar.php" method="get">
    <label for="escolha">Escolha a ordem de ordenação das tarefas:</label>
    <select name="campo_ordenacao" id="campo_ordenacao">
        <option value="id">Data de criação</option>
        <option value="nome">Prioridade</option>
    </select>

    <input type="submit" value="Ordenar">
</body>
</html>