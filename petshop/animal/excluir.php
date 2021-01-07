<?php

require '../db.php';

// obtém corpo do formulário das espécies
$id = isset($_GET['id']) ? $_GET['id'] : null;

// valida os dados do formulário
if (!$id) {
  header('Location: /animal?erroValidacaoExcluirAnimal=sim');
  exit;
}

$query = $database->prepare('DELETE FROM animais WHERE id = ?');
$query->bindParam(1, $id);
$query->execute();

header('Location: /animal?excluirAnimalSucesso=sim');
exit;
