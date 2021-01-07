<?php

require '../db.php';

// verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /animal');
  exit;
}

// obtém corpo do formulário do animal
$nome = isset($_POST['nome']) ? $_POST['nome'] : null;
$dono = isset($_POST['dono']) ? $_POST['dono'] : null;
$especie = isset($_POST['especie_id']) ? $_POST['especie_id'] : null;
$raca = isset($_POST['raca']) ? $_POST['raca'] : null;
$dataNascimento = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : null;

// valida os dados do formulário
if (!$nome || !$dono || !$especie || !$raca || !$dataNascimento) {
  header('Location: /animal?erroValidacaoNovoAnimal=sim');
  exit;
}

// cria novo animal no banco de dados
$query = $database->prepare('INSERT INTO animais (nome, dono, especie_id, raca, data_nascimento) VALUES (?, ?, ?, ?, ?)');
$query->bindParam(1, $nome);
$query->bindParam(2, $dono);
$query->bindParam(3, $especie);
$query->bindParam(4, $raca);
$query->bindParam(5, $dataNascimento);
$query->execute();

header('Location: /animal?novoAnimalSucesso=sim');
