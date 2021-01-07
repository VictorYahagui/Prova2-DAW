<?php

require '../db.php';

// verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /especie');
  exit;
}

// obtém corpo do formulário das espécies
$id = isset($_POST['id']) ? $_POST['id'] : null;
$descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;

// valida os dados do formulário
if (!$id || !$descricao || strlen($descricao) === 0) {
  header('Location: /especie?erroValidacaoEditarEspecie=sim');
  exit;
}

// atualiza espécie no banco de dados
$query = $database->prepare('UPDATE especies SET descricao = ? WHERE id = ?');
$query->bindParam(1, $descricao);
$query->bindParam(2, $id);
$query->execute();

header('Location: /especie?editarEspecieSucesso=sim');
