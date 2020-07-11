<!doctype html>
<html lang="pt-BR" class="h-100">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="robots" content="noindex, nofollow">
  <title>Error <?= $code ?> | Erro no banco de dados!</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<body class="h-100 d-flex align-items-center justify-content-center">

  <div class="text-center">
    <h1 class="display-1 text-muted"><?= $code ?></h1>
    <h2 class="display-5 text-muted">Erro no banco de dados!</h2>
    <?php require_once $viewPath; ?>
    <p class="alert alert-danger mt-3" style="font-size:13px;"><?= $message ?></p>
    <table class="table table-striped table-bordered mt-5">
      <thead>
        <tr>
          <th>File</th>
          <th>Método</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($trace as $data) {
          echo "<tr>";
          echo "<td>".($data['file'] ?? '').($data['line']? ":{$data['line']}": '')."</td>";
          echo "<td>".($data['class'] ?? '').($data['type'] ?? ' ').($data['function'])."</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

</body>

</html>
