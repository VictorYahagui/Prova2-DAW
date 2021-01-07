<?php

require '../db.php';

$especies = $database->query('SELECT * FROM especies ORDER BY descricao ASC');
$animais = $database->query('SELECT animais.*, especies.descricao as especie FROM animais INNER JOIN especies ON especies.id = animais.especie_id ORDER BY id DESC');

$especiesArray = [];

while ($especie = $especies->fetch(PDO::FETCH_OBJ)) {
  $especiesArray[] = $especie;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Petshop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
  <div class="container py-5">
    <h1 class="mb-4">Animais</h1>

    <?php if (isset($_GET['novoAnimalSucesso'])) { ?>
      <div class="alert alert-success alert-dismissible fade show">
        Novo animal salvo com sucesso!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php } ?>
    <?php if (isset($_GET['editarAnimalSucesso'])) { ?>
      <div class="alert alert-success alert-dismissible fade show">
        Animal atualizado com sucesso!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php } ?>
    <?php if (isset($_GET['excluirAnimalSucesso'])) { ?>
      <div class="alert alert-success alert-dismissible fade show">
        Animal excluído com sucesso!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php } ?>

    <?php if (isset($_GET['erroValidacaoNovoAnimal'])) { ?>
      <div class="alert alert-danger alert-dismissible fade show">
        Por favor, preencha o formulário de novo animal corretamente para continuar.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php } ?>
    <?php if (isset($_GET['erroValidacaoEditarAnimal'])) { ?>
      <div class="alert alert-danger alert-dismissible fade show">
        Por favor, preencha o formulário de editar animal corretamente para continuar.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php } ?>
    <?php if (isset($_GET['erroValidacaoExcluirAnimal'])) { ?>
      <div class="alert alert-danger alert-dismissible fade show">
        Não foi possível excluir o animal informado, tente novamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php } ?>

    <div class="d-flex mb-2">
      <a href="/" class="btn btn-clear-primary me-3">Voltar</a>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#novoAnimalModal">Novo animal</button>
    </div>
    <hr>

    <table class="table table-striped table-bordered align-middle mt-2">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Dono</th>
          <th>Espécie</th>
          <th>Raça</th>
          <th>Nascimento</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($animal = $animais->fetch(PDO::FETCH_OBJ)) { ?>
          <tr>
            <td><?php echo $animal->id; ?></td>
            <td><?php echo $animal->nome; ?></td>
            <td><?php echo $animal->dono; ?></td>
            <td><?php echo $animal->especie; ?></td>
            <td><?php echo $animal->raca; ?></td>
            <td>
              <?php
              $dataNascimento = date_create($animal->data_nascimento);
              echo date_format($dataNascimento, 'd/m/Y');
              ?>
            </td>
            <td style="width: 140px">
              <div class="d-flex gap-1 justify-content-center">
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editarAnimalModal-<?php echo $animal->id; ?>">Editar</button>
                <a href="/animal/excluir.php?id=<?php echo $animal->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Você tem certeza que deseja excluir este animal?');">Excluir</a>
              </div>
            </td>
          </tr>
          <div class="modal fade" id="editarAnimalModal-<?php echo $animal->id; ?>">
            <div class="modal-dialog">
              <form action="/animal/editar.php" method="post">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar animal: <?php echo $animal->nome; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $animal->id; ?>">
                    <div class="form-group mb-2">
                      <label for="txtNome">Nome do animal</label>
                      <input type="text" name="nome" id="txtNome" class="form-control" placeholder="Ex.: Bob" value="<?php echo $animal->nome; ?>" required>
                    </div>
                    <div class="form-group mb-2">
                      <label for="txtDono">Dono do animal</label>
                      <input type="text" name="dono" id="txtDono" class="form-control" placeholder="Ex.: João" value="<?php echo $animal->
                      dono; ?>" required>
                    </div>
                    <div class="form-group mb-2">
                      <label for="comboEspecie">Espécie</label>
                      <select name="especie_id" id="comboEspecie" class="form-select" required>
                        <option value="">Selecione</option>
                        <?php foreach ($especiesArray as $especie) { ?>
                          <option value="<?php echo $especie->id; ?>" <?php if ($animal->especie_id === $especie->id) echo 'selected'; ?>><?php echo $especie->descricao; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group mb-2">
                      <label for="txtRaca">Raça</label>
                      <input type="text" name="raca" id="txtRaca" class="form-control" placeholder="Ex.: Pinscher" value="<?php echo $animal->raca; ?>" required>
                    </div>
                    <div class="form-group mb-2">
                      <label for="dtNascimento">Data de nascimento</label>
                      <input type="date" name="data_nascimento" id="dtNascimento" class="form-control" value="<?php echo $animal->data_nascimento; ?>" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="reset" class="btn" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Atualizar animal</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <div class="modal fade" id="novoAnimalModal">
    <div class="modal-dialog">
      <form action="/animal/salvar.php" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Novo animal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="form-group mb-2">
              <label for="txtNome">Nome do animal</label>
              <input type="text" name="nome" id="txtNome" class="form-control" placeholder="Ex.: Bob" required>
            </div>
            <div class="form-group mb-2">
              <label for="txtDono">Dono do animal</label>
              <input type="text" name="dono" id="txtDono" class="form-control" placeholder="Ex.: João" required>
            </div>
            <div class="form-group mb-2">
              <label for="comboEspecie">Espécie</label>
              <select name="especie_id" id="comboEspecie" class="form-select" required>
                <option value="">Selecione</option>
                <?php foreach ($especiesArray as $especie) { ?>
                  <option value="<?php echo $especie->id; ?>"><?php echo $especie->descricao; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group mb-2">
              <label for="txtRaca">Raça</label>
              <input type="text" name="raca" id="txtRaca" class="form-control" placeholder="Ex.: Pinscher" required>
            </div>
            <div class="form-group mb-2">
              <label for="dtNascimento">Data de nascimento</label>
              <input type="date" name="data_nascimento" id="dtNascimento" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar animal</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>
