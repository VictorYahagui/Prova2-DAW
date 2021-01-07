<?php

require '../db.php';

// obtém corpo do formulário das espécies
$id = isset($_GET['id']) ? $_GET['id'] : null;

// valida os dados do formulário
if (!$id) {
  header('Location: /especie?erroValidacaoExcluirEspecie=sim');
  exit;
}

try {
  $query = $database->prepare('DELETE FROM especies WHERE id = ?');
  $query->bindParam(1, $id);
  $query->execute();
} catch (PDOException $error) {
  $erroExcluir = 1;
  
  if ($error->getCode() == 23000) {
    $erroExcluir = 2; // erro para quando possui animais associados à espécie
  }

  header('Location: /especie?excluirEspecieException=' . $erroExcluir);
  exit;
}

header('Location: /especie?excluirEspecieSucesso=sim');
exit;
