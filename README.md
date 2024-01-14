# GerenciadorTarefas

Este é um gerenciador de tarefas bem simples desenvolvido em PHP, MySQL, HTML e CSS (e Bootstrap). Ele permite que você adicione, edite, exclua, conclua e liste tarefas.


## Requisitos

- Servidor web (por exemplo, Apache)
- PHP
- MySQL


## Configuração do Banco de Dados

1. Crie um banco de dados MySQL chamado `bd_gerenciador`.
2. Importe o arquivo `database.sql` para criar a tabela necessária.

```bash
$ mysql -u seu_usuario -p bd_gerenciador < database.sql
```


## Configuração do Projeto
1. Clone o repositório:

```bash
$ git clone https://github.com/seu-usuario/gerenciador-de-tarefas.git
$ cd gerenciador-de-tarefas
```


2. Configure as informações do banco de dados em conexao.php:

$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "bd_gerenciador";


## Uso
1. Abra o projeto em seu servidor web.
2. Acesse http://localhost/GerenciadorTarefas/.


## Funcionalidades
1. Adicionar uma nova tarefa.
2. Editar uma tarefa existente.
3. Excluir uma tarefa.
4. Marcar uma tarefa como concluída.
5. Listar tarefas ordenadas por prioridade ou data de criação.


## Contribuição
Sinta-se à vontade para contribuir para este projeto. Abra uma issue para relatar problemas ou envie um pull request com melhorias :)


## Licença
Este projeto está licenciado sob a Licença MIT.
