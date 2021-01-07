<?php

require '../db.php';

// verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /especie');
  exit;
}

// obtém corpo do formulário das espécies
$descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;

// valida os dados do formulário
if (!$descricao || strlen($descricao) === 0) {
  header('Location: /especie?erroValidacaoNovaEspecie=sim');
  exit;
}

// cria nova espécie no banco de dados
$query = $database->prepare('INSERT INTO especies (descricao) VALUES (?)');
$query->bindParam(1, $descricao);
$query->execute();

header('Location: /especie?novaEspecieSucesso=sim');
