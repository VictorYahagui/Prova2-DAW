<?php

require '../db.php';

$especies = $database->query('SELECT * FROM especies ORDER BY id DESC');

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
    <h1 class="mb-4">Espécies</h1>

    <?php if (isset($_GET['novaEspecieSucesso'])) { ?>
      <div class="alert alert-success alert-dismissible fade show">
        Nova espécie salva com sucesso!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php } ?>
    <?php if (isset($_GET['editarEspecieSucesso'])) { ?>
      <div class="alert alert-success alert-dismissible fade show">
        Espécie atualizada com sucesso!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php } ?>
    <?php if (isset($_GET['excluirEspecieSucesso'])) { ?>
      <div class="alert alert-success alert-dismissible fade show">
        Espécie excluída com sucesso!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php } ?>

    <?php if (isset($_GET['erroValidacaoNovaEspecie'])) { ?>
      <div class="alert alert-danger alert-dismissible fade show">
        Por favor, preencha o formulário de nova espécie corretamente para continuar.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php } ?>
    <?php if (isset($_GET['erroValidacaoEditarEspecie'])) { ?>
      <div class="alert alert-danger alert-dismissible fade show">
        Por favor, preencha o formulário de editar espécie corretamente para continuar.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php } ?>
    <?php if (isset($_GET['erroValidacaoExcluirEspecie'])) { ?>
      <div class="alert alert-danger alert-dismissible fade show">
        Não foi possível excluir a espécie informada, tente novamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php } ?>
    <?php if (isset($_GET['excluirEspecieException'])) { ?>
      <div class="alert alert-danger alert-dismissible fade show">
        <?php echo $_GET['excluirEspecieException'] == 1 ? 'Houve um erro interno ao excluir a espécie, tente novamente.' : 'Não foi possível excluir a espécie pois há animais associados à ela. Remova as associações e tente novamente.' ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php } ?>

    <div class="d-flex mb-2">
      <a href="/" class="btn btn-clear-primary me-3">Voltar</a>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#novaEspecieModal">Nova espécie</button>
    </div>
    <hr>

    <table class="table table-striped table-bordered align-middle mt-2">
      <thead>
        <tr>
          <th>ID</th>
          <th>Descrição</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($especie = $especies->fetch(PDO::FETCH_OBJ)) { ?>
          <tr>
            <td><?php echo $especie->id; ?></td>
            <td><?php echo $especie->descricao; ?></td>
            <td style="width: 140px">
              <div class="d-flex gap-1 justify-content-center">
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editarEspecieModal-<?php echo $especie->id; ?>">Editar</button>
                <a href="/especie/excluir.php?id=<?php echo $especie->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Você tem certeza que deseja excluir esta espécie?');">Excluir</a>
              </div>
            </td>
          </tr>
          <div class="modal fade" id="editarEspecieModal-<?php echo $especie->id; ?>">
            <div class="modal-dialog">
              <form action="/especie/editar.php" method="post">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar espécie: <?php echo $especie->descricao; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $especie->id; ?>">
                    <div class="form-group">
                      <label for="txtDescricao">Descrição da espécie</label>
                      <input type="text" name="descricao" id="txtDescricao" class="form-control" placeholder="Ex.: Gato" value="<?php echo $especie->descricao; ?>" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="reset" class="btn" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Atualizar espécie</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <div class="modal fade" id="novaEspecieModal">
    <div class="modal-dialog">
      <form action="/especie/salvar.php" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nova espécie</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="txtDescricao">Descrição da espécie</label>
              <input type="text" name="descricao" id="txtDescricao" class="form-control" placeholder="Ex.: Gato" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar espécie</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>
